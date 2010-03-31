<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('controller' => 'sprints', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="tasks form">
<?php echo $this->Form->create('Task');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Task', true)); ?></legend>
	<?php
		echo $this->Form->input('sprint_id');
		echo $this->Form->input('story_id', array('value' => $story_id));
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('estimate_hours');
		echo $this->Form->input('resolution_id', array('options' => $resolutions, 'empty' => ' '));
		echo $this->Form->input('user_id', array('options' => $users, 'empty' => ' '));
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
