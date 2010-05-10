<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="priorities form">
<?php echo $this->Form->create('Priority');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Priority', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
