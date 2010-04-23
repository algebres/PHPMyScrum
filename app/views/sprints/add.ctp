<div class="sprints form">
<?php echo $this->Form->create('Sprint');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Sprint', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		$options["timeFormat"] = "24";
		$options["dateFormat"] = "YMD";
		$options["monthNames"] = false;
		$options["interval"] = 60;
		$options["maxYear"] = date('Y') + 1;
		echo $this->Form->input('startdate', $options);
		echo $this->Form->input('enddate', $options);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
