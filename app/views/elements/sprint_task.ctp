<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>

<script type="text/javascript">
<!--
jQuery(document).ready(function() 
{
    jQuery('#sprint_tasks_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>


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
		if($cal <= date('Y-m-d'))
		{
			// 縦軸最大値を求める
			if($sum >= $y_max) {
				$y_max = $sum;
			}
			echo sprintf("\td6.push([%d, %d]);\n", $cnt, $sum);
			echo sprintf("\tlabels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		else
		{
			echo sprintf("\tlabels.push([%d, \"%s\"]);\n", $cnt, date('d', strtotime($cal)));
		}
		$cnt++;
	}
	echo sprintf("\td7.push([%d, %d]);\n", $burndown_x_pos, $burndown_y_pos);
	echo sprintf("\td7.push([%d, %d]);\n", $cnt-1, 0);
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

	<?php
	$users = array();
	$tasks = array();
	$cnt = 0;
	foreach($sprint_remaining_hours as $a) { 
		if(!in_array($a["user_id"], $users))
		{
			$users[$cnt] = @$a["user_id"];
			$tasks[$cnt] = 1;
			$cnt++;
			echo sprintf("\tvar d_user_%d = []\n", $a["user_id"]);
			if(isset($a["User"]["username"]))
			{
				$username = $a["User"]["username"];
			}
			else
			{
				$username = __('Not Assigned', true);
			}
			echo sprintf("\tvar l_user_%d = \"%s\"\n", $a["user_id"], $username);
		}
		else
		{
			for($i=0; $i<count($users); $i++)
			{
				if($users[$i] == $a["user_id"])
				{
					$tasks[$i]++;
				}
			}
		}
	}

	for($i=0; $i<count($users); $i++){
		echo sprintf("\td_user_%d.push([0, %d]);", $users[$i], $tasks[$i]);
	}
	?>

	// pie
	new Proto.Chart($('piechart'), 
	[
		<?php 
		for($i=0; $i<count($users); $i++)
		{
			if($i != 0) {
				echo ",";
			}
			echo sprintf("{data: d_user_%d, label: l_user_%d}\n", $users[$i], $users[$i]);
		}
		?>
	],
	{
		pies: {show: true, autoScale: true},
		legend: {show: true}
	});
});	
</script>
<div class="linechart" id="linechart" style="width:70%;height:240px;float:left"></div>
<div class="piechart" id="piechart" style="width:30%;height:240px;float:right"></div>

<br clear="all" />
<br />
<div class="fakeContainer">
<table id="sprint_tasks_table" cellpadding = "0" cellspacing = "0">
<tr>
	<th colspan="4"><?php __('TaskRemainingHours'); ?></th>
	<?php // 横軸の日付を書く ?>
	<?php $day_count = 0; ?>
	<?php foreach($sprint_calendar as $cal) { $day_count++; ?>
	<th class="center"><?php echo date('d', strtotime($cal)); ?></th>
	<?php } ?>
</tr>

<?php // 縦軸のタスクを書く ?>
<?php foreach($sprint["Story"] as $s) { ?>
<?php 
$link = $html->url("/stories/view/" . $s["id"]);
//$icon = $html->image('detail.png');
echo sprintf('<tr><th colspan="%d" class="story_bar"><a href="%s">%s</a></th></tr>', $day_count + 4, $link, "#" .$s["id"] . "&nbsp;" .  h($s["name"]));
?>

<?php foreach($sprint_remaining_hours as $a) { ?>
<?php
	$class = null;
	if(@$a["resolution_id"] == RESOLUTION_DONE)
	{
		$class = ' class="done"';
	}
?>
<?php if($a["story_id"] == $s["id"]) { ?>
<tr<?php echo $class;?>>
	<td><?php echo $a["id"]; ?></td>
	<td><?php echo $this->Html->link($a["name"], array('controller' => 'tasks', 'action' => 'view', $a['id'])); ?></td>
	<td><?php echo $this->Html->link(@$a["User"]["username"], array('controller' => 'users', 'action' => 'view', $a["user_id"])); ?></td>
	<td><?php if(@$a["resolution_id"] != RESOLUTION_DONE) { ?><?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $a['id'], '?' => array('return_url' => urlencode($_SERVER['REQUEST_URI']))), array('escape' => false)); ?><?php } ?>&nbsp;<?php echo $a["Resolution"]["name"]; ?></td>
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
<?php } ?>
<?php } ?>

<tr>
	<td colspan="4" class="summary"><?php __('Sum'); ?></td>
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
