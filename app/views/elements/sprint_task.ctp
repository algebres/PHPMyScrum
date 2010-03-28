<table>
<tr>
<th colspan="3"><?php __("Task / RemainingHours"); ?></th>
<?php foreach($sprint_calendar as $cal) { ?>
<th><?php echo date('d', strtotime($cal)); ?></th>
<?php } ?>
</tr>

<?php foreach($sprint_remaining_hours as $a) { ?>
<tr>
<td><?php echo $a["id"]; ?></td>
<td><?php echo $a["Story"]["name"]; ?></td>
<td><?php echo $this->Html->link($a["name"], array('controller' => 'tasks', 'action' => 'view', $a['id'])); ?></td>
<?php foreach($sprint_calendar as $cal) { ?>
<td><?php echo $a["Hours"][$cal]; ?></td>
<?php } ?>
</tr>
<?php } ?>

<tr>
<td colspan="3"><?php __('Sum'); ?></td>
<?php foreach($sprint_calendar as $cal) { ?>
<?php
	$sum = 0;
	foreach($sprint_remaining_hours as $a) {
		$sum += $a["Hours"][$cal];
	}
	echo "<td>" . $sum . "</td>";
?>
<?php } ?>
</tr>
</table>
