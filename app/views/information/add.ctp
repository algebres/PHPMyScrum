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
		echo $this->Form->input('startdate');
		echo $this->Form->input('enddate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
