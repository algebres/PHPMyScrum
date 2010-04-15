<?php echo $javascript->link("drag"); ?>

<style type="text/css">

td {
	vertical-align: top;
}
</style>

<script type="text/javascript">
window.onload = function () {
	total_storypoints();
	// number of successfully placed elements
	var num = 0;
	// initialization
	REDIPS.drag.init();
	REDIPS.drag.myhandler_dropped = function () {
		var obj = REDIPS.drag.obj;
		var obj_old     = REDIPS.drag.obj_old;	// reference to the original object
		if(obj.id.indexOf("story_id:") != -1 && obj.parentNode.id.indexOf("sprint_id:") != -1)
		{
			total_storypoints();
			url = "<?php echo $html->url('/stories/change_sprint/'); ?>" + obj.id + "/" + obj.parentNode.id;
			jQuery.get(url, {}, after_function );
		}
	}

	function after_function(data) {
		//TODO? callbackで配下のタスクを移動するかどうか聞くべきかも
		alert(data);
	}

	function total_storypoints()
	{
		var sprints = new Array(<?php echo count($sprints); ?>);
		var total_points = new Array(<?php echo count($sprints); ?>);
		for(i =0; i< total_points.length; i++)
		{
			total_points[i] = 0;
		}
	<?php
	$cnt = 0;
	foreach($sprints as $sprint) {
		echo sprintf("\tsprints[%d] = \"sprint_id:%d\";\n", $cnt, $sprint["Sprint"]["id"]);
		$cnt++;
	}
	?>
		$("#story_table").find(".h_storypoints").each(function()
			{
				for(i=0; i < sprints.length; i++)
				{
					if($(this).parent().parent().attr('id') == sprints[i])
					{
						total_points[i] = total_points[i] + parseInt($(this).val());
					}
				}
			}
		);
		$("div .t_sprint").each(function(){
			for(i =0; i< sprints.length; i++)
			{
				if($(this).attr("id") == "t_" + sprints[i])
				{
					$(this).html(total_points[i].toString());
				}
			}
		});
	}
}
</script>

<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?></li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('Excel', true)), array('controller' => 'stories', 'action' => 'output', 'type' => 'xls')); ?> </li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('CSV', true)), array('controller' => 'stories', 'action' => 'output', 'type' => 'csv')); ?> </li>
		<?php if($login_user["admin"] == true) { ?>
		<li class="upload"><?php echo $this->Html->link(sprintf(__('Bulk upload %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'upload')); ?> </li>
		<?php } ?>
	</ul>
</div>

<div class="stories index">
	<h2><?php __('Product Backlog');?></h2>

	<div id="drag">
	<form>
	<table id="story_table">
	<tr>
		<?php foreach($sprints as $sprint): ?>
		<?php if($sprint['Sprint']['id'] != 0) { ?>
		<th><?php echo $this->Html->link($sprint["Sprint"]["name"], array('controller' => 'sprints', 'action' => 'view', $sprint['Sprint']['id'])); ?></th>
		<?php } else { ?>
		<th><?php echo h($sprint["Sprint"]["name"]); ?></th>
		<?php } ?>
		<?php endforeach; ?>
	</tr>
	<tr>
	<?php foreach($sprints as $sprint): ?>
	<td>
	<div class="t_sprint" id="t_sprint_id:<?php echo $sprint["Sprint"]["id"]; ?>">&nbsp;</div>
	</td>
	<?php endforeach; ?>
	</tr>
	<tr>
		<?php foreach($sprints as $sprint): ?>
		<td style="width: <?php echo 100 / count($sprints); ?>%;" id="sprint_id:<?php echo $sprint["Sprint"]["id"]; ?>">
		<?php foreach($stories as $story): ?>
		<?php if($sprint["Sprint"]["id"] == $story["Story"]["sprint_id"]): ?>
		<?php if($story["Resolution"]["is_fixed"]) {
			$class = "board_story_done";
		} else {
			$class = "drag board_story";
		}
		?>
		<div class="<?php echo $class; ?>" id="story_id:<?php echo $story["Story"]["id"];?>">
		<?php echo $this->Html->link("#" . $story['Story']['id'], array('action' => 'view', $story['Story']['id'])); ?>&nbsp;
		<?php echo h($story["Story"]["name"]); ?>
		<input type="hidden" class="h_storypoints" name="storypoints_<?php echo $story['Story']['id']; ?>" value="<?php echo $story['Story']['storypoints']; ?>" />
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
		</td>
		<?php endforeach; ?>
	</tr>
	</table>
	</form>
	</div>
</div>
