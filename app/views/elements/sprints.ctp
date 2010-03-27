<div class="sprints index">
	<h2><?php __('Sprints');?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php
	$i = 0;
	foreach ($sprints as $sprint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $sprint['Sprint']['id']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['name']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['description']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['startdate']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['enddate']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['disabled']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['created']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['updated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('controller' => 'sprints' , 'action' => 'view', $sprint['Sprint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('controller' => 'sprints' , 'action' => 'edit', $sprint['Sprint']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('controller' => 'sprints' , 'action' => 'delete', $sprint['Sprint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
