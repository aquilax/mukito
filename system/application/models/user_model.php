<?php
/**
 * Description of user_model
 *
 * @author aquilax
 */
class User_model extends Model{

  var $t_memb_info = 'MEMB_INFO';
  var $t_character = 'Character';

  function User_model(){
    parent::Model();
    $this->t_memb_info = $this->config->item('t_memb_info');
    $this->t_character = $this->config->item('t_character');
  }

  function login($post){
    $this->db->where('memb___id', $post['user']);
    $this->db->where('memb__pwd', $post['pass']);
    $query = $this->db->get($this->t_memb_info);
    if ($query->num_rows() ==1){
      $ary = $query->row_array();
      $this->session->set_userdata('uid', $ary['memb___id']);
      $this->session->set_userdata('gm', $this->isGM($ary['memb___id']));
      return TRUE;
    } else {
      return FALSE;
    }
  }

  function register($post, $admin = FALSE){
    if ($admin){
      $admin = 1;
    } else {
      $admin = 0;
    }
    $data = array(
      'memb___id' => $post['user'],
      'memb__pwd' => $post['pass'],
      'memb_name' => 'MuKiTo',
      'sno__numb' => $post['idcode'],
      'mail_addr' => $post['email'],
      'appl_days' => date('m/d/Y'),
      'modi_days' => date('m/d/Y'),
      'out__days' => '2005-01-03',
      'true_days' => '2005-01-03',
      'mail_chek' => '1',
      'bloc_code' => '0',
      'ctl1_code' => '0',
      'admin'     => $admin,
      //'memb__pwd2' => $post['pass'],
      //'fpas_ques' => $post['squestion'],
      //'fpas_answ' => $post['sanswer'],
      //'country' => $post['country'],
      //'gender' => $post['gender'],
    );
    return $this->db->insert($this->t_memb_info, $data);
  }

  function logged(){
    return $this->session->userdata('uid') != false;
  }

  function getId(){
    $id = $this->session->userdata('uid');
    if ($id){
      return $id;
    } else {
      return 0;
    }
  }

  function logout(){
    $array_items = array('uid' => '', 'user' => '', 'name' => '');
    $this->session->unset_userdata($array_items);
  }

  function userExists($user){
    $this->db->where('memb___id', $user);
    return $this->db->count_all_results($this->t_memb_info) != 0;
  }

  function isGM($name){
    $gm_code = $this->config->item('gm_ctlcode');
    $this->db->where('AccountID', $name);
    $this->db->where('CtlCode', $gm_code);
    return $this->db->count_all_results($this->t_character) != 0;
  }

  function checkOldPass($uid, $pass){
    $this->db->where('memb_guid', $uid);
    $this->db->where('memb__pwd', $pass);
    return $this->db->count_all_results($this->t_memb_info) != 1;
  }

  function changePass($uid, $post){
    $data = array(
      'memb__pwd' => $post['pass'],
    );
    $this->db->where('memb___id', $uid);
    $this->db->update($this->t_memb_info, $data);
    return TRUE;
  }

  function checkServer(){
    $ip = $this->config->item('server_ip');
    $port = $this->config->item('server_port');
    //Timeout in seconds
    $timeout = 1;

    if ($ip){
      $fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
      if(!$fp) {
        return FALSE;
      } else {
        return TRUE;
        fclose($fp);
      }
    }
  }
}
?>
