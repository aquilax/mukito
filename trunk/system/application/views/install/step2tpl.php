<?php
  function addField($name, $value){
    pe(
      lang($name, $name),
      form_input(array('name' => $name, 'value' => set_value($name, $value),
        'id' => $name, 'class' => 'text' ))
    );
  }
  echo form_open('install/step2');
  echo form_fieldset(lang('Website settings'));
  addField('base_url', $base_url);
  addField('language', $language);
  addField('server_name', $server_name);
  addField('keywords', $keywords);
  addField('template', $template);
  addField('server_ip', $server_ip);
  addField('server_port', $server_port);
  addField('gm_ctlcode', $gm_ctlcode);
  addField('resetmoney', $resetmoney);
  addField('resetpoints', $resetpoints);
  addField('resetlevel', $resetlevel);
  addField('resetlimit', $resetlimit);
  addField('pkmoney', $pkmoney);
  addField('resetmode', $resetmode);
  addField('levelupmode', $levelupmode);
  addField('clean_inventory', $clean_inventory);
  addField('clean_skills', $clean_skills);
  echo form_fieldset_close();
  echo '<p>'.form_submit('next', lang('Next')).'</p>';
  form_close();
?>
