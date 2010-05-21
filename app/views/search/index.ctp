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

	<?php foreach($result as $item): ?>
	<tr>
	<td><?php echo(h($item[0]["name"])); ?></td>
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
