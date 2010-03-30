<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Story', true)), array('action' => 'edit', $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Story', true)), array('action' => 'delete', $story['Story']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add', 'story_id:' . $story['Story']['id']));?> </li>
	</ul>
</div>



<div class="stories view">
<h2><?php  __('Story');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Businessvalue'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['businessvalue']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sprint'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($story['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $story['Sprint']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Priority'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($story['Priority']['name'], array('controller' => 'priorities', 'action' => 'view', $story['Priority']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Team'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($story['Team']['name'], array('controller' => 'teams', 'action' => 'view', $story['Team']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Tasks', true));?></h3>
	<?php if (!empty($story['Task'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Sprint'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Estimate Hours'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($story['Task'] as $task):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $task['id'];?></td>
			<td><?php echo $this->Html->link($task['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $task['sprint_id']));?></td>
			<td><?php echo $task['name'];?></td>
			<td><?php echo $task['description'];?></td>
			<td><?php echo $task['estimate_hours'];?></td>
			<td><?php echo $this->Html->link($task['User']['username'], array('controller' => 'users', 'action' => 'view', $task['user_id']));?></td>
			<td><?php echo $task['disabled'];?></td>
			<td><?php echo $task['created'];?></td>
			<td><?php echo $task['updated'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tasks', 'action' => 'view', $task['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tasks', 'action' => 'edit', $task['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'tasks', 'action' => 'delete', $task['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $task['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
