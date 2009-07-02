<?php
  echo validation_errors();
  echo form_open('user/change_pass');

  pe(
    lang('Current passsword', 'pass_old'),
    form_password(array('name' => 'pass_old',
      'id' => 'pass_old', 'class' => 'text' ))
  );

  pe(
    lang('Password', 'pass'),
    form_password(array('name' => 'pass',
      'id' => 'pass', 'class' => 'text' ))
  );

  pe(
    lang('Password again', 'pass2'),
    form_password(array('name' => 'pass2',
      'id' => 'pass2', 'class' => 'text' ))
  );

  echo '<p>'.form_submit('submit', lang('Change Password')).'</p>';
  echo form_close();
?>
