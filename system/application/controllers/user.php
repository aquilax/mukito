<?php
/**
 * Description of user
 *
 * @author aquilax
 */
class User extends AQX_Controller{

  function index(){
    $this->render();
  }

  function login(){
    $this->data['title']= lang('Login');
    $this->data['heading']= lang('Login');
    $this->data['path']['user/login'] = lang('Login');
    
		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->form_validation->set_rules('user', lang('User'), 'trim|required');
    $this->form_validation->set_rules('pass', lang('Password'), 'trim|required');
		if ($this->form_validation->run() == FALSE){
      $this->render();
		} else {
      if ($this->user_model->login($_POST)){
        redirect('user');
      } else {
        $this->render();
      }
		}
  }

  function register(){
    $this->data['title']= lang('Register');
    $this->data['heading']= lang('Register');
    $this->data['path']['user/login'] = lang('Register');

		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->data['genders'] = array('male' => 'male', 'female' => 'female');
    $this->data['countries'] = array('Bulgaria' => 'Bulgaria', 'UK' =>'UK');

    $this->form_validation->set_rules('user', lang('User'), 'trim|required|callback__check_user_reg');
    $this->form_validation->set_rules('pass', lang('Password'), 'trim|required');
    $this->form_validation->set_rules('pass2', lang('Password again'), 'trim|required|matches[pass]');
    $this->form_validation->set_rules('email', lang('E-Mail'), 'trim|required|valid|valid_email');
    $this->form_validation->set_rules('idcode', lang('Personal ID Code'), 'required|exact_length[12]');
    $this->form_validation->set_rules('squestion', lang('Secret question'), 'required');
    $this->form_validation->set_rules('sanswer', lang('Secret answer'), 'required');
    
		if ($this->form_validation->run() == FALSE){
      $this->render();
		} else {
      if ($this->user_model->register($_POST)){
        redirect('user');
      } else {
        $this->render();
      }
		}
  }

  function change_pass(){
    if (!$this->data['logged']){
      redirect('user/login');
    }
    $this->data['title']= lang('Change Password');
    $this->data['heading']= lang('Change Password');
    $this->data['path']['user/change_pass'] = lang('Change Password');

		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->form_validation->set_rules('pass_old', lang('Current passsword'), 'trim|required|callback__check_old_pass');
    $this->form_validation->set_rules('pass', lang('Password'), 'trim|required');
    $this->form_validation->set_rules('pass2', lang('Password again'), 'trim|required|matches[pass]');

		if ($this->form_validation->run() == FALSE){
      $this->render();
		} else {
      if ($this->user_model->changePass($this->uid, $_POST)){
        redirect('user');
      } else {
        $this->render();
      }
		}
  }

  function _check_user_reg($str){
    if ($this->user_model->userExists($str)){
      $this->form_validation->set_message('_check_user_reg', lang('This username is already taken'));
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function _check_old_pass($str){
    if ($this->user_model->checkOldPass($this->uid, $str)){
      $this->form_validation->set_message('_check_old_pass', lang('Old password is wrong'));
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function logout(){
    $this->user_model->logout();
    redirect('');
  }
}
?>
