<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of install_model
 *
 * @author aquilax
 */
class Install_model extends Model{

  // DSN format
  // $dsn = 'dbdriver://username:password@hostname/database';
  //TODO: make this odbc
  var $dsnTemplate = 'mysql://%s:%s@%s/%s';
  var $configFile = 'application/config/mukito.php';

  function Install_model(){
    parent::__construct();
    $this->load->helper('file');
  }

  function checkConnection($post){
    $dsn = $this->getDatabaseConfig($post);
    $db = $this->load->database($dsn);
    return $this->db != Null;
  }

  function getDatabaseConfig($post){
    return sprintf($this->dsnTemplate, $post['user'], $post['pass'], $post['host'], $post['dsn']);
  }

  function writeDatabaseConfig($post){
    $dsn = $this->getDatabaseConfig($post);
    $text = "//Database connection\n";
    $text .= "\$config['dsn'] = '$dsn';\n";
    $this->addLines($text);
  }

  function addLines($text){
    $file = BASEPATH.$this->configFile;
    $old = file_get_contents($file);
    if (!$old){
      die('Config file not found');
    }
    $new = $old.$text;
    write_file($file, $new);
  }
}
?>
