<?php
/**
 * Description of character_model
 *
 * @author aquilax
 */
class Character_model extends Model {

  var $t_character = 'Character';
  var $t_memb_stat = 'memb_stat';

  function Character_model(){
    parent::Model();
    $this->t_character = $this->config->item('t_character');
    $this->t_memb_stat = $this->config->item('t_memb_stat');
  }

  function getCharactersForAccount($name){
    $this->db->select('name,class,clevel,resets,money,strength,dexterity,vitality,energy,mapnumber,accountid');
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
    $this->db->select('clevel,resets,money,leveluppoint,class');
    $this->where('accountid', $uid);
    $this->where('name', $cname);
    $query = $this->db->get($this->t_character, 1);
    return $query->result_array();
  }

  function resetCharacter($cname, $status){
    $resetmode = $this->config->item('resetmode');
    $levelupmode = $this->config->item('resetmode');
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
    if ($status['clevel'] >= $resetslimit){
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
}
?>