<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo __($title_for_layout); ?> | <?php echo(h($project_info["name"])); ?> | <?php __('phpmyscrum'); ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $scripts_for_layout;
		echo $html->css('flexigrid/flexigrid');
		if($login_user) {
			echo $javascript->link('prototype');
			echo $javascript->link('jquery');
			echo $javascript->link('flexigrid');
		}
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="<?php echo $html->url('/users/dashboard'); ?>"><?php echo $html->image('logo.png'); ?></a></h1>
			<div id="userinfo">
				<?php if($login_user) { ?>
				<?php echo __('Username') ."&nbsp;:&nbsp;". $login_user['username']; ?>
					<?php if($login_user["admin"]) { ?>
					<br /><?php echo __('Administrator'); ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<div id="content">
			<?php if($login_user) { ?>
			<div id="gnavi">
				<ul>
					<li><?php echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboard')); ?> </li>
					<li><?php echo $this->Html->link(__('Product Backlog', true), array('controller' => 'stories', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprints', true)), array('controller' => 'sprints', 'action' => 'index')); ?>
						<?php if(count($sprint_info) > 0 ) { ?>
						<ul>
							<?php foreach ($sprint_info as $key => $value) { ?>
							<li><?php echo $this->Html->link($value, array('controller' => 'sprints', 'action' => 'view', $key)); ?></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
					<?php if($login_user["admin"] == true) { ?>
					<li><?php echo $this->Html->link(__('Manage', true), array('controller' => 'pages', 'action' => 'manage')); ?> </li>
					<?php } ?>
					<li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?> </li>
				</ul>
			</div>
			<?php } ?>
			<?php if($this->Session->check('Message')) { ?>
			<div id="messagebox">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			</div>
			<?php } ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
		<p>Copyright &copy; <?php echo date('Y'); ?> Ryuzee, Licensed under GPL3.</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>