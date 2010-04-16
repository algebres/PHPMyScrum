<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#sprint_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>


<div class="sprints index">
	<h2><?php echo sprintf(__("Current %s", true), __('Sprints', true));?></h2>
	<table cellpadding="0" cellspacing="0" id="sprint_table">
	<tr>
			<th><?php __('id');?></th>
			<th><?php __('name');?></th>
			<th><?php __('description');?></th>
			<th><?php __('Total Story Point');?></th>
			<th><?php __('startdate');?></th>
			<th><?php __('enddate');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
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
		<td><?php echo $this->Html->link($sprint['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $sprint['Sprint']['id'])); ?>&nbsp;</td>
		<td><?php echo nl2br(h($sprint['Sprint']['description'])); ?>&nbsp;</td>
		<?php
		$total_story_point = 0;
		foreach($sprint["Story"] as $story)
		{
			$total_story_point += $story["storypoints"];
		}
		?>
		<td><?php echo $total_story_point; ?></td>
		<td><?php echo $sprint['Sprint']['startdate']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['enddate']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($html->image('detail.png'), array('controller' => 'sprints', 'action' => 'view', $sprint['Sprint']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('controller' => 'sprints', 'action' => 'edit', $sprint['Sprint']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('controller' => 'sprints', 'action' => 'delete', $sprint['Sprint']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?>

		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
