<?php
/**
 * Description of page
 *
 * @author aquilax
 */
class page extends AQX_Controller{

  function index($page){
    if ($page){
      $this->action = $page;
      $this->render();
    } else {
      redirect('home');
    }
  }
}
?>
