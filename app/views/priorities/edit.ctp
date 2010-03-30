<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Priority.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Priority.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('action' => 'index'));?></li>
	</ul>
</div>


<div class="priorities form">
<?php echo $this->Form->create('Priority');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Priority', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
