<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Story.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Story.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="stories form">
<?php echo $this->Form->create('Story');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Story', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('storypoints');
		echo $this->Form->input('businessvalue');
		echo $this->Form->input('sprint_id');
		echo $this->Form->input('priority_id');
		echo $this->Form->input('team_id');
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
