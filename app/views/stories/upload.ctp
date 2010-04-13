<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('controller' => 'priorities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('Excel', true)), array('controller' => 'stories', 'action' => 'output', 'type' => 'xls')); ?> </li>
		<li class="save"><?php echo $this->Html->link(sprintf(__('Save to %s', true), __('CSV', true)), array('controller' => 'stories', 'action' => 'output', 'type' => 'csv')); ?> </li>
		<?php if($login_user["admin"] == true) { ?>
		<li class="upload"><?php echo $this->Html->link(sprintf(__('Bulk upload %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'upload')); ?> </li>
		<?php } ?>
	</ul>
</div>

<div class="stories form">
<?php echo $form->create('Story' ,array('type' => 'file'));?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Story', true)); ?></legend>
		<?php echo $form->file('upfile', array('size' => 50));?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

