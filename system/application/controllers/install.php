<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of install
 *
 * @author aquilax
 */
class Install extends Controller{

  function Install(){
    parent::Controller();
    $this->load->model('install_model');
    $this->output->enable_profiler(TRUE);
  }

  function index(){
    $dsn = $this->config->item('dsn');
    if ($dsn){
      $this->load->database($dsn);
      $res = $this->config_model->load();
      redirect('');
    }
    if (!extension_loaded('odbc')){
      //TODO: Uncomment this
      //die('ODBC Extension not found');
    }
    $data['title'] = lang('Install');
    $data['heading'] = lang('Welcome to MuKiTo install');
		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->form_validation->set_rules('host', lang('Database host'), 'trim|required');
    $this->form_validation->set_rules('dsn', lang('DSN name'), 'trim|required');
    $this->form_validation->set_rules('user', lang('User'), 'trim|required');
    $this->form_validation->set_rules('pass', lang('Password'), 'trim');
   
		if ($this->form_validation->run() == FALSE){
      $this->load->view('install/indextpl', $data);
		} else {
      if ($this->install_model->checkConnection($_POST)){
        if ($this->install_model->writeDatabaseConfig($_POST)){
          if ($this->install_model->createTables()){
            redirect('install/step2');
          } else {
            die('Cannot create configuration table');
          }
        } else {
          die('Cannot write database configuration');
        }
      } else {
        $this->load->view('install/indextpl', $data);
      }
		}
  }

  function step2(){
    $dsn = $this->config->item('dsn');
    if (!$dsn){
      redirect('install');
    }
    $data['title'] = lang('Install &raquo; Step 2');
    $data['heading'] = lang('Website setup');
    
    $this->load->database($dsn);
    $this->load->model('config_model');
    $res = $this->config_model->load();
    $res = $this->config_model->getSettings();
    foreach($res as $row){
      $data[$row['name']] = $row['val'];
    }
		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->form_validation->set_rules('base_url', lang('base_url'), 'trim|required|prep_url');
    $this->form_validation->set_rules('language', lang('language'), 'trim|required');
    $this->form_validation->set_rules('server_name', lang('server_name'), 'trim|required');
    $this->form_validation->set_rules('keywords', lang('keywords'), 'trim|required');
    $this->form_validation->set_rules('template', lang('template'), 'trim|required');
    $this->form_validation->set_rules('server_ip', lang('server_ip'), 'trim|required|valid_ip');
    $this->form_validation->set_rules('server_port', lang('server_port'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('gm_ctlcode', lang('gm_ctlcode'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('resetmoney', lang('resetmoney'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('resetpoints', lang('resetpoints'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('resetlevel', lang('resetlevel'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('resetlimit', lang('resetlimit'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('pkmoney', lang('pkmoney'), 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('resetmode', lang('resetmode'), 'trim|required');
    $this->form_validation->set_rules('levelupmode', lang('levelupmode'), 'trim|required');
    $this->form_validation->set_rules('clean_inventory', lang('clean_inventory'), 'trim|required');
    $this->form_validation->set_rules('clean_skills', lang('clean_skills'), 'trim|required');

		if ($this->form_validation->run() == FALSE){
      $this->load->view('install/step2tpl', $data);
		} else {
      if ($this->config_model->updateSettings($_POST)){
        redirect('install/step3');
      } else {
        $this->load->view('install/step2tpl', $data);
      }
		}
  }

  function step3(){
    $dsn = $this->config->item('dsn');
    if (!$dsn){
      redirect('install');
    }

    $data['title'] = lang('Install &raquo; Step 3');
    $data['heading'] = lang('Create server administrator');

    $this->load->database($dsn);
    $this->load->model('config_model');
    $res = $this->config_model->load();

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
      $this->load->view('install/step3tpl', $data);
		} else {
      $this->load->model('user_model');
      if ($this->user_model->register($_POST, TRUE)){
        redirect('');
      } else {
        $this->load->view('install/step3tpl', $data);
      }
		}
  }
}
?>
