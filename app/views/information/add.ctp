<div id="snavi">
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Information', true)), array('action' => 'index'));?></li>
	</ul>
</div>

<div class="information form">
<?php echo $this->Form->create('Information');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Information', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('show_anonymous');
		echo $this->Form->input('disabled');
		//echo $this->Form->input('startdate');
		//echo $this->Form->input('enddate');
	?>
	<div class="input">
	<label id="InformationStartdate"><?php __('Startdate'); ?></label>
	<?php echo $this->Form->datetime('startdate', 'YMD', 'NONE' , null, array('minYear' => date('Y'), 'maxYear' => date('Y') + 2, 'separator' => ' / '), true); ?>
	</div>
	<div class="input">
	<label id="InformationEnddate"><?php __('Enddate'); ?></label>
	<?php echo $this->Form->datetime('enddate', 'YMD', 'NONE' , null, array('minYear' => date('Y'), 'maxYear' => date('Y') + 2, 'separator' => ' / '), true); ?>
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
