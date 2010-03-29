<?php echo $javascript->link('prototype'); ?>
<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>

<script type="text/javascript">
Event.observe(window, 'load', function() {
	var d6 = [];
	var labels = [];
	<?php
	$cnt = 0;
	$y_max = 0;
	foreach($sprint_calendar as $cal) { 
		$sum = "";
		foreach($sprint_remaining_hours as $a) {
			if($a["Hours"][$cal] != "")
			{
				$sum += $a["Hours"][$cal];
			}
		}
		if($sum != "")
		{
			if($sum >= $y_max) {
				$y_max = $sum;
			}
			echo sprintf("d6.push([%d, %d]);\n", $cnt, $sum);
			//echo "//" . $d . "\n";
			echo sprintf("labels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		else
		{
			echo sprintf("labels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		$cnt++;
	}
	?>
	new Proto.Chart($('linechart'), 
	[
		{data: d6, label: "Data 1"}
	],
	{
		//since line chart is the default charting view
		//we do not need to pass any specific options for it.
		xaxis: {min: 0, max: <?php echo count($sprint_calendar); ?>, tickSize: 1, ticks: labels },
		yaxis: {min: 0, max: <?php echo $y_max + 20; ?> },
		grid: {
			drawXAxis: true,
			drawYAxis: true
		},
	});
});	
</script>
<div class="linechart" id="linechart" style="width:600px;height:160px"></div>


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
