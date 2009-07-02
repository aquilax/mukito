<table>
  <tr>
    <th>№</th>
    <th><?php echo lang('User')?></th>
    <th><?php echo lang('Server name')?></th>
  </tr>
<?php
  $c = 1;
  foreach($online as $row){
    echo '<td>'.$c.'</td>';
    echo '<td>'.$row['memb___id'].'</td>';
    echo '<td>'.$row['ServerName'].'</td>';
    $c++;
  }
?>
</table>