<?php
if (isset($messages)){
  echo '<div class="messages">';
  echo implode('<br />', $messages);
  echo '</div>';
} else {
  echo form_open('character/clear_pk');
  echo form_fieldset(lang('Search character'));
  pe(
    lang('Character name', 'cname'),
    form_input(array('name' => 'cname','value' => set_value('cname'),
      'id' => 'cname', 'class' => 'text' ))
  );
  echo form_fieldset_close();
  echo '<p>'.form_submit('search', lang('Search')).'</p>';
  form_close();
}
?>