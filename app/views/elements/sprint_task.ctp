<?php echo $javascript->link('excanvas'); ?>
<?php echo $javascript->link('ProtoChart'); ?>
<?php echo $javascript->link('superTable'); ?>

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function() 
{
    jQuery('#sprint_tasks_table').flexigrid({height:'auto',striped:false});
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
		if($sum != "" && $cal <= date('Y-m-d'))
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
			$username = @$a["User"]["username"];
			if($username == "") { $username = __('Not Assigned', true); }
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

	// 円
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
<div class="linechart" id="linechart" style="width:650px;height:240px;float:left"></div>
<div class="piechart" id="piechart" style="width:250px;height:240px;float:right"></div>

<br clear="all" />
<br />
<div class="fakeContainer">
<table id="sprint_tasks_table" cellpadding = "0" cellspacing = "0">
<tr>
<th colspan="3"><?php __('TaskRemainingHours'); ?></th>
<?php // 横軸の日付を書く ?>
<?php $day_count = 0; ?>
<?php foreach($sprint_calendar as $cal) { $day_count++; ?>
<th class="center"><?php echo date('d', strtotime($cal)); ?></th>
<?php } ?>
</tr>

<?php // 縦軸のタスクを書く ?>
<?php $story_id = ""; ?>
<?php foreach($sprint_remaining_hours as $a) { ?>
<?php if($a["Story"]["id"] != $story_id) {
	$story_id = $a["Story"]["id"];
	$link = $html->url("/stories/view/" . $a["Story"]["id"]);
	//$icon = $html->image('detail.png');
	echo sprintf('<tr><th colspan="%d" class="story_bar"><br /><a href="%s">%s</a></th></tr>', $day_count + 3, $link, "#" .$a["Story"]["id"] . "&nbsp;" .  h($a["Story"]["name"]));
}
?>
<tr>
<td><?php echo $a["id"]; ?></td>
<td><?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $a['id'], '?' => array('return_url' => $_SERVER['REQUEST_URI'])), array('escape' => false)); ?>&nbsp;<?php echo $this->Html->link($a["name"], array('controller' => 'tasks', 'action' => 'view', $a['id'])); ?></td>
<td><?php echo $this->Html->link($a["User"]["username"], array('controller' => 'users', 'action' => 'view', $a["user_id"])); ?></td>
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
<td colspan="3" class="summary"><?php __('Sum'); ?></td>
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
