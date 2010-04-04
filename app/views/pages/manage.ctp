<div class="pages view">

<h2><?php  __('Manage');?></h2>

	<ul>
		<li><?php __('Project'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Project', true)), array('controller' => 'projects', 'action' => 'edit')); ?></li>
			</ul>
		</li>
		<li><?php __('User'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('User', true)), array('controller' => 'users', 'action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?></li>
			</ul>
		</li>
		<li><?php __('Sprint'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sprint', true)), array('controller' => 'sprints', 'action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('controller' => 'sprints', 'action' => 'add')); ?></li>
			</ul>
		</li>
		<li><?php __('Priority'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Priority', true)), array('controller' => 'priorities', 'action' => 'add')); ?></li>
			</ul>
		</li>
		<li><?php __('Team'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teams', true)), array('controller' => 'teams', 'action' => 'index'));?></li>
				<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teams', true)), array('controller' => 'teams', 'action' => 'add'));?></li>
			</ul>
		</li>
		<li><?php __('Teammember'); ?>
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Teammembers', true)), array('controller' => 'teammembers', 'action' => 'index')); ?> </li>
				<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Teammember', true)), array('controller' => 'teammembers', 'action' => 'add')); ?> </li>
			</ul>
		</li>
	</ul>

	</ul>
</div>
