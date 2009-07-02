<table>
  <tr>
    <th><?php echo lang('Total Characters')?></th>
    <td><?php echo $stat['total_characters']?></td>
  </tr>
  <tr>
    <th><?php echo lang('Online Characters')?></th>
    <td><?php echo $stat['online_characters']?></td>
  </tr>
<?php
  foreach($stat['race'] as $name => $count){
    echo '  <tr>';
    echo '    <th>'.$name.'</th>';
    echo '    <td>'.$count.'</td>';
    echo '  </tr>';
  }
  foreach($stat['map'] as $name => $count){
    echo '  <tr>';
    echo '    <th>'.$name.'</th>';
    echo '    <td>'.$count.'</td>';
    echo '  </tr>';
  }
?>
</table>