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
		echo $this->Form->input('startdate', array('maxYear' => date('Y') + 1, 'minYear' => date('Y') -1, 'dateFormat'=>'YMD','timeFormat'=>'NONE', 'monthNames' => false));
		echo $this->Form->input('enddate', array('maxYear' => date('Y') + 3, 'minYear' => date('Y') -1, 'dateFormat'=>'YMD','timeFormat'=>'NONE', 'monthNames' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
