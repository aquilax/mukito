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
    $this->data['characters'] = $this->character_model->getCharactersForAccount($this->uid);
    $this->render();
  }

  function reset(){
    if (!$this->logged){
      redirect('');
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
