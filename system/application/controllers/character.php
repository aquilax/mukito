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

  function reset($cname){
    if (!$this->logged){
      redirect('');
    }
    $status = $this->character_model->getCharStatus($cname, $this->uid);
    if ($status && $this->character_model->canReset($status)){
      $this->data['message'] = $this->character_model->reset($cname, $status);
      $this->render();
    } else {
      redirect('');
    }
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
