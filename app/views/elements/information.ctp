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
		<td class="narrow"><?php echo date('Y-m-d', strtotime($information['Information']['startdate'])); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($information['Information']['name'], array('controller' => 'information', 'action' => 'view', $information['Information']['id'])); ?></td>

	</tr>
<?php endforeach; ?>
	</table>
</div>
