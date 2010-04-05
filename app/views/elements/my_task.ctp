<div class="tasks index">
	<h2><?php echo sprintf(__("Your unfinished %s", true), __('Tasks', true));?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('id');?></th>
			<th><?php __('name');?></th>
			<th><?php __('Sprint');?></th>
			<th><?php __('Story');?></th>
			<th><?php __('estimate_hours');?></th>
			<th><?php __('User');?></th>
			<th><?php __('created');?></th>
			<?php if(0) { ?>
			<th><?php __('updated');?></th>
			<?php } ?>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($tasks as $task):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $task['Task']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($task['Task']['name'], array('controller' => 'tasks', 'action' => 'view', $task['Task']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($task['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $task['Sprint']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($task['Story']['name'], array('controller' => 'stories', 'action' => 'view', $task['Story']['id'])); ?>
		</td>
		<td><?php echo $task['Task']['estimate_hours']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($task['User']['username'], array('controller' => 'users', 'action' => 'view', $task['User']['id'])); ?>
		</td>
		<td><?php echo date('Y-m-d', strtotime($task['Task']['created'])); ?>&nbsp;</td>
		<?php if(0) { ?>
		<td><?php echo date('Y-m-d', strtotime($task['Task']['updated'])); ?>&nbsp;</td>
		<?php } ?>
		<td class="actions">
			<?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $task['Task']['id'], '?' => array('return_url' => urlencode('/users/dashboard'))), array('escape' => false), sprintf(__('Are you sure you want to chage # %s to be finished?', true), $task['Task']['id'])); ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'tasks', 'action' => 'edit', $task['Task']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'tasks', 'action' => 'delete', $task['Task']['id'], '?' => array('return_url' => urlencode('/users/dashboard'))), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $task['Task']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
