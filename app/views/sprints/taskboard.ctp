<?php echo $javascript->link("drag"); ?>
<style type="text/css">

td {
	vertical-align: top;
}

<script type="text/javascript">
window.onload = function () {
	// number of successfully placed elements
	var num = 0;
	// initialization
	REDIPS.drag.init();
	REDIPS.drag.myhandler_dropped = function () {
		var obj = REDIPS.drag.obj;
		var obj_old     = REDIPS.drag.obj_old;	// reference to the original object
		//alert(REDIPS.drag.target_cell.parentNode.id);
		//alert(REDIPS.drag.source_cell.parentNode.id);
		if(REDIPS.drag.target_cell.parentNode.id != REDIPS.drag.source_cell.parentNode.id)
		{
			REDIPS.drag.target_cell.removeChild(obj);
			REDIPS.drag.source_cell.appendChild(obj);
			return;
		}

		if(obj.id.indexOf("task_id:") != -1 && obj.parentNode.id.indexOf("resolution_id:") != -1)
		{
			url_param = obj.parentNode.id.replace("___", "/");
			url = "<?php echo $html->url('/tasks/change_resolution/'); ?>" + obj.id + "/" + url_param;
			//alert(url);
			jQuery.get(url, {}, after_function );
		}
	}
}
function after_function(data) {
	//alert('<?php echo __('Updated!', true); ?>');
	alert(data);
}
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("a[rel^='prettyPopin']").prettyPopin({
            modal : true,
            width : 400,
            height: 400,
            opacity: 0.5,
            animationSpeed: '0',
            followScroll: true,
            loader_path: '<?php echo $html->url("/img/prettyPopin/loader.gif"); ?>',
            callback: function(){
                //alert('test');
            }
        });
    });
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
<th><?php echo __('Story', true); ?></th>
<?php foreach($resolutions as $resolution) { ?>
<th width="<?php echo intval(100 / (count($resolutions) + 1)); ?>%"><?php echo $resolution["Resolution"]["name"]; ?></th>
<?php } ?>
</tr>

<? foreach ($sprint['Story'] as $story): ?>
<tr id="story:<?php echo $story["id"]; ?>">
<td class="mark">
<div class="board_story">
#<?php echo $story['id']; ?>&nbsp;<?php echo $this->Html->link($story["name"], array('controller' => 'stories', 'action' => 'simple_view', $story['id']), array('rel' => 'prettyPopin')); ?>
<?php if(Configure::read('Config.display_description_in_the_taskboard') == true){ ?>
<p><?php e(nl2br($story["description"])); ?></p>
<?php } ?>
</div>
</td>
<?php foreach($resolutions as $resolution) { ?>
	<td id="resolution_id:<?php echo $resolution["Resolution"]["id"]; ?>___story_id:<?php echo $story["id"]; ?>">
	<?php foreach($sprint['Task'] as $task) { ?>
		<?php if($task["resolution_id"] == "") { $task["resolution_id"] = RESOLUTION_TODO; } ?>
		<?php if($task["resolution_id"] == $resolution["Resolution"]["id"] && $story["id"] == $task["story_id"]) { ?>
		<div class="drag" id="task_id:<?php echo $task["id"];?>">
			<?php $username = $task["User"]["username"]; if($username == "") { $username = __('Not Assigned', true); } ?>
			<?php echo $this->Html->link($task["id"], array('controller' => 'tasks', 'action' => 'simple_view', $task['id']), array('rel' => 'prettyPopin')); ?>&nbsp;<?php echo $task["name"]; ?>&nbsp;(<?php echo $username; ?>)
		</div>
		<?php } ?>
	<?php } ?>
	</td>
<?php } ?>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
