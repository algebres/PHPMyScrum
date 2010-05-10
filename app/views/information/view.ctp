<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Information', true)), array('action' => 'index')); ?> </li>
		<?php if($login_user["admin"]) { ?>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Information', true)), array('action' => 'add')); ?> </li>
		<?php } ?>
	</ul>
</div>


<div class="information view">
<h2><?php  __('Information');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('Y-m-d', strtotime($information['Information']['startdate'])); ?>
			&nbsp;
		</dd>
<?php if($login_user["admin"]) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $information['Information']['id']; ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $information['Information']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($information['Information']['description']); ?>
			&nbsp;
		</dd>
<?php if($login_user["admin"]) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Show Anonymous'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $information['Information']['show_anonymous']; ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Enddate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('Y-m-d', strtotime($information['Information']['enddate'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
