<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>
<?php echo $javascript->link('superTable'); ?>

<script type="text/javascript">
Event.observe(window, 'load', function() {
	var d6 = [];
	var d7 = [];
	var labels = [];
	<?php
	$cnt = 0;
	$y_max = 0;
	$burndown_y_pos = "";
	$burndown_x_pos = "";

	foreach($sprint_calendar as $cal) { 
		$sum = "";
		foreach($sprint_remaining_hours as $a) {
			if($a["Hours"][$cal] != "")
			{
				$sum += $a["Hours"][$cal];
			}
		}
		if($burndown_y_pos === "" && $sum != "" && $sum != 0)
		{
			$burndown_y_pos = $sum;
			$burndown_x_pos = $cnt;
		}
		if($sum != "" && $cal <= date('Y-m-d'))
		{
			// 縦軸最大値を求める
			if($sum >= $y_max) {
				$y_max = $sum;
			}
			echo sprintf("d6.push([%d, %d]);\n", $cnt, $sum);
			echo sprintf("labels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		else
		{
			echo sprintf("labels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		$cnt++;
	}
	echo sprintf("d7.push([%d, %d]);\n", $burndown_x_pos, $burndown_y_pos);
	echo sprintf("d7.push([%d, %d]);\n", $cnt-1, 0);
	?>
	new Proto.Chart($('linechart'), 
	[
		{data: d6, label: "Data 1"},
		{data: d7, label: "Data 2"}
	],
	{
		//since line chart is the default charting view
		//we do not need to pass any specific options for it.
		xaxis: {min: 0, max: <?php echo count($sprint_calendar)-1; ?>, tickSize: 1, ticks: labels },
		yaxis: {min: 0, max: <?php echo $y_max + 20; ?> },
		grid: {
			drawXAxis: true,
			drawYAxis: true
		},
	});
//    new superTable("fixtable", {
//    	cssSkin : "sDefault",
//		headerRows : 1,
//		fixedCols : 2
//    });
});	
</script>
<div class="linechart" id="linechart" style="width:800px;height:240px"></div>

<div class="fakeContainer">
<table id="fixtable" cellpadding = "0" cellspacing = "0">
<tr>
<th colspan="2"><?php __('TaskRemainingHours'); ?></th>
<?php // 横軸の日付を書く ?>
<?php $day_count = 0; ?>
<?php foreach($sprint_calendar as $cal) { $day_count++; ?>
<th><?php echo date('d', strtotime($cal)); ?></th>
<?php } ?>
</tr>

<?php // 縦軸のタスクを書く ?>
<?php $story_id = ""; ?>
<?php foreach($sprint_remaining_hours as $a) { ?>
<?php if($a["Story"]["id"] != $story_id) {
	$story_id = $a["Story"]["id"];
	$link = $html->url("/stories/view/" . $a["Story"]["id"]);
	//$icon = $html->image('detail.png');
	echo sprintf('<tr><th colspan="%d" class="story_bar"><br /><a href="%s">%s</a></th></tr>', $day_count + 2, $link, h($a["Story"]["name"]));
}
?>
<tr>
<td><?php echo $a["id"]; ?></td>
<td><?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $a['id'], '?' => array('return_url' => $_SERVER['REQUEST_URI'])), array('escape' => false)); ?>&nbsp;<?php echo $this->Html->link($a["name"], array('controller' => 'tasks', 'action' => 'view', $a['id'])); ?></td>
<?php 
$today = date('Y-m-d');
foreach($sprint_calendar as $cal) { 
?>
<?php if($cal <= $today) { ?>
<td class="past">
<?php } else { ?>
<td class="future">
<?php } ?>
<?php echo $a["Hours"][$cal]; ?>
</td>
<?php } ?>
</tr>
<?php } ?>

<tr>
<td colspan="2" class="summary"><?php __('Sum'); ?></td>
<?php foreach($sprint_calendar as $cal) { ?>
<?php
	$sum = 0;
	foreach($sprint_remaining_hours as $a) {
		$sum += $a["Hours"][$cal];
	}
	echo "<td class=\"summary\">" . $sum . "</td>";
?>
<?php } ?>
</tr>
</table>
</div>
