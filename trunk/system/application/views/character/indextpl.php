<table>
  <tr>
    <th>№</th>
    <th><?php echo lang('Name')?></th>
    <th><?php echo lang('Level')?></th>
    <th><?php echo lang('Resets')?></th>
    <th><?php echo lang('Strength')?></th>
    <th><?php echo lang('Dexterity')?></th>
    <th><?php echo lang('Vitality')?></th>
    <th><?php echo lang('Energy')?></th>
    <th><?php echo lang('Status')?></th>
    <th><?php echo lang('Reset')?></th>
    <th><?php echo lang('Clear PK')?></th>
  </tr>
<?php
  $c = 1;
  foreach($characters as $row){
    echo '<tr>';
    echo '<td>'.$c.'</td>';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['clevel'].'</td>';
    echo '<td>'.$row['resets'].'</td>';
    echo '<td>'.$row['strength'].'</td>';
    echo '<td>'.$row['dexterity'].'</td>';
    echo '<td>'.$row['vitality'].'</td>';
    echo '<td>'.$row['energy'].'</td>';
    if ($row['is_online']){
      echo '<td class="green">'.lang('online').'</td>';
    } else {
      echo '<td class="red">'.lang('offline').'</td>';
    }
    if ($row['can_reset']){
      echo '<td>'.anchor('character/reset/'.$row['name'], lang('reset')).'</td>';
    } else {
      echo '<td>X</td>';
    }
    if ($row['can_clear']){
      echo '<td>'.anchor('character/clear_pk/'.$row['name'], lang('clear')).'</td>';
    } else {
      echo '<td>X</td>';
    }
    echo '</tr>';
    $c++;
  }
?>
</table>