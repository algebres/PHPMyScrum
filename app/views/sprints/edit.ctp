<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Sprint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Sprint.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="sprints form">
<?php echo $this->Form->create('Sprint');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Sprint', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
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
