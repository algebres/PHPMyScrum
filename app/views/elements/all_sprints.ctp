<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#all_sprints_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>

<div class="sprints index">
	<h2><?php echo sprintf(__("All %s", true), __('Sprints', true));?></h2>
	<table cellpadding="0" cellspacing="0" id="all_sprints_table">
	<tr>
	<th><?php __('Sprint'); ?></th>
	<th><?php __('Total Finished Story Point'); ?></th>
	<th><?php __('Total Story Point'); ?></th>
	</tr>
	<?php foreach($all_sprints as $s): ?>
	<tr>
	<td><?php echo $s["Sprint"]["name"]; ?></td>
	<td><?php echo $s["Sprint"]["finished_point_per_sprint"]; ?></td>
	<td><?php echo $s["Sprint"]["point_per_sprint"]; ?></td>
	</tr>
	<?php endforeach; ?>
	</table>
</div>
