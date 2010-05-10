<div class="projects form">
<?php echo $this->Form->create('Project');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Project', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->hidden('disabled', array('value' => 0));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
