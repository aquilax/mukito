<?php
  echo validation_errors();
  echo form_open('install/step3');
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

  pe(
    lang('Password again', 'pass2'),
    form_password(array('name' => 'pass2',
      'id' => 'pass2', 'class' => 'text' ))
  );

  pe(
    lang('E-Mail', 'email'),
    form_input(array('name' => 'email','value' => set_value('email'),
      'id' => 'email', 'class' => 'text' ))
  );

  pe(
    lang('Personal ID Code', 'idcode'),
    form_input(array('name' => 'idcode','value' => set_value('idcode'),
      'id' => 'idcode', 'class' => 'text', 'length' => 12))
  );

  pe(
    lang('Secret question', 'squestion'),
    form_input(array('name' => 'squestion','value' => set_value('squestion'),
      'id' => 'squestion', 'class' => 'text' ))
  );

  pe(
    lang('Secret answer', 'sanswer'),
    form_input(array('name' => 'sanswer','value' => set_value('sanswer'),
      'id' => 'sanswer', 'class' => 'text' ))
  );

//  pe(
//    lang('Country', 'country'),
//    form_dropdown('country', $countries, set_value('country'), 'id="country"')
//  );
//
//  pe(
//    lang('Gender', 'gender'),
//    form_dropdown('gender', $genders, set_value('gender'), 'id="gender"')
//  );

  echo '<p>'.form_submit('submit', lang('Register')).'</p>';
  echo form_close();
?>