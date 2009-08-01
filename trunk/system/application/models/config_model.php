<?php
/**
 * Description of config_model
 *
 * @author aquilax
 */
class Config_model extends Model{

  function load(){
    $res = $this->getSettings();
    if ($res){
      foreach($res as $row){
        $this->config->set_item($row['name'], $row['val']);
      }
      return TRUE;
    }
    return FALSE;
  }

  function getSettings(){
    $query = $this->db->get('mukito');
    $res = $query->result_array();
    if ($res){
      return $res;
    }
    return array();
  }
}
?>