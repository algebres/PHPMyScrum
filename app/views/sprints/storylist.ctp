<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Sprint', true)), array('action' => 'edit', $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Sprint', true)), array('action' => 'delete', $sprint['Sprint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="sprints view">
<h2><?php  __('Sprint');?>&nbsp;#<?php echo $sprint['Sprint']['id']; ?>&nbsp;<?php echo $sprint['Sprint']['name']; ?></h2>
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

<div class="related">
	<h3><?php __('Sprint'); __('Stories'); ?></h3>
	<?php if (!empty($sprint['Story'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('StoryPoints'); ?></th>
		<th><?php printf(__('Count of %s', true), __('Tasks', true)); ?></th>
		<th><?php printf(__('Sum of %s', true), __('Remaining Hours', true)); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($sprint['Story'] as $story):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $story['id'];?></td>
			<td><?php echo $story['name'];?></td>
			<td><?php echo $story['storypoints'];?></td>
			<td><?php echo count($story["Task"]); ?></td>
			<td>
			<?php
				$sum = 0; 
				foreach($story["Task"] as $task) {
					$sum += $task["estimate_hours"];
				}
			?>
			<?php echo $sum; ?>
			</td>
			<td><?php echo $story['created'];?></td>
			<td><?php echo $story['updated'];?></td>
			<td class="actions">
				<?php echo $this->Html->link($html->image('detail.png'), array('controller' => 'stories', 'action' => 'view', $story['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'stories', 'action' => 'edit', $story['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'stories', 'action' => 'delete', $story['id'], '?' => array('return_url' => urlencode($html->url('/sprints/storylist/' .$sprint['Sprint']['id'])))), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $story['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
