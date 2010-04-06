<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Team.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Team.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teams', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="teams form">
<?php echo $this->Form->create('Team');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Team', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
