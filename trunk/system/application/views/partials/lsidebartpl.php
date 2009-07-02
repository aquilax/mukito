<?php
  if(!$logged){
    echo '<div class="spanel" id="login_form">';
    echo '<h3>'.lang('Login').'</h3>';
    echo form_open('user/login');
    pe(
      lang('User', 'user_s'),
      form_input(array('name' => 'user','value' => set_value('user'),
        'id' => 'user_s', 'class' => 'text' ))
    );

    pe(
      lang('Password', 'pass_s'),
      form_password(array('name' => 'pass',
        'id' => 'pass_s', 'class' => 'text' ))
    );

    echo '<p>'.form_submit('submit', lang('Login')).'</p>';
    echo form_close();
    echo '</div>';
  } else {
    echo '<div class="spanel" id="user_menu">';
    echo '<h3>'.lang('User menu').'</h3>';
    echo '  <ul>';
    echo '    <li>'.anchor('user/change_pass', lang('Change Password')).'</li>';
    echo '    <li>'.anchor('character/reset', lang('Reset Character')).'</li>';
    echo '    <li>'.anchor('character/add_stats', lang('Add Stats')).'</li>';
    echo '    <li>'.anchor('character/clear_pk', lang('Clear PK Status')).'</li>';
    echo '    <li>'.anchor('character/warp', lang('Warp Maps')).'</li>';
    echo '    <li>'.anchor('character', lang('Characters Info')).'</li>';
    echo '    <li>'.anchor('user/logout', lang('Logout')).'</li>';
    echo '  </ul>';
    echo '</div>';
  }
  echo '<div class="spanel" id="main_menu">';
  echo '<h3>'.lang('Main menu').'</h3>';
  echo '  <ul>';
  echo '    <li>'.anchor('', lang('Home')).'</li>';
  if(!$logged){
    echo '    <li>'.anchor('user/login', lang('Login')).'</li>';
    echo '    <li>'.anchor('user/register', lang('Register')).'</li>';
  }
  echo '    <li>'.anchor('page/download', lang('Downloads')).'</li>';
  echo '    <li>'.anchor('stat', lang('Statistics')).'</li>';
  echo '    <li>'.anchor('stat/game_masters', lang('Game Masters')).'</li>';
  echo '    <li>'.anchor('stat/ranking', lang('Ranking')).'</li>';
  echo '    <li>'.anchor('stat/guilds', lang('Top Guilds')).'</li>';
  echo '    <li>'.anchor('stat/online', lang('Online Players')).'</li>';
  echo '  </ul>';
  echo '</div>';
?>