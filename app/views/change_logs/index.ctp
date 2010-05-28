<div class="change_logs index">
<h2><?php __('ChangeLog'); ?></h2>

<dl>
<?php
foreach($change_logs as $change_log):
?>
<dt style="margin-top: 8px;"><h3><?php echo date('Y/m/d h:i', strtotime($change_log["ChangeLog"]["created"])); ?></h3></dt>
<dd>
<?php echo $change_log["ChangeLog"]["mode"]; ?>&nbsp;&nbsp;<?php echo $change_log["ChangeLog"]["name"]; ?><br />
<?php 
	$new_value = unserialize($change_log["ChangeLog"]["new_value"]);
	$old_value = unserialize($change_log["ChangeLog"]["old_value"]);
	$modelname = $change_log["ChangeLog"]["name"];
	$new_value = @$new_value[$modelname];
	$old_value = @$old_value[$modelname];
	$key_array = array_keys($new_value);
?>
<?php if(count($key_array) > 0): ?><ul><?php endif; ?>
<?php foreach($key_array as $k): ?>
<li style="margin-left:20px;">
<?php echo __(Inflector::humanize($k), true); ?>&nbsp;<?php echo @$old_value[$k]; ?> -&gt;&gt; <?php echo $new_value[$k]; ?>
</li>
<?php endforeach; ?>
<?php if(count($key_array) > 0): ?></ul><?php endif; ?>
</dd>
<?php endforeach; ?>
</dl>

	<br clear="all" />
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
