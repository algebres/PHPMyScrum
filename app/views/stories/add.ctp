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
		echo $this->Form->input('name', array('title' => __('As a <User> I want <function> So that <desired result>', true), 'class' => 'help'));
		echo $this->Form->input('description', array('title' => __('More detailed information here', true), 'class' => 'help'));
		echo $this->Form->input('storypoints', array('label' => __('StoryPoints', true), 'required' => true, 'title' => __('Relative story size here.(numerical value only)', true), 'class' => 'help'));
		echo $this->Form->input('businessvalue', array('title' => __('Relative value size for product owner here.(numerical value only)', true), 'class' => 'help'));
		echo $this->Form->input('priority_id', array('options' => $priorities, 'empty' => ' '));
		echo $this->Form->input('sprint_id', array('options' => $sprints, 'empty' => ' '));
		echo $this->Form->input('resolution_id', array('options' => $resolutions, 'empty' => ' '));
		echo $this->Form->input('team_id', array('options' => $teams, 'empty' => ' '));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
