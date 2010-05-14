<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('action' => 'add')); ?></li>
	</ul>
</div>

<script type="text/javascript">
<!--
jQuery(document).ready(function()
{
    jQuery('#priority_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>


<div class="priorities index">
	<h2><?php __('Priorities');?></h2>
	<table cellpadding="0" cellspacing="0" id="priority_table">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($priorities as $priority):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $priority['Priority']['id']; ?>&nbsp;</td>
		<td><?php echo h($priority['Priority']['name']); ?>&nbsp;</td>
		<td><?php echo $priority['Priority']['created']; ?>&nbsp;</td>
		<td><?php echo $priority['Priority']['updated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($html->image('detail.png'), array('action' => 'view', $priority['Priority']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('action' => 'edit', $priority['Priority']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('action' => 'delete', $priority['Priority']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $priority['Priority']['id'])); ?>
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
