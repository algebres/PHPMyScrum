<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teams', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="teams form">
<?php echo $this->Form->create('Team');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Team', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
