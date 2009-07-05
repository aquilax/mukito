<?php
  if (isset($messages)){
    echo '<div class="messages">';
    echo implode('<br />', $messages);
    echo '</div>';
  }
  if(!isset($status)){
    echo form_open('character/add_stats');
    echo form_fieldset(lang('Search character'));
    pe(
      lang('Character name', 'cname'),
      form_input(array('name' => 'cname','value' => set_value('cname'),
        'id' => 'cname', 'class' => 'text' ))
    );
    echo form_fieldset_close();
    echo '<p>'.form_submit('search', lang('Search')).'</p>';
    form_close();
  } else {
    if ($can_add){
      echo validation_errors();
      echo form_open('character/add_stats');
      echo form_fieldset(sprintf(lang('Add Stats for %s'), $status['name']));
      echo '<p>'.sprintf('%d points available', $status['leveluppoint']).'</p>';
      echo form_hidden('cname', $status['name']);
      pe(
        lang('Strength', 'strength').' ['.$status['strength'].']',
        form_input(array('name' => 'strength','value' => set_value('strength', 0),
          'id' => 'strength', 'class' => 'text' ))
      );
      pe(
        lang('Agility', 'agility').' ['.$status['dexterity'].']',
        form_input(array('name' => 'agility','value' => set_value('agility', 0),
          'id' => 'agility', 'class' => 'text' ))
      );
      pe(
        lang('Vitality', 'vitality').' ['.$status['vitality'].']',
        form_input(array('name' => 'vitality','value' => set_value('vitality', 0),
          'id' => 'vitality', 'class' => 'text' ))
      );
      pe(
        lang('Energy', 'energy').' ['.$status['energy'].']',
        form_input(array('name' => 'energy','value' => set_value('energy', 0),
          'id' => 'energy', 'class' => 'text' ))
      );
      if (isset($status['leadership'])){
        pe(
          lang('Command', 'command').' ['.$status['leadership'].']',
          form_input(array('name' => 'command','value' => set_value('command', 0),
            'id' => 'command', 'class' => 'text' ))
        );
      }
      echo form_fieldset_close();
      echo '<p>'.form_submit('add', lang('Add points')).'</p>';
      form_close();
    }
  }
?>
