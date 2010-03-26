<div class="teammembers index">
	<h2><?php __('Teammembers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('team_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('disabled');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($teammembers as $teammember):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $teammember['Teammember']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($teammember['Team']['name'], array('controller' => 'teams', 'action' => 'view', $teammember['Team']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($teammember['User']['username'], array('controller' => 'users', 'action' => 'view', $teammember['User']['id'])); ?>
		</td>
		<td><?php echo $teammember['Teammember']['disabled']; ?>&nbsp;</td>
		<td><?php echo $teammember['Teammember']['updated']; ?>&nbsp;</td>
		<td><?php echo $teammember['Teammember']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $teammember['Teammember']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $teammember['Teammember']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $teammember['Teammember']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $teammember['Teammember']['id'])); ?>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teams', true)), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Team', true)), array('controller' => 'teams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>