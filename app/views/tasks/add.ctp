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
		echo $this->Form->input('sprint_id', array('value' => $sprint_id));
		echo $this->Form->input('story_id', array('value' => $story_id));
		echo $this->Form->input('name', array('title' => __('Task name here. Comprehensible for the team', true), 'class' => 'help'));
		echo $this->Form->input('description', array('title' => __('More detailed information here', true), 'class' => 'help'));
		echo $this->Form->input('estimate_hours', array('title' => __('The time required until task ends', true), 'class' => 'help'));
		echo $this->Form->input('resolution_id', array('options' => $resolutions, 'empty' => ' '));
		echo $this->Form->input('user_id', array('options' => $users, 'empty' => ' '));
		echo $this->Form->hidden('return_url', array('value' => urlencode($return_url)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
