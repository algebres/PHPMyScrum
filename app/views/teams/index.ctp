<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Team', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="teams index">
	<h2><?php __('Teams');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('disabled');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($teams as $team):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $team['Team']['id']; ?>&nbsp;</td>
		<td><?php echo $team['Team']['name']; ?>&nbsp;</td>
		<td><?php echo $team['Team']['description']; ?>&nbsp;</td>
		<td><?php echo $team['Team']['disabled']; ?>&nbsp;</td>
		<td><?php echo $team['Team']['created']; ?>&nbsp;</td>
		<td><?php echo $team['Team']['updated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($html->image('detail.png'), array('action' => 'view', $team['Team']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('action' => 'edit', $team['Team']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('action' => 'delete', $team['Team']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $team['Team']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
