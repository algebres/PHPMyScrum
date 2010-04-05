<div class="information index" style="width:360px; margin-right:20px;">
	<h2><?php __('Information');?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php
	$i = 0;
	foreach ($information as $information):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style="width:70px;"><?php echo date('Y-m-d', strtotime($information['Information']['startdate'])); ?>&nbsp;</td>
		<?php if(@$show_link == true) { ?>
		<td><?php echo $this->Html->link($information['Information']['name'], array('controller' => 'information', 'action' => 'view', $information['Information']['id'])); ?></td>
		<?php } else { ?>
		<td><?php echo $information['Information']['name']; ?></td>
		<?php } ?>
	</tr>
<?php endforeach; ?>
	</table>
</div>
