<table>
<tr>
<th colspan="3"><?php __("Task / RemainingHours"); ?></th>
<?php foreach($sprint_calendar as $cal) { ?>
<th><?php echo date('d', strtotime($cal)); ?></th>
<?php } ?>
</tr>

<?php foreach($sprint_remaining_hours as $a) { ?>
<tr>
<td><?php echo $a["id"]; ?></td>
<td><?php echo $a["Story"]["name"]; ?></td>
<td><?php echo $this->Html->link($a["name"], array('controller' => 'tasks', 'action' => 'view', $a['id'])); ?></td>
<?php foreach($sprint_calendar as $cal) { ?>
<td><?php echo $a["Hours"][$cal]; ?></td>
<?php } ?>
</tr>
<?php } ?>

<tr>
<td colspan="3"><?php __('Sum'); ?></td>
<?php foreach($sprint_calendar as $cal) { ?>
<?php
	$sum = 0;
	foreach($sprint_remaining_hours as $a) {
		$sum += $a["Hours"][$cal];
	}
	echo "<td>" . $sum . "</td>";
?>
<?php } ?>
</tr>
</table>

<div class="sprints view">
<h2><?php  __('Sprint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['startdate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Enddate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['enddate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint['Sprint']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sprint Term'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sprint_term; ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Sprint', true)), array('action' => 'edit', $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Sprint', true)), array('action' => 'delete', $sprint['Sprint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprints', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Tasks', true)), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Sprint'); __('Tasks'); ?></h3>
	<?php if (!empty($sprint['Task'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Story Id'); ?></th>
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
		foreach ($sprint['Task'] as $task):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $task['id'];?></td>
			<td><?php echo $this->Html->link($task['Story']['name'], array('controller' => 'stories', 'action' => 'view', $task['story_id']));?></td>
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

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
