<?php if(!$has_admin) { ?>
<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('action' => 'add')); ?> </li>
	</ul>
</div>
<?php } ?>

<div id="leftbox" style="float:left; width:400px;">
<div class="users view" style="width:380px;">
<h2><?php  __('User');?></h2>

<?php if  ($session->check('Message.auth')) $session->flash('auth'); ?>

<?php echo $form->create('User', array('action' => 'login')); ?>
<?php echo $form->input('loginname', array('size' => 30)); ?><br />
<?php echo $form->input('password',array('type' => 'password', 'size' => 30 ));?><br />
<?php echo $form->submit('ログイン'); ?>
<?php echo $form->end(); ?>
</div>

<div id="rightbox" style="float:right; width:400px;">
<?php echo $this->element("information"); ?>
</div>

</div>

