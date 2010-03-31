<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priorities', true)), array('controller' => 'priorities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="stories index">
	<h2><?php __('Stories');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="narrow"><?php echo $this->Paginator->sort('storypoints');?></th>
			<th class="narrow"><?php echo $this->Paginator->sort('businessvalue');?></th>
			<th><?php echo $this->Paginator->sort('sprint_id');?></th>
			<th><?php echo $this->Paginator->sort('priority_id');?></th>
			<th><?php echo $this->Paginator->sort('team_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<?php if(0) { ?>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<?php } ?>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($stories as $story):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->link($story['Story']['id'], array('action' => 'view', $story['Story']['id'])); ?></td>
		<td><?php echo $this->Html->link($story['Story']['name'], array('action' => 'view', $story['Story']['id'])); ?></td>
		<td><?php echo $story['Story']['storypoints']; ?>&nbsp;</td>
		<td><?php echo $story['Story']['businessvalue']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($story['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $story['Sprint']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['Priority']['name'], array('controller' => 'priorities', 'action' => 'view', $story['Priority']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['Team']['name'], array('controller' => 'teams', 'action' => 'view', $story['Team']['id'])); ?>
		</td>
		<td><?php echo date('Y-m-d', strtotime($story['Story']['created'])); ?>&nbsp;</td>
		<?php if(0) { ?>
		<td><?php echo date('Y-m-d', strtotime($story['Story']['updated'])); ?>&nbsp;</td>
		<?php } ?>
		<td class="actions">
			<?php echo $this->Html->link($html->image('edit.png'), array('action' => 'edit', $story['Story']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('action' => 'delete', $story['Story']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $story['Story']['id'])); ?>
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
