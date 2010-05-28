<div class="change_logs index">
<h2><?php __('ChangeLog'); ?></h2>

<dl>
<?php
foreach($change_logs as $change_log):
?>
<dt><?php echo date('Y/m/d h:i', strtotime($change_log["ChangeLog"]["created"])); ?></dt>
<dd><?php echo $change_log["ChangeLog"]["mode"]; ?>&nbsp;&nbsp;<?php echo $change_log["ChangeLog"]["name"]; ?>
<?php $d = unserialize($change_log["ChangeLog"]["new_value"]); ?> 
<?php $modelname = $change_log["ChangeLog"]["name"]; $d = $d[$modelname]; ?>
<?php foreach(array_keys($d) as $k): ?>
<?php echo $k; ?>&nbsp;<?php echo $d[$k]; ?><br /> 
<?php endforeach; ?>
</dd>
<?php endforeach; ?>
</dl>

</div>
