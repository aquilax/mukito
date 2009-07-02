<table>
  <tr>
    <th>№</th>
    <th><?php echo lang('Guild')?></th>
    <th><?php echo lang('Score')?></th>
    <th><?php echo lang('Master')?></th>
    <th><?php echo lang('Members')?></th>
  </tr>
<?php
  $c = 1;
  foreach($guilds as $row){
    echo '<td>'.$c.'</td>';
    echo '<td>'.$row['G_Name'].'</td>';
    echo '<td>'.$row['G_Score'].'</td>';
    echo '<td>'.$row['G_Master'].'</td>';
    echo '<td>'.$row['count'].'</td>';
    $c++;
  }
?>
</table>