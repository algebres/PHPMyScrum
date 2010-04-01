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
	<title><?php echo __($title_for_layout); ?> | <?php __('phpmyscrum'); ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $html->css('superTable');
		//echo $html->css('lightbox');
		echo $scripts_for_layout;
		echo $javascript->link('prototype');
		//echo $javascript->link('scriptaculous/scriptaculous');
		//echo $javascript->link('lightbox/lightbox');
		//echo $javascript->link('helpballoon/src/HelpBalloon');
	?>
<?php if(0) { ?>
	<script type="text/javascript">
	<!--
	//
	// Override the default settings to point to the parent directory
	//
	HelpBalloon.Options.prototype = Object.extend(HelpBalloon.Options.prototype, {
		icon: '/img/info.png',
		button: '/js/helpballoon/images/button.png',
		balloonPrefix: '/js/helpballoon/images/balloon-'
	});
	
	//-->
	</script>
<?php } ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="<?php echo $html->url('/users/dashboard'); ?>"><?php echo $html->image('logo.png'); ?></a></h1>
		</div>
		<div id="content">
			<div id="gnavi">
				<ul>
					<li><?php echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboard')); ?> </li>
					<li><?php echo $this->Html->link(__('Product Backlog', true), array('controller' => 'stories', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprints', true)), array('controller' => 'sprints', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
					<li><?php echo $this->Html->link(__('Manage', true), array('controller' => 'pages', 'action' => 'manage')); ?> </li>
					<li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?> </li>
				</ul>
			</div>
			<?php if($this->Session->check('Message')) { ?>
			<div id="messagebox">
			<?php echo $this->Session->flash(); ?>
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