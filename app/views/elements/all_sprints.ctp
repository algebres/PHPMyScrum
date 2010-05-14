<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>

<script type="text/javascript">
<!--
jQuery(document).ready(function()
{
    jQuery('#all_sprints_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>

<script type="text/javascript">
jQuery(function(){
	var d1 = [];
	var d2 = [];
	var d3 = [];
	var labels = [];
	var max_yaxis = 0;
	<?php
	$cnt =0;
	$max = 0;
	foreach($all_sprints as $sprint) {
		if($max <= $sprint["Sprint"]["total_remaining_point"])
		{
			$max = $sprint["Sprint"]["total_remaining_point"];
		}
		echo sprintf("\td1.push([%d, %d]);\n", $cnt, $sprint["Sprint"]["point_per_sprint"]);
		echo sprintf("\tlabels.push([%d, \"%s\"]);\n", $cnt, $sprint["Sprint"]["name"]);
		echo sprintf("\td2.push([%d, %d]);\n", $cnt, $sprint["Sprint"]["finished_point_per_sprint"]);
		echo sprintf("\td3.push([%d, %d]);\n", $cnt, $sprint["Sprint"]["total_remaining_point"]);
		$cnt++;
	}
	?>

	new Proto.Chart($('linechart'), 
	[
		{data: d1, label: "Data 1"},
		{data: d2, label: "Data 2"},
		{data: d3, label: "Data 3"}
	],
	{
		xaxis: {min: 0, max: <?php echo count($all_sprints)-1; ?>, tickSize: 1, ticks: labels },
		yaxis: {min: 0, max: <?php echo $max + 10; ?> },
		grid: {
			drawXAxis: true,
			drawYAxis: true
		}
	});
});
</script>

<div class="sprints index">
	<h2><?php echo sprintf(__("All %s", true), __('Sprints', true));?></h2>
	<div class="linechart" id="linechart" style="height:160px;margin:30px;"></div>
	<div id="">
	<table cellpadding="0" cellspacing="0" id="all_sprints_table">
	<tr>
	<th><?php __('Sprint'); ?></th>
	<th><?php __('Total Finished Story Point'); ?></th>
	<th><?php __('Total Story Point'); ?></th>
	<th><?php __('Total Remaining Story Point'); ?></th>
	</tr>
	<?php
	$total_finished =0;
	$total_story = 0;
	?>
	<?php foreach($all_sprints as $s): ?>
	<?php
	$total_finished += $s["Sprint"]["finished_point_per_sprint"];
	$total_story += $s["Sprint"]["point_per_sprint"];
	?>
	<tr>
	<td><?php echo $s["Sprint"]["name"]; ?></td>
	<td><?php echo $s["Sprint"]["finished_point_per_sprint"]; ?></td>
	<td><?php echo $s["Sprint"]["point_per_sprint"]; ?></td>
	<td><?php echo $s["Sprint"]["total_remaining_point"]; ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
	<td class="summary"><?php echo __('Total', true); ?></td>
	<td class="summary"><?php echo $total_finished; ?></td>
	<td class="summary"><?php echo $total_story; ?></td>
	<td class="summary">&nbsp;</td>
	</tr>
	</table>
	</div>
</div>
