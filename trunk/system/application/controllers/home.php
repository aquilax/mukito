<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author aquilax
 */
class Home extends AQX_Controller{

  function index(){
    unset($this->data['title']);
    unset($this->data['heading']);
    $this->render();
  }
}
?>
