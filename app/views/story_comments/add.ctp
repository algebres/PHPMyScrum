<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="storyComments form">
<?php echo $this->Form->create('StoryComment');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Story Comment', true)); ?></legend>
	<?php
		echo $this->Form->input('story_id', array('value' => $story_id));
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
