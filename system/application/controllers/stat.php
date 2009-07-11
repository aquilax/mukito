<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stat
 *
 * @author aquilax
 */
class Stat extends AQX_Controller{

  function Stat(){
    parent::__construct();
  }

  function index(){
    $this->data['title'] = lang('Statistics');
    $this->data['heading'] = lang('Statistics');
    $this->data['stat'] = $this->stat_model->getAll();
    $this->action = 'index';
    $this->render();
  }

  function ranking(){
    $this->data['title'] = lang('Ranking');
    $this->data['heading'] = lang('Ranking');
    $this->data['rating'] = $this->stat_model->getTopPlayers(10);
    $this->render();
  }

  function guilds(){
    $this->data['title'] = lang('Top guilds');
    $this->data['heading'] = lang('Top guilds');
    $this->data['guilds'] = $this->stat_model->getTopGuilds(10);
    $this->render();
  }

  function game_masters(){
    $this->data['title'] = lang('Game masters');
    $this->data['heading'] = lang('Game masters');
    $this->data['gm'] = $this->stat_model->getGMList();
    $this->render();
  }

  function online(){
    $this->data['title'] = lang('Online players');
    $this->data['heading'] = lang('Online players');
    $this->data['online'] = $this->stat_model->getOnlineCharactersList();
    $this->render();
  }
}
?>
