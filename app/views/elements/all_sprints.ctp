<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>


<script type="text/javascript">
jQuery.noConflict();
jQuery(function(){
	var d1 = [];
	var d2 = [];
	var labels = [];
	var max_yaxis = 0;
	<?php
	$cnt =0;
	$max = 0;
	foreach($all_sprints as $sprint) {
		if($max <= $sprint["Sprint"]["point_per_sprint"])
		{
			$max = $sprint["Sprint"]["point_per_sprint"];
		}
		echo sprintf("\td1.push([%d, %d]);\n", $cnt, $sprint["Sprint"]["point_per_sprint"]);
		echo sprintf("\tlabels.push([%d, \"%s\"]);\n", $cnt, $sprint["Sprint"]["name"]);
		echo sprintf("\td2.push([%d, %d]);\n", $cnt, $sprint["Sprint"]["finished_point_per_sprint"]);
		$cnt++;
	}
	?>

	new Proto.Chart($('linechart'), 
	[
		{data: d1, label: "Data 1"},
		{data: d2, label: "Data 2"}
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

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#all_sprints_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>

<div class="sprints index">
	<h2><?php echo sprintf(__("All %s", true), __('Sprints', true));?></h2>

	<div class="linechart" id="linechart" style="width:70%;height:240px;float:left; margin:10px;"></div>

	<div id="">
	<table cellpadding="0" cellspacing="0" id="all_sprints_table">
	<tr>
	<th><?php __('Sprint'); ?></th>
	<th><?php __('Total Finished Story Point'); ?></th>
	<th><?php __('Total Story Point'); ?></th>
	</tr>
	<?php foreach($all_sprints as $s): ?>
	<tr>
	<td><?php echo $s["Sprint"]["name"]; ?></td>
	<td><?php echo $s["Sprint"]["finished_point_per_sprint"]; ?></td>
	<td><?php echo $s["Sprint"]["point_per_sprint"]; ?></td>
	</tr>
	<?php endforeach; ?>
	</table>
	</div>
</div>
