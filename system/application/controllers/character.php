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
