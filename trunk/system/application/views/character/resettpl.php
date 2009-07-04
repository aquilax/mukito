<?php
if (isset($messages)){
  echo '<div class="messages">';
  echo implode('<br />', $messages);
  echo '</div>';
}
?>