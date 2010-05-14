<script type="text/javascript">
<!--
jQuery(document).ready(function()
{
    jQuery('#stories_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>

<div class="stories index">
	<h2><?php __('Search Story');?></h2>

	<?php echo $form->create('Story',array('action'=>'search'));?>
	<fieldset>
	<?php
			echo $form->input('Search.keywords', array('label' => __('Keywords', true)));
			echo $form->input('Search.id', array('label' => __('ID', true)));
			echo $form->input('Search.name',array('after'=> "<br />" .__('wildcard is *',true)));
			echo $form->input('Search.description',array('after'=> "<br />" . __('wildcard is *',true)));
			//echo $form->input('Search.created', array('after'=>'eg: >= 2 weeks ago'));
			echo $form->input('Search.team_id', array('options' => $teams, 'empty' => ' ', 'label' => __('Team', true)));
			echo $form->input('Search.priority_id', array('options' => $priorities, 'empty' => ' ', 'label' => __('Priority', true)));
			echo $form->input('Search.resolution_id', array('options' => $resolutions, 'empty' => ' ', 'label' => __('Resolution', true)));
			echo $form->input('Search.sprint_id', array('options' => $sprints, 'empty' => ' ', 'label' => __('Sprint', true)));
			echo $form->submit('Search');
	?>
	</fieldset>
	<?php echo $form->end();?>

	<table cellpadding="0" cellspacing="0" id="stories_table">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="narrow"><?php echo $this->Paginator->sort(__('Story Points'), 'storypoints');?></th>
			<th><?php echo sprintf(__('Count of %s', true), __('Tasks', true)); ?></th>
			<th><?php echo sprintf(__('Sum of %s', true), __('Remaining Hours', true)); ?></th>
			<th class="narrow"><?php echo $this->Paginator->sort('businessvalue');?></th>
			<th><?php echo $this->Paginator->sort('sprint_id');?></th>
			<th><?php echo $this->Paginator->sort('priority_id');?></th>
			<th><?php echo $this->Paginator->sort('resolution_id');?></th>
			<th><?php echo $this->Paginator->sort('team_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<?php if(0) { ?>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<?php } ?>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	foreach ($stories as $story):
		$class = null;
		if(@$story["Story"]["resolution_id"] == RESOLUTION_DONE)
		{
			$class = ' class="done"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Html->link($story['Story']['id'], array('action' => 'view', $story['Story']['id'])); ?></td>
		<td><?php echo $this->Html->link($story['Story']['name'], array('action' => 'view', $story['Story']['id'])); ?></td>
		<td><?php echo $story['Story']['storypoints']; ?>&nbsp;</td>
		<td><?php echo $story['Story']["task_count"]; ?></td>
		<td><?php echo $story['Story']["total_hours"]; ?></td>
		<td><?php echo $story['Story']['businessvalue']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($story['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $story['Sprint']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['Priority']['name'], array('controller' => 'priorities', 'action' => 'view', $story['Priority']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['Resolution']['name'], array('controller' => 'resolutions', 'action' => 'view', $story['Resolution']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['Team']['name'], array('controller' => 'teams', 'action' => 'view', $story['Team']['id'])); ?>
		</td>
		<td><?php echo date('Y-m-d', strtotime($story['Story']['created'])); ?>&nbsp;</td>
		<?php if(0) { ?>
		<td><?php echo date('Y-m-d', strtotime($story['Story']['updated'])); ?>&nbsp;</td>
		<?php } ?>
		<td class="actions narrow">
			<?php echo $this->Html->link($html->image('check.png'), array('controller' => 'stories', 'action' => 'done', $story['Story']['id'], '?' => array('return_url' => urlencode($_SERVER['REQUEST_URI']))), array('escape' => false), sprintf(__('Are you sure you want to chage # %s to be finished?', true), $story['Story']['id'])); ?>
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
