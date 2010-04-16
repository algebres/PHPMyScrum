<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Information', true)), array('action' => 'add')); ?></li>
	</ul>
</div>

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#information_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>



<div class="information index">
	<h2><?php __('Information');?></h2>
	<table cellpadding="0" cellspacing="0" id="information_table">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
<?php if($login_user["admin"]) { ?>
			<th><?php echo $this->Paginator->sort('show_anonymous');?></th>
<?php } ?>
			<th><?php echo $this->Paginator->sort('startdate');?></th>
			<th><?php echo $this->Paginator->sort('enddate');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($information as $information):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $information['Information']['id']; ?>&nbsp;</td>
		<td><?php echo $html->link($information['Information']['name'], array('action' => 'view', $information['Information']['id']), array('escape' => false));?>&nbsp;</td>
		<td><?php echo nl2br($information['Information']['description']); ?>&nbsp;</td>
<?php if($login_user["admin"]) { ?>
		<td><?php echo $information['Information']['show_anonymous']; ?>&nbsp;</td>
<?php } ?>

		<td><?php echo date('Y-m-d', strtotime($information['Information']['startdate'])); ?>&nbsp;</td>
		<td><?php echo date('Y-m-d', strtotime($information['Information']['enddate'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($html->image('detail.png'), array('action' => 'view', $information['Information']['id']), array('escape' => false)); ?>
<?php if($login_user["admin"]) { ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('action' => 'edit', $information['Information']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('action' => 'delete', $information['Information']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $information['Information']['id'])); ?>
<?php } ?>
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
