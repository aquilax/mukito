<?php
/**
 * Description of character_model
 *
 * @author aquilax
 */
class Character_model extends Model {

  var $t_character = 'Character';
  var $t_memb_stat = 'memb_stat';
  var $has_DL = 0; //if game supports Dark Lord

  function Character_model(){
    parent::Model();
    $this->t_character = $this->config->item('t_character');
    $this->t_memb_stat = $this->config->item('t_memb_stat');
  }

  function _getDL(){
    if ($this->has_DL === 0){
      $this->db->where('class', 64);
      $res = $this->db->count_all_results($this->t_character);
      if ($res == 0){
        $this->has_DL = FALSE;
      } else {
        $this->has_DL = TRUE;
      }
    }
    return $this->has_DL;
  }

  function getCharactersForAccount($name){
    if ($this->_getDL()){
      $this->db->select('name,class,clevel,resets,money,strength,dexterity,vitality,energy,leadership,mapnumber,accountid');
    } else {
      $this->db->select('name,class,clevel,resets,money,strength,dexterity,vitality,energy,mapnumber,accountid');
    }
    $this->db->where('AccountID', $name);
    $this->db->order_by('Resets', 'desc');
    $this->db->order_by('cLevel', 'desc');
    $query = $this->db->get($this->t_character);
    $ary = $query->result_array();
    $c = count($ary);
    for ($i = 0; $i < $c; $i++){
      //This can be optimized (join connectstat)
      $ary[$i]['is_online'] = $this->getCharacterIsOnline($ary[$i]['name']);
      $ary[$i]['can_reset'] = $this->canReset($ary[$i]);
    }
    return $ary;
  }

  function getCharacterIsOnline($cname){
    $this->db->select('connectstat');
    $this->db->where('memb___id', $cname);
    $query = $this->db->get($this->t_memb_stat, 1);
    if ($query->num_rows() ==0){
      return FALSE;
    } else {
      $ary = $query->row_array();
      return $ary['connectstat'] == 1;
    }
  }

  function getCharStatus($cname, $uid){
    if ($this->_getDL()){
      $this->db->select('clevel,resets,money,name,leveluppoint,class,strength,dexterity,vitality,energy,leadership');
    } else {
      $this->db->select('clevel,resets,money,name,leveluppoint,class,strength,dexterity,vitality,energy');
    }
    $this->db->where('accountid', $uid);
    $this->db->where('name', $cname);
    $query = $this->db->get($this->t_character, 1);
    $ary = $query->row_array();
    if ($ary){
      $ary['is_online'] = $this->getCharacterIsOnline($cname);
    }
    return $ary;
  }

  function resetCharacter($cname, $status){
    $resetmode = $this->config->item('resetmode');
    $levelupmode = $this->config->item('levelupmode');
    $clean_inventory = $this->config->item('clean_inventory');
    $clean_skills = $this->config->item('clean_skills');

    $resetmoney = $this->config->item('resetmoney');
    $resetpoints = $this->config->item('resetpoints');

    if(($resetmode == 'keep') AND ($levelupmode == 'normal')){
      $sql_reset_script="UPDATE ".$this->t_character." SET
                        clevel='1',
                        experience='0',
                        money=money-".$resetmoney.",
                        LevelUpPoint=LevelUpPoint+".$resetpoints.",
                        resets=resets+1
                        WHERE name=?";
    } elseif (($resetmode =='reset') AND ($levelupmode =='extra')){
      $sql_reset_script="UPDATE ".$this->t_character." SET
                        strength='25',
                        dexterity='25',
                        vitality='25',
                        energy='25',
                        clevel='1',
                        experience='0',
                        money=money-".$resetmoney.",
                        LevelUpPoint=LevelUpPoint+".$resetpoints.",
                        resets=resets+1
                        WHERE name=?";
    } elseif (($resetmode == 'keep') AND ($levelupmode =='extra')){
      $sql_reset_script="UPDATE ".$this->t_character." SET
                        clevel='1',
                        experience='0',
                        money=money-".$resetmoney.",
                        LevelUpPoint= (clevel+1)*".$resetpoints.",
                        resets=resets+1
                        WHERE name=?";
    } elseif(($resetmode == 'reset') AND ($levelupmode =='normal')){
      $sql_reset_script="UPDATE ".$this->t_character." SET
                        strength='25',
                        dexterity='25',
                        vitality='25',
                        energy='25',
                        clevel='1',
                        experience='0',
                        money=money-".$resetmoney.",
                        LevelUpPoint=LevelUpPoint+".$resetpoints.",
                        resets=resets+1
                        WHERE name=?";
    }

    if($clean_inventory == 'yes' && $clean_skills == 'yes'){
       $sql_reset_script2="UPDATE ".$this->t_character." SET
                          inventory=CONVERT(varbinary(1080), null),
                          magiclist= CONVERT(varbinary(180), null)
                          WHERE name=?";
    } elseif($clean_inventory == 'no' && $clean_skills == 'no'){
      $sql_reset_script2="SELECT name FROM ".$this->t_character." WHERE name=?";
    } elseif($clean_inventory == 'yes' && $clean_skills == 'no'){
      $sql_reset_script2="UPDATE ".$this->t_character." SET
                          inventory=CONVERT(varbinary(1080), null)
                          WHERE name=?";
    } elseif($clean_inventory == 'no' && $clean_skills == 'yes'){
      $sql_reset_script2="UPDATE ".$this->t_character." SET
                          magiclist= CONVERT(varbinary(180), null)
                          WHERE name=?";
    }
    
    $this->db->query($sql_reset_script, array($cname));
    $this->db->query($sql_reset_script2, array($cname));
    return array(sprintf(lang('Character %s is reset successfully'), $cname));
  }

