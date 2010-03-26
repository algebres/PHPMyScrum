<div class="remainingTimes index">
	<h2><?php __('Remaining Times');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('task_id');?></th>
			<th><?php echo $this->Paginator->sort('hours');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($remainingTimes as $remainingTime):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $remainingTime['RemainingTime']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($remainingTime['Task']['name'], array('controller' => 'tasks', 'action' => 'view', $remainingTime['Task']['id'])); ?>
		</td>
		<td><?php echo $remainingTime['RemainingTime']['hours']; ?>&nbsp;</td>
		<td><?php echo $remainingTime['RemainingTime']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $remainingTime['RemainingTime']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $remainingTime['RemainingTime']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $remainingTime['RemainingTime']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $remainingTime['RemainingTime']['id'])); ?>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Remaining Time', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>