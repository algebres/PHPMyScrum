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
<?php echo "\n"; ?>
<?php 
$title = "";
if ($title_for_layout != "")
{
	$title .= __($title_for_layout, true) . " | ";
}
if (@$project_info["name"] != "")
{
	$title .= h($project_info["name"]) . " | ";
}
?>
<title><?php echo $title; ?><?php __('phpmyscrum'); ?></title>
<?php
echo $this->Html->meta('icon');
echo "\n";
echo $this->Html->css('cake.generic');
echo "\n";
echo $this->Html->css('menu_style');
echo "\n";
echo $scripts_for_layout;
echo "\n";
echo $html->css('flexigrid/flexigrid');
echo "\n";
echo $javascript->link('prototype');
echo "\n";
echo $javascript->link('jquery');
echo "\n";
echo $javascript->link('jquery.prettyPopin');
echo "\n";
echo $this->Html->css('prettyPopin');
echo "\n";
echo $javascript->link('flexigrid');
echo "\n";
?>
<script><!--
jQuery.noConflict();
//--></script>
</head>
<body>
<div id="wrapper">
	<div id="container">
		<div id="header">
			<h1><a href="<?php echo $html->url('/users/dashboard'); ?>"><?php echo $html->image('logo.png'); ?></a></h1>
			<div id="userinfo">
				<?php if(isset($login_user)) { ?>
				<?php echo __('Username') ."&nbsp;:&nbsp;"; ?><?php echo $this->Html->link("<span style=\"color:#ffffff;\">" .$login_user["username"] . "</span>", array('action' => 'edit', 'controller' => 'users', $login_user['id']), array('escape' => false)); ?>
					<?php if($login_user["admin"]) { ?>
					<br /><?php echo __('Administrator'); ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<div id="content">
			<?php if(isset($login_user)) { ?>
			<div class="menu">
				<ul>
					<li><?php echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
					<li><?php echo $this->Html->link(__('Product Backlog', true), array('controller' => 'stories', 'action' => 'index')); ?>
						<ul>
							<li><?php echo $this->Html->link(__('Product Backlog', true), array('controller' => 'stories', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link(__('Story Board', true), array('controller' => 'stories', 'action' => 'board')); ?></li>
							<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('controller' => 'stories', 'action' => 'add')); ?></li>
							<li><?php echo $this->Html->link(__('Search Story', true), array('controller' => 'stories', 'action' => 'search_index')); ?></li>
						</ul>
					</li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprints', true)), array('controller' => 'sprints', 'action' => 'index')); ?>
						<?php if(count($sprint_info) > 0 ) { ?>
						<ul>
							<?php foreach ($sprint_info as $key => $value) { ?>
							<li><?php echo $this->Html->link($value, array('controller' => 'sprints', 'action' => 'view', $key)); ?></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?>
						<ul>
							<li><?php echo $this->Html->link(sprintf(__('All %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link(sprintf(__('All unfinished %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'index', 'filter:unfinished')); ?></li>
							<li><?php echo $this->Html->link(sprintf(__('All your %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'index', 'filter:yours')); ?></li>
							<li><?php echo $this->Html->link(sprintf(__('All your unfinished %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'index', 'filter:your_unfinished')); ?></li>
							<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?></li>
						</ul>
					</li>
					<?php if($login_user["admin"] == true) { ?>
					<li><?php echo $this->Html->link(__('Manage', true), array('controller' => 'pages', 'action' => 'manage')); ?></li>
					<?php } ?>
					<li><?php echo $this->Html->link(__('Wiki', true), array('controller' => 'wiki', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?></li>
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
		<p>Copyright &copy; <?php echo date('Y'); ?> Ryuzee, Licensed under The MIT License.</p>
		</div>
	</div>
	<!-- end #container -->
</div>
<!-- end #wrapper -->
</body>
</html>