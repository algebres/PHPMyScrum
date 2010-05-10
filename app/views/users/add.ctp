<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="wiki">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('User', true)); ?></legend>
	<?php
		echo $this->Form->input('loginname');
		echo $this->Form->input('password');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		if($login_user["admin"]) {
			echo $this->Form->input('admin');
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
