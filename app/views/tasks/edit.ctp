<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Task.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Task.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('action' => 'index'));?></li>
	</ul>
</div>


<div class="tasks form">
<?php echo $this->Form->create('Task');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Task', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sprint_id');
		echo $this->Form->input('story_id');
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
