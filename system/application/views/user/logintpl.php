<?php
  echo validation_errors();
  echo form_open('user/login');
  pe(
    lang('User', 'user'),
    form_input(array('name' => 'user','value' => set_value('user'),
      'id' => 'user', 'class' => 'text' ))
  );

  pe(
    lang('Password', 'pass'),
    form_password(array('name' => 'pass',
      'id' => 'pass', 'class' => 'text' ))
  );

  echo '<p>'.form_submit('submit', lang('Login')).'</p>';
  echo form_close();
?>
