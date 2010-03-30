<div class="sprints form">
<?php echo $this->Form->create('Sprint');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Sprint', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('startdate');
		echo $this->Form->input('enddate');
		echo $this->Form->input('disabled');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
