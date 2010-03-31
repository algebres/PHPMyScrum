<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('controller' => 'priorities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="stories form">
<?php echo $this->Form->create('Story');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Story', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('storypoints');
		echo $this->Form->input('businessvalue');
		echo $this->Form->input('priority_id', array('options' => $priorities, 'empty' => ' '));
		echo $this->Form->input('sprint_id', array('options' => $sprints, 'empty' => ' '));
		echo $this->Form->input('team_id', array('options' => $teams, 'empty' => ' '));
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
