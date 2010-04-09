<?php echo $javascript->link("drag"); ?>
<style type="text/css">

td {
	vertical-align: top;
}

.drag{
	position: relative;
	border:2px solid #ffebcd;
	background: #ffebcd;
	margin:4px;
}

.storytitle {
	background: #ffd700;
}
</style>
<script type="text/javascript">
window.onload = function () {  
	// number of successfully placed elements  
	var num = 0;  
	// initialization  
	REDIPS.drag.init();  
	REDIPS.drag.myhandler_dropped = function () {
		var obj = REDIPS.drag.obj;
		url = "<?php echo $html->url('/tasks/change_resolution/'); ?>" + obj.id + "/" + obj.parentNode.id;
		jQuery.get(url, {}, after_function );
	}
}
function after_function(data) {
	//alert('<?php echo __('Updated!', true); ?>');
	alert(data);
}
</script>

<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Sprint', true)), array('action' => 'edit', $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Sprint', true)), array('action' => 'delete', $sprint['Sprint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprint Stories', true)), array('action' => 'storylist', $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Taskboard', true), array('action' => 'taskboard', $sprint['Sprint']['id'])); ?> </li>
	</ul>
</div>

<div class="sprints view">
<h2><?php  __('Sprint');?>&nbsp;#<?php echo $sprint['Sprint']['id']; ?>&nbsp;<?php echo h($sprint['Sprint']['name']); ?></h2>

<div id="drag">
<table>
<tr>
<?php foreach($resolutions as $resolution) { ?>
<th width="<?php echo intval(100 / count($resolutions)); ?>%"><?php echo $resolution["Resolution"]["name"]; ?></th>
<?php } ?>
</tr>

<tr>
<?php foreach($resolutions as $resolution) { ?>
	<td id="resolution_id:<?php echo $resolution["Resolution"]["id"]; ?>">
	<?php foreach($sprint['Task'] as $task) { ?>
		<?php if($task["resolution_id"] == "") { $task["resolution_id"] = RESOLUTION_TODO; } ?>
		<?php if($task["resolution_id"] == $resolution["Resolution"]["id"]) { ?>
		<div class="drag" id="task_id:<?php echo $task["id"];?>">
			<div class="storytitle">#<?php echo $this->Html->link($task["Story"]["id"], array('controller' => 'stories', 'action' => 'view', $sprint['Sprint']['id'])); ?>&nbsp;<?php echo $task["Story"]["name"]; ?></div>
			<?php $username = $task["User"]["username"]; if($username == "") { $username = __('Not Assigned', true); } ?>
			<?php echo $this->Html->link($task["id"], array('controller' => 'tasks', 'action' => 'view', $task['id'])); ?>&nbsp;<?php echo $task["name"]; ?>&nbsp;(<?php echo $username; ?>)
		</div>
		<?php } ?>
	<?php } ?>
	</td>
<?php } ?>
</tr>
</table>
</div>
</div>
