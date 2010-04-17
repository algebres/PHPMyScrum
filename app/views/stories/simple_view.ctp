<?php
	$total_remaining_hours = 0;
	foreach($story['Task'] as $t) 
	{
		if($t["resolution_id"] != RESOLUTION_DONE)
		{
			$total_remaining_hours += $t["estimate_hours"];
		}
	}
?>

<div style="background:#fafafa; color:#000000; height:360px;overflow:auto;">

<h2 style="font-size:120%;background:#fafafa;"><?php  __('Story');?>&nbsp;#<?php echo $story['Story']['id']; ?><br /><?php echo $story['Story']['name']; ?></h2>

<table border="0" cellpadding="5" id="ajax_story_table" style="background:#fafafa;">
<tr>
<td colspan="2">
<div style="min-height:30px;margin-bottom:20px;">
<?php echo nl2br(h($story['Story']['description'])); ?>
</div>
</td>
</tr>
<tr>
<td><?php echo __('Businessvalue', true); ?></td>
<td><?php echo $story['Story']['businessvalue']; ?></td>
</tr>
<tr>
<td><?php echo __('Story Points', true); ?></td>
<td><?php echo $story['Story']['storypoints']; ?></td>
</tr>
<tr>
<td><?php echo sprintf(__('Count of %s', true), __('Tasks', true)); ?></td>
<td><?php echo count($story['Task']); ?></td>
</tr>
<tr>
<td><?php echo sprintf(__('Sum of %s', true), __('Remaining Hours', true)); ?></td>
<td><?php echo $total_remaining_hours; ?></td>
</tr>

<tr>
<td><?php echo __('action', true); ?></td>
<td>
<?php echo $this->Html->link(sprintf(__('Confirm %s', true), __('Story', true)), array('action' => 'view', $story['Story']['id']), array('escape' => false)); ?>
<br />
<?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Story', true)), array('action' => 'edit', $story['Story']['id']), array('escape' => false)); ?>
<br />
<?php echo $this->Html->link(sprintf(__('Add %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add', 'story_id:' . $story['Story']['id'], 'sprint_id:' . $story['Story']['sprint_id'])); ?>
</td>
</tr>
</table>

</div>