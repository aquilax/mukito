<table id="stat">
  <tr>
    <td><?php echo lang('Total Characters')?></td>
    <td><?php echo $stat['total_characters']?></td>
  </tr>
  <tr>
    <td><?php echo lang('Online Characters')?></td>
    <td><?php echo $stat['online_characters']?></td>
  </tr>
  <tr>
    <th colspan="2"><?php echo lang('Characters by race')?></th>
  </tr>
<?php
  foreach($stat['race'] as $name => $count){
    echo '  <tr>';
    echo '    <td>'.$name.'</td>';
    echo '    <td>'.$count.'</td>';
    echo '  </tr>';
  }
?>
  <tr>
    <th colspan="2"><?php echo lang('Characters by map')?></th>
  </tr>
<?php
  foreach($stat['map'] as $name => $count){
    echo '  <tr>';
    echo '    <td>'.$name.'</td>';
    echo '    <td>'.$count.'</td>';
    echo '  </tr>';
  }
?>
</table>