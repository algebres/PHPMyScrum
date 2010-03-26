<div class="remainingTimes form">
<?php echo $this->Form->create('RemainingTime');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Remaining Time', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('task_id');
		echo $this->Form->input('hours');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('RemainingTime.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('RemainingTime.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Remaining Times', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>