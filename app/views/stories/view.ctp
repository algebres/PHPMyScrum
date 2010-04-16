<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Story', true)), array('action' => 'edit', $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Story', true)), array('action' => 'delete', $story['Story']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add', 'story_id:' . $story['Story']['id'], 'sprint_id:' . $story['Story']['sprint_id']));?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Story Comment', true)), array('controller' => 'story_comments', 'action' => 'add', 'story_id:' . $story['Story']['id']));?> </li>
	</ul>
</div>

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#related_tasks_table').flexigrid({height:'auto',striped:true});
    jQuery('#task_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>



<div class="stories view">
<h2><?php  __('Story');?>&nbsp;#<?php echo $story['Story']['id']; ?>&nbsp;<?php echo $story['Story']['name']; ?></h2>
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
			<?php echo nl2br(h($story['Story']['description'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Businessvalue'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['businessvalue']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('StoryPoints'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['storypoints']; ?>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resolution'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($story['Resolution']['name'], array('controller' => 'resolutions', 'action' => 'view', $story['Resolution']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Team'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($story['Team']['name'], array('controller' => 'teams', 'action' => 'view', $story['Team']['id'])); ?>
			&nbsp;
		</dd>
		<?php if(0) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $story['Story']['disabled']; ?>
			&nbsp;
		</dd>
		<?php } ?>
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
	<h3><?php printf(__('Related %s', true), __('StoryComment', true));?></h3>
	<?php if (!empty($story['StoryComment'])):?>
	<table cellpadding = "0" cellspacing = "0" id="related_tasks_table">
	<tr>
		<th><?php __('Comment'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Created'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($story['StoryComment'] as $comment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo nl2br($comment['comment']);?></td>
			<td><?php echo $this->Html->link(@$comment['User']['username'], array('controller' => 'users', 'action' => 'view', @$comment['user_id']));?></td>
			<td><?php echo date('Y-m-d', strtotime($comment['created']));?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>


<div class="related">
	<h3><?php printf(__('Related %s', true), __('Tasks', true));?></h3>
	<?php if (!empty($story['Task'])):?>
	<table cellpadding = "0" cellspacing = "0" id="task_table">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Sprint'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Estimate Hours'); ?></th>
		<th><?php __('Resolution'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Created'); ?></th>
		<?php if(0) { ?>
		<th><?php __('Updated'); ?></th>
		<?php } ?>
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
			<td><?php echo $this->Html->link($task['name'], array('controller' => 'tasks', 'action' => 'view', $task['id'])); ?></td>
			<td><?php echo $task['estimate_hours'];?></td>
			<td><?php echo @$task['Resolution']["name"];?></td>
			<td><?php echo $this->Html->link(@$task['User']['username'], array('controller' => 'users', 'action' => 'view', @$task['user_id']));?></td>
			<td><?php echo date('Y-m-d', strtotime($task['created']));?></td>
			<?php if(0) { ?>
			<td><?php echo $task['updated'];?></td>
			<?php } ?>
			<td class="actions">
				<?php echo $this->Html->link($html->image('check.png'), array('controller' => 'tasks', 'action' => 'done', $task['id'], '?' => array('return_url' => $html->url('/stories/view/' .$story['Story']['id']) )), array('escape' => false), sprintf(__('Are you sure you want to chage # %s to be finished?', true), $task['id'])); ?>

				<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'tasks', 'action' => 'edit', $task['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'tasks', 'action' => 'delete', $task['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $task['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
