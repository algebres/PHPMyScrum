<script type="text/javascript">
<!--
jQuery(document).ready(function()
{
    jQuery('#search_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>

<div class="search_result index">
<?php echo $this->Form->create('Search',  array('url' => array('controller' => 'search', 'action' => 'search'))) ;?>
	<fieldset>
 		<legend><?php echo __('Search', true); ?></legend>
	<?php
		echo $this->Form->input('query');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>


<?php if(isset($result)) { ?>
	<table cellpadding="0" cellspacing="0" id="search_table">
	<tr>
	<th><?php echo __('Type', true); ?></th>
	<th><?php echo __('id', true); ?></th>
	<th width="30%"><?php echo __('Name', true); ?></th>
	<th width="50%"><?php echo __('Description', true); ?></th>
	</tr>
	<?php $i=0; $class=""; ?>
	<?php foreach($result as $item):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	<td>
	<?php
	if($item[0]["itemtype"] == ITEMTYPE_TASK)
	{
		echo __('Task', true);
		$link_controller = "tasks";
	}
	else
	{
		echo __('Story', true);
		$link_controller = "stories";
	} 
	?>
	</td>
	<td><?php echo $html->link($item[0]["id"], array('controller' => $link_controller, 'action' => 'view', $item[0]["id"])); ?></td>
	<td><?php echo $html->link($item[0]["name"], array('controller' => $link_controller, 'action' => 'view', $item[0]["id"])); ?></td>
	<td><?php echo(h($item[0]["description"])); ?></td>
	</tr>
	<?php endforeach; ?>
	</table>

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

<?php } ?>


</div>
