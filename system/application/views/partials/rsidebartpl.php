<?php
  if (isset($top_characters)){
    echo '<div class="spanel" id="top_players">';
    echo '<h3>'.lang('Top characters').'</h3>';
    echo '  <ol>';
    foreach($top_characters as $char){
      echo '    <li>'.$char['name'].' ['.$char['resets'].']</li>';
    }
    echo '  </ol>';
    echo '</div>';
  }

  if (isset($top_guilds)){
    echo '<div class="spanel" id="top_players">';
    echo '<h3>'.lang('Top guilds').'</h3>';
    echo '  <ol>';
    foreach($top_guilds as $guild){
      echo '    <li>'.$guild['G_Name'].' ['.$guild['count'].']</li>';
    }
    echo '  </ol>';
    echo '</div>';
  }
?>