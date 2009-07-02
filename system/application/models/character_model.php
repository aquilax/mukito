<?php
/**
 * Description of character_model
 *
 * @author aquilax
 */
class Character_model extends Model {

  var $t_character = 'Character';

  function Character_model(){
    parent::Model();
    $this->t_character = $this->config->item('t_character');
  }

  function getCharactersForAccount($name){
    $this->db->select('name,class,clevel,resets,strength,dexterity,vitality,energy,mapnumber,accountid');
    $this->db->where('AccountID', $name);
    $this->db->order_by('Resets', 'desc');
    $this->db->order_by('cLevel', 'desc');
    $query = $this->db->get($this->t_character);
    return $query->result_array();
  }

  function getCharStatus($cname, $uid){
    $this->db->select('clevel,resets,money,leveluppoint,class');
    $this->where('accountid', $uid);
    $this->where('name', $cname);
    $query = $this->db->get($this->t_character, 1);
    return $query->result_array();
  }
}
?>