  function canReset($status, $only_status = TRUE){
    $resetmoney = $this->config->item('resetmoney');
    $resetlevel = $this->config->item('resetlevel');
    $resetlimit = $this->config->item('resetlimit');

    if (!$only_status){
      $ret = array();
    }
    if ($status['is_online']){
      if($only_status){
        return FALSE;
      }
      $ret[] = sprintf(lang('Character %s is Online. Must be Offlne to reset'), $status['name']);
    }
    if ($status['money'] < $resetmoney){
      if($only_status){
        return FALSE;
      }
      $ret[] = sprintf(lang('Character %s needs %d Zen to Reset'), $status['name'], $resetmoney);
    }
    if ($status['clevel'] < $resetlevel){
      if($only_status){
        return FALSE;
      }
      $ret[] = sprintf(lang('Character %s needs Level %d to Reset'), $status['name'], $resetlevel);
    }
    if ($status['clevel'] >= $resetlimit){
      if($only_status){
        return FALSE;
      }
      $ret[] = sprintf(lang('Resets limit is set to %s'), $resetlimit);
    }
    if($only_status){
      return TRUE;
    } else {
      return $ret;
    }
  }

  function addPonts($uid, $post, $status){
    $res = array();
    $cname = $status['name'];
    $strength = $post['strength'];
    $dexterity = $post['agility'];
    $vitality = $post['vitality'];
    $energy = $post['energy'];
    if (isset($status['leadership'])){
      $leadership = $post['command'];
    } else {
      $leadership = 0;
    }
    $denominator = $strength+$dexterity+$vitality+$energy+$leadership;
    if ($denominator > $status['leveluppoint']){
      $res[] = sprintf(lang('You have only %d points'), $status['leveluppoint']);
    }
    if ($status['is_online']){
      $ret[] = sprintf(lang('Character %s is Online. Must be Offlne to reset'), $status['name']);   
    }
    if ($status['strength']+$strength > 32500){
      $ret[] = sprintf(lang('Strength can go up to %d points only'), 32500);
    }
    if ( $status['dexterity']+$dexterity > 32500){
      $ret[] = sprintf(lang('Agility can go up to %d points only'), 32500);
    }
    if ($status['vitality']+$vitality > 32500){
      $ret[] = sprintf(lang('Vitality can go up to %d points only'), 32500);
    }
    if ($status['energy']+$energy > 32500){
      $ret[] = sprintf(lang('Energy can go up to %d points only'), 32500);
    }
    if ($status['leadership']-$leadership > 32500){
      $ret[] = sprintf(lang('Command can go up to %d points only'), 32500);
    }
    if (count($res) > 0){
      return $res;
    }
    //checks
    $this->db->where('accountid', $uid);
    $this->db->where('name', $cname);
    $data = array(
      'leveluppoint' => $status['leveluppoint']-$denominator,
      'strength' => $status['strength']+$strength,
      'dexterity' => $status['dexterity']+$dexterity,
      'vitality' => $status['vitality']+$vitality,
      'energy' => $status['energy']+$energy,
    );
    if (isset($status['leadership'])){
      $data['leadership'] = $status['leadership']+$leadership;
    }
    $this->db->update($this->t_character, $data);
    $res[] = sprintf(lang('New stats are set'));
    return $res;
  }
}
?>