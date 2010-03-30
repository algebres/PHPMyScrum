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
	<title>
		<?php __('phpmyscrum'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="<?php $html->url('/'); ?>"><?php echo $html->image('logo.png'); ?></a></h1>
		</div>
		<div id="content">
			<div id="gnavi">
				<ul>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Stories', true)), array('controller' => 'stories', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprints', true)), array('controller' => 'sprints', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('Manage %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
					<li><a href="<?php echo $html->url("/users/logout"); ?>"><?php __('Logout'); ?></a> </li>
				</ul>
			</div>
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>