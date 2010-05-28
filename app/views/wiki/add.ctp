<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(__('Wiki', true), array('controller' => 'wiki', 'action' => 'index'));?></li>
	</ul>
</div>

<div class="wiki form">

	<div class="breadcrumbs">
		<?php //echo $chaw->breadcrumbs($path);?>
	</div>

	<?php echo $form->create(array('url' => '/' . $this->params['url']['url']));?>

		<fieldset>
		<legend><?php printf(__('Edit %s', true), __('Page', true)); ?></legend>
		<?php
			echo $this->Form->input('path', 
				array(
					'after' => "<br />" . sprintf(
						__("use a path to group pages into categories and subcategories. example: /logs/by/%s/", true), $login_user['username']),
					'label' => __('Path', true),
				)
			);

			if ($this->Form->value('slug')) {
				echo $this->Form->hidden('slug');
				echo $this->Form->input('slug', array());
			} else {
				echo $this->Form->input('title', array('value' => 'new-page', 'label' => __('Title', true)));
			}
			echo $form->input('body', array(
					'after' => $html->tag('div', $this->element('markup'), array('class' => 'help')),
					'label' => __('Body', true),
			));

			echo $this->Form->input('disabled');
			echo $this->Form->input('readonly', array('label' => __('readonly', true)));
		?>
		</fieldset>
	<?php echo $form->end(__('Submit',true));?>
</div>