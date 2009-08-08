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
  var $dsnTemplate = 'odbc://%s:%s@%s/%s?pconnect=true';
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
    return $this->addLines($text);
  }

  function addLines($text){
    $file = BASEPATH.$this->configFile;
    $old = file_get_contents($file);
    if (!$old){
      die('Config file not found');
    }
    $new = $old.$text;
    return write_file($file, $new);
  }

  function createTables(){
    $this->load->dbforge();
    $fields = array(
      'id' => array(
        'type' => 'int IDENTITY(1,1)PRIMARY KEY CLUSTERED',
//        'constraint' => 5,
//        'unsigned' => TRUE,
//        'auto_increment' => TRUE
      ),
      'name' => array(
        'type' => 'VARCHAR',
        'constraint' => '30',
        'default' => '',
      ),
      'val' => array(
        'type' =>'VARCHAR',
        'constraint' => '100',
        'default' => '',
      )
    );
    $this->addResets();
    $this->addAdminField();
    $this->dbforge->add_field($fields);
    //    $this->dbforge->add_key('id', TRUE);
    if ($this->dbforge->create_table('mukito', TRUE)){
      //Init settings
      $this->db->truncate('mukito');
      $this->_addKv('base_url', 'http://'.$_SERVER['HTTP_HOST'].'/');
      $this->_addKv('language', 'english');
      $this->_addKv('server_name', 'MuKiTo');
      $this->_addKv('keywords', 'mukito, mu online, private server');
      $this->_addKv('template', 'default.css');
      $this->_addKv('server_ip', '127.0.0.1');
      $this->_addKv('server_port', '44405');
      $this->_addKv('gm_ctlcode', '32');
      $this->_addKv('resetmoney', '10');
      $this->_addKv('resetpoints', '10');
      $this->_addKv('resetlevel', '3');
      $this->_addKv('resetlimit', '150');
      $this->_addKv('pkmoney', '20000');
      $this->_addKv('resetmode', 'reset');
      $this->_addKv('levelupmode', 'normal');
      $this->_addKv('clean_inventory', 'no');
      $this->_addKv('clean_skills', 'no');
      $this->_addKv('t_character', 'Character');
      $this->_addKv('t_memb_stat', 'MEMB_STAT');
      $this->_addKv('t_guild', 'guild');
      $this->_addKv('t_guildmember', 'guildmember');
      $this->_addKv('t_memb_info', 'MEMB_INFO');
      return TRUE;
    }
    return FALSE;
  }

  function _addKv($key, $value){
    $data = array('name' => $key, 'val' => $value);
    $this->db->insert('mukito', $data);
  }

  function addResets(){
    $fields = array(
      'resets' => array(
        'type' => 'INT',
        'null' => FALSE,
        'unsigned' => TRUE,
        'dafault' => 0
      )
    );
    $this->dbforge->add_column('Character', $fields);
  }

  function addAdminField(){
    $fields = array(
      'admin' => array(
        'type' => 'INT',
        'null' => FALSE,
        'unsigned' => TRUE,
        'dafault' => 0
      )
    );
    $this->dbforge->add_column('MEMB_INFO', $fields);
  }
}
?>
