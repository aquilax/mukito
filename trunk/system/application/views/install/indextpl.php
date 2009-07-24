<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  echo form_open('install');
  echo form_fieldset(lang('Database settings'));
  pe(
    lang('Database host', 'host'),
    form_input(array('name' => 'host','value' => set_value('host'),
      'id' => 'host', 'class' => 'text' ))
  );
  pe(
    lang('DSN name', 'dsn'),
    form_input(array('name' => 'dsn','value' => set_value('dsn'),
      'id' => 'dsn', 'class' => 'text' ))
  );
  pe(
    lang('Database user', 'user'),
    form_input(array('name' => 'user','value' => set_value('user'),
      'id' => 'used', 'class' => 'text' ))
  );
  pe(
    lang('Database password', 'pass'),
    form_input(array('name' => 'pass','value' => set_value('pass'),
      'id' => 'pass', 'class' => 'text' ))
  );
  echo form_fieldset_close();
  echo '<p>'.form_submit('next', lang('Next')).'</p>';
  form_close();
?>
