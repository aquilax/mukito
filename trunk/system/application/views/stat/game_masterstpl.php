<table>
  <tr>
    <th>№</th>
    <th><?php echo lang('User')?></th>
    <th><?php echo lang('Map')?></th>
  </tr>
<?php
  $c = 1;
  foreach($gm as $row){
    echo '<td>'.$c.'</td>';
    echo '<td>'.$row['AccountID'].'</td>';
    echo '<td>'.$row['MapNumber'].'</td>';
    $c++;
  }
?>
</table>