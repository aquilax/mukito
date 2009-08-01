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
    $data['heading'] = lang('Create server administrator');
    
    $this->load->database($dsn);
    $this->load->model('config_model');
    $res = $this->config_model->getSettings();
    foreach($res as $row){
      $data[$row['name']] = $row['val'];
    }
		$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    $this->form_validation->set_rules('host', lang('Database host'), 'trim|required');
    $this->form_validation->set_rules('dsn', lang('DSN name'), 'trim|required');
    $this->form_validation->set_rules('user', lang('User'), 'trim|required');
    $this->form_validation->set_rules('pass', lang('Password'), 'trim');

		if ($this->form_validation->run() == FALSE){
      $this->load->view('install/step2tpl', $data);
		} else {
      if ($this->install_model->checkConnection($_POST)){
        $this->install_model->writeDatabaseConfig($_POST);
        redirect('install/step2');
      } else {
        $this->load->view('install/step2tpl', $data);
      }
		}
  }
}
?>
