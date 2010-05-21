<div class="information index">
	<h2><?php __('Information');?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php
	$i = 0;
	foreach ($information as $info):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style="width:70px;"><?php echo date('Y-m-d', strtotime($info['Information']['startdate'])); ?>&nbsp;</td>
		<?php if(@$show_link == true) { ?>
		<td><?php echo $this->Html->link($info['Information']['name'], array('controller' => 'information', 'action' => 'view', $info['Information']['id'])); ?></td>
		<?php } else { ?>
		<td><?php echo $info['Information']['name']; ?></td>
		<?php } ?>
	</tr>
<?php endforeach; ?>
	<?php if (count($information) == 0) { ?>
	<tr><td><?php echo __("There is no information.", true); ?></td></tr>
	<?php } ?> 
	</table>
</div>
