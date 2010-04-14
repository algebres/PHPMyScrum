<?php echo $javascript->link("drag"); ?>

<style type="text/css">

td {
	vertical-align: top;
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
		var obj_old     = REDIPS.drag.obj_old;	// reference to the original object
		//alert(REDIPS.drag.target_cell.id);
		//alert(REDIPS.drag.source_cell.id);
		//if(REDIPS.drag.target_cell.parentNode.id != REDIPS.drag.source_cell.parentNode.id)
		//{
		//	REDIPS.drag.target_cell.removeChild(obj);
		//	REDIPS.drag.source_cell.appendChild(obj);
		//	return;
		//}
		if(obj.id.indexOf("story_id:") != -1 && obj.parentNode.id.indexOf("sprint_id:") != -1)
		{
			url = "<?php echo $html->url('/stories/change_sprint/'); ?>" + obj.id + "/" + obj.parentNode.id;
			//alert(url);
			jQuery.get(url, {}, after_function );
		}
	}
}
function after_function(data) {
	//TODO? callbackで配下のタスクを移動するかどうか聞くべきかも
	alert(data);
}
</script>

<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('controller' => 'priorities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
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
	<table>
	<tr>
		<?php foreach($sprints as $sprint): ?>
		<?php if($sprint['Sprint']['id'] != 0) { ?>
		<th><?php echo $this->Html->link($sprint["Sprint"]["name"], array('controller' => 'sprints', 'action' => 'view', $sprint['Sprint']['id'])); ?></th>
		<?php } else { ?>
		<th><?php echo $sprint["Sprint"]["name"]; ?></th>
		<?php } ?>
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
		<?php echo $story["Story"]["name"]; ?>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
		</td>
		<?php endforeach; ?>
	</tr>
	</table>
	</div>

</div>
