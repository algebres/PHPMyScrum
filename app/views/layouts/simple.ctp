<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
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
</head>
<body>
<?php echo $content_for_layout;?>
</body>
</html>
