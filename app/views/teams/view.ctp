<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Team', true)), array('action' => 'edit', $team['Team']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Team', true)), array('action' => 'delete', $team['Team']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $team['Team']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teams', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Team', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
	</ul>
</div>


<div class="teams view">
<h2><?php  __('Team');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $team['Team']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<script type="text/javascript">
<!--
jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#teammember_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>


<div class="related">
	<h3><?php printf(__('Related %s', true), __('Teammembers', true));?></h3>
	<?php if (!empty($team['Teammember'])):?>
	<table cellpadding = "0" cellspacing = "0" id="teammember_table">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<?php if(0) { ?>
		<th><?php __('Updated'); ?></th>
		<?php } ?>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($team['Teammember'] as $teammember):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $teammember['id'];?></td>
			<td><?php echo $this->Html->link($teammember['User']['username'], array('controller' => 'users', 'action' => 'view', $teammember['user_id']));?></td>
			<td><?php echo $teammember['disabled'];?></td>
			<?php if(0) { ?>
			<td><?php echo date('Y-m-d', strtotime($teammember['updated']));?></td>
			<?php } ?>
			<td><?php echo date('Y-m-d', strtotime($teammember['created']));?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'teammembers', 'action' => 'view', $teammember['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'teammembers', 'action' => 'edit', $teammember['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'teammembers', 'action' => 'delete', $teammember['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $teammember['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
