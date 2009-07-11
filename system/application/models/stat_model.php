<?php
/**
 * Description of stat_model
 *
 * @author aquilax
 */
class Stat_model extends Model{

  var $t_character = 'Character';
  var $t_memb_stat = 'memb_stat';
  var $t_guild = 'guild';
  var $t_guildmember = 'guildmember';

  function Stat_model(){
    parent::Model();
    $this->t_character = $this->config->item('t_character');
    $this->t_memb_stat = $this->config->item('t_memb_stat');
    $this->t_guild = $this->config->item('t_guild');
    $this->t_guildmember = $this->config->item('t_guildmember');
  }

  function getTotalCharacters(){
    return $this->db->count_all($this->t_character);
  }

  function getCharactersByClass($id){
    $this->db->where('Class', $id);
    return $this->db->count_all_results($this->t_character);
  }

  function getCharactersByMap($id){
    $this->db->where('mapnumber', $id);
    return $this->db->count_all_results($this->t_character);
  }

  function getOnlineCharacters(){
    $this->db->where('connectstat', 1);
    return $this->db->count_all_results($this->t_memb_stat);
  }

  function getAll(){
    $res = array();
    $res['total_characters'] = $this->getTotalCharacters();
    $res['online_characters'] = $this->getOnlineCharacters();
    $res['race']['Dark Wizard'] = $this->getCharactersByClass(0);
    $res['race']['Fairy Elf'] = $this->getCharactersByClass(32);
    $res['race']['Dark Knight'] = $this->getCharactersByClass(16);
    $res['race']['Soul Master'] = $this->getCharactersByClass(1);
    $res['race']['Muse Elf'] = $this->getCharactersByClass(33);
    $res['race']['Blade Knight'] = $this->getCharactersByClass(17);
    $res['race']['Magic Gladiator'] = $this->getCharactersByClass(48);
    $res['race']['Dark Lord'] = $this->getCharactersByClass(64);
    $res['map']['Lorencia'] = $this->getCharactersByMap(0);
    $res['map']['Noria'] = $this->getCharactersByMap(3);
    $res['map']['Devias'] = $this->getCharactersByMap(2);
    $res['map']['Dungeon'] = $this->getCharactersByMap(1);
    $res['map']['Atlans'] = $this->getCharactersByMap(7);
    $res['map']['Lost Tower'] = $this->getCharactersByMap(4);
    $res['map']['Tarkan'] = $this->getCharactersByMap(8);
    $res['map']['Icarus'] = $this->getCharactersByMap(10);
    $res['map']['Arena'] = $this->getCharactersByMap(6);
    $res['map']['Aida'] = $this->getCharactersByMap(32);
    $res['map']['CryWolf'] = $this->getCharactersByMap(33);
    $res['map']['Valley Of Loren'] = $this->getCharactersByMap(31);
    return $res;
  }

  function getTopPlayers($limit, $race = FALSE){
    if($race){
      $this->db->where('class', $race);
    }
    $this->db->select('name, class, clevel, resets, strength, dexterity, vitality, energy, accountid');
    //TODO: Uncomment this
//    $this->db->where('ctlcode !=', 32);
//    $this->db->where('ctlcode !=', 8);
    $this->db->order_by('resets', 'desc');
    $this->db->order_by('clevel', 'desc');
    $query = $this->db->get($this->t_character, $limit);
    return $query->result_array();
  }

  function getTopGuilds($limit){
    $this->db->order_by('G_score', 'desc');
    $query = $this->db->get($this->t_guild, $limit);
    $ary = $query->result_array();
    $res = array();
    foreach($ary as $row){
      $this->db->where('G_Name', $row['G_Name']);
      $row['count'] = $this->db->count_all_results($this->t_guildmember);
      $res[] = $row;
    }
    unset($ary);
    return $res;
  }

  function getOnlineCharactersList(){
    $this->db->where('connectstat', 1);
    $query = $this->db->get($this->t_memb_stat);
    return $query->result_array();
  }

  function getGMList(){
    $gm_code = $this->config->item('gm_ctlcode');
    $this->db->select('AccountID, Name, MapNumber');
    $this->db->where('CtlCode', $gm_code);
    $query = $this->db->get($this->t_character);
    return $query->result_array();
  }
}
?>
