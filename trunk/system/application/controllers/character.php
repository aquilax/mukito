<?php
/**
 * Description of character
 *
 * @author aquilax
 */
class Character extends AQX_Controller{

  function Character(){
    parent::__construct();
    $this->load->model('character_model');
  }

  function index(){
    if (!$this->logged){
      redirect('');
    }
    $this->data['title'] = lang('Characters info');
    $this->data['heading'] = lang('Characters info');
    $this->data['characters'] = $this->character_model->getCharactersForAccount($this->uid);
    $this->render();
  }

  function reset(){
    if (!$this->logged){
      redirect('');
    }
    $cname = $this->uri->segment(3);
    if (!$cname){
      if (isset($_POST['cname'])){
        $cname = $_POST['cname'];
        if (!$cname){
          $this->render();
          return;
        }
      } else {
        $this->render();
        return;
      }
    }
    $this->data['title'] = lang('Reset character');
    $this->data['heading'] = lang('Reset character');
    $msg = array();
    $status = $this->character_model->getCharStatus($cname, $this->uid);
    if ($status){
      $msg =  $this->character_model->canReset($status, FALSE);
      if (count($msg) == 0){
        $this->data['messages'] = $this->character_model->resetCharacter($cname, $status);
      } else {
        $this->data['messages'] = $msg;
      }
    } else {
      $this->data['messages'][] = sprintf(lang('Character %s not found'), $cname);
    }
    $this->render();
  }

  function add_stats(){
    if (!$this->logged){
      redirect('');
    }
    $this->data['title'] = lang('Add Stats');
    $this->data['heading'] = lang('Add Stats');
    $cname = $this->uri->segment(3);
    if (!$cname){
      if (isset($_POST['cname'])){
        $cname = $_POST['cname'];
        if (!$cname){
          $this->render();
          return;
        }
      } else {
        $this->render();
        return;
      }
    }
    $msg = array();
    $status = $this->character_model->getCharStatus($cname, $this->uid);
    $this->data['can_add'] = FALSE;
    if ($status){
      if ($status['leveluppoint'] > 0){
        $this->data['status'] = $status;
        if (!isset($_POST['add'])){
          $_POST = array();
        }
        $this->data['can_add'] = TRUE;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->form_validation->set_rules('strength', lang('Strength'), 'trim|is_natural|required');
        $this->form_validation->set_rules('agility', lang('Agility'), 'trim|is_natural|required');
        $this->form_validation->set_rules('vitality', lang('Vitality'), 'trim|is_natural|required');
        $this->form_validation->set_rules('energy', lang('Energy'), 'trim|is_natural|required');
        if (isset($status['learedship'])){
          $this->form_validation->set_rules('command', lang('Leadership'), 'trim|is_natural|required');
        }
        if ($this->form_validation->run() != FALSE){
          $this->data['messages'] =  $this->character_model->addPonts($this->uid, $_POST, $status);
          $status = $this->character_model->getCharStatus($cname, $this->uid);
        }
      } else {
        $this->data['messages'][] = sprintf(lang('No Level Up Points Found'), $cname);
      }
    } else {
      $this->data['messages'][] = sprintf(lang('Character %s not found'), $cname);
    }
    $this->render();
  }

  function clear_pk(){
    $this->render();
  }

  function warp(){
    $this->render();
  }

}
?>
