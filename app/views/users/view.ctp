<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('User', true)), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('User', true)), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add'));?> </li>
	</ul>
</div>

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#task_table').flexigrid({height:'auto',striped:true});
    jQuery('#teammember_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>



<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Loginname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($user['User']['loginname']); ?>
			&nbsp;
		</dd>
		<?php if(0) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Admin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['admin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Tasks', true));?></h3>
	<?php if (!empty($user['Task'])):?>
	<table cellpadding = "0" cellspacing = "0" id="task_table">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Sprint Id'); ?></th>
		<th><?php __('Story Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<?php if(0) { ?>
		<th><?php __('Description'); ?></th>
		<?php } ?>
		<th><?php __('Estimate Hours'); ?></th>
		<th><?php __('Resolution'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<?php if(0) { ?>
		<th><?php __('Updated'); ?></th>
		<?php } ?>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Task'] as $task):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $task['id'];?></td>
			<td><?php echo $this->Html->link($task['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $task['sprint_id'])); ?></td>
			<td><?php echo $this->Html->link($task['Story']['name'], array('controller' => 'stories', 'action' => 'view', $task['story_id'])); ?></td>
			<td><?php echo $this->Html->link($task['name'], array('controller' => 'tasks', 'action' => 'view', $task['id'])); ?></td>
			<?php if(0) { ?>
			<td><?php echo $task['description'];?></td>
			<?php } ?>
			<td><?php echo $task['estimate_hours'];?></td>
			<td><?php echo @$task["Resolution"]['name'];?></td>
			<td><?php echo h($task['User']['username']);?></td>
			<td><?php echo date('Y-m-d', strtotime($task['created']));?></td>
			<?php if(0) { ?>
			<td><?php echo date('Y-m-d', strtotime($task['updated']));?></td>
			<?php } ?>
			<td class="actions narrow">
				<?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $task['id'], '?' => array('return_url' => urlencode($_SERVER['REQUEST_URI']))), array('escape' => false), sprintf(__('Are you sure you want to chage # %s to be finished?', true), $task['id'])); ?>
				<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'tasks', 'action' => 'edit', $task['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'tasks', 'action' => 'delete', $task['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $task['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Teammembers', true));?></h3>
	<?php if (!empty($user['Teammember'])):?>
	<table cellpadding = "0" cellspacing = "0" id="teammember_table">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Team Id'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Teammember'] as $teammember):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $teammember['id'];?></td>
			<td><?php echo $this->Html->link($teammember['Team']['name'], array('controller' => 'teams', 'action' => 'view', $teammember['team_id'])); ?></td>
			<td><?php echo $teammember['disabled'];?></td>
			<td><?php echo $teammember['updated'];?></td>
			<td><?php echo $teammember['created'];?></td>
			<td class="actions narrow">
				<?php echo $this->Html->link($html->image('detail.png'), array('controller' => 'teammembers', 'action' => 'view', $teammember['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'teammembers', 'action' => 'edit', $teammember['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'teammembers', 'action' => 'delete', $teammember['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $teammember['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
