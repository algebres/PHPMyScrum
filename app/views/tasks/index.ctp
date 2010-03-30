<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('action' => 'add')); ?></li>
	</ul>
</div>


<div class="tasks index">
	<h2><?php __('Tasks');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('sprint_id');?></th>
			<th><?php echo $this->Paginator->sort('story_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('estimate_hours');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
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
			<?php echo $this->Html->link($task['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $task['Sprint']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($task['Story']['name'], array('controller' => 'stories', 'action' => 'view', $task['Story']['id'])); ?>
		</td>
		<td><?php echo $task['Task']['name']; ?>&nbsp;</td>
		<td><?php echo $task['Task']['estimate_hours']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($task['User']['username'], array('controller' => 'users', 'action' => 'view', $task['User']['id'])); ?>
		</td>
		<td><?php echo $task['Task']['created']; ?>&nbsp;</td>
		<td><?php echo $task['Task']['updated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $task['Task']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $task['Task']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $task['Task']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $task['Task']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
