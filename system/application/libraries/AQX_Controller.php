<?php
/**
 * Description of DIGG_Controller
 *
 * @author aquilax
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class AQX_Controller extends Controller {

  protected $data = array();
  protected $class_name;
  protected $action;
  protected $param;
  protected $uid;
  protected $logged;

  public function __construct() {
    parent::__construct();
    $this->load_defaults();
    $this->output->enable_profiler(TRUE);
  }

  protected function load_defaults() {
    $dsn = $this->config->item('dsn');
    if (!$dsn){
      redirect('install');
    }
    echo $this->load->database($dsn);
    $this->data['server_name'] = $this->config->item('server_name');
    $this->data['keywords'] = $this->config->item('keywords');
    $this->data['title'] = 'Page Title';
    $this->data['heading'] = 'Page Heading';
    $this->data['content'] = '';
    $this->data['css'] = $this->config->item('template');
    $this->data['path']['home'] = lang('Home');
    $this->data['logged'] = $this->user_model->logged();
    $this->data['top_characters'] = $this->stat_model->getTopPlayers(10);
    $this->data['top_guilds'] = $this->stat_model->getTopGuilds(10);
    $this->logged = $this->data['logged'];
    $this->data['uid'] = $this->user_model->getId();
    $this->uid = $this->data['uid'];
    $this->data['online'] = $this->user_model->checkServer();
    
    $this->class_name = strtolower(get_class($this));
    $this->action = $this->uri->segment(2, 'index');
  }

  protected function render($template='main') {
    if (file_exists(APPPATH . 'views/' . $this->class_name . '/' . $this->action . 'tpl.php')) {
      $this->data['content'] .= $this->load->view($this->class_name . '/' . $this->action . 'tpl.php', $this->data, true);
    }
    $this->load->view("layouts/".$template."tpl.php", $this->data);
  }
}
?>