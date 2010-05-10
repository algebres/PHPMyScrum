<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('All %s', true), __('Task', true)), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('All unfinished %s', true), __('Task', true)), array('action' => 'index', 'filter:unfinished')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('All your %s', true), __('Task', true)), array('action' => 'index', 'filter:yours')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('All your unfinished %s', true), __('Task', true)), array('action' => 'index', 'filter:your_unfinished')); ?></li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('Excel', true)), array('action' => 'output', 'type' => 'xls')); ?></li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('CSV', true)), array('action' => 'output', 'type' => 'csv')); ?></li>
	</ul>
</div>

<div class="tasks form">
<?php echo $form->create('Task' ,array('type' => 'file'));?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Task', true)); ?></legend>
		<?php echo $form->file('upfile', array('size' => 50));?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

