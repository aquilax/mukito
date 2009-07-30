<?php
/**
 * Description of config_model
 *
 * @author aquilax
 */
class Config_model extends Model{

  public $config_file = 'config/mukito.ini.php';

  function Config_model(){
    parent::__construct();
    if (!$this->load(APPPATH.$this->config_file)){
      die('Config file not found');
    }
  }

  function load($file){
    $ary = parse_ini_file($file, FALSE);
    if (!$ary){
      return FALSE;
    }
    foreach($ary as $key => $val){
      $this->config->set_item($key, $val);
    }
    return TRUE;
  }
}
?>
