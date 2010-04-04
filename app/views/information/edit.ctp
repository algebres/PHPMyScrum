<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Information.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Information.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Information', true)), array('action' => 'index'));?></li>
	</ul>
</div>

<div class="information form">
<?php echo $this->Form->create('Information');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Information', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
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
