<?php
$this->set('showdown', true);
$html->css('highlight/idea', null, array('inline' => false));
$html->script('highlight.pack', array('inline' => false));

$script = '
hljs.initHighlightingOnLoad();

$(document).ready(function(){
	var text = jQuery.trim($("#WikiContent").val());
	$("#Preview").html(converter.makeHtml(text));
	$("#WikiContent").bind("keyup", function() {
		$("#Preview").html(converter.makeHtml($(this).val()));
		hljs.initHighlighting.called = false;
		hljs.initHighlighting();
	});
});
';
$html->scriptBlock($script, array('inline' => false));
?>
<div class="wiki form">

	<div class="breadcrumbs">
		<?php //echo $chaw->breadcrumbs($path);?>
	</div>

	<?php echo $form->create(array('url' => '/' . $this->params['url']['url']));?>

		<fieldset>
		<?php

			echo $html->tag('div',$form->input('disabled') . $form->input('readonly'), array('class' => 'single'));

			echo $form->input('path', array('div' => 'input text path',
				'label' => "<small>" . sprintf(
					__("use a path to group pages into categories and subcategories. example: /logs/by/%s/", true),
					$login_user['username']
				) . "</small>",
			));

			if ($form->value('slug')) {
				echo $form->hidden('slug');
				echo $form->input('slug', array('label' => false));
			} else {
				echo $form->input('title', array('label' => false, 'value' => 'new-page'));
			}
		?>
		</fieldset>
		<fieldset class="content">
			<?php
				echo '<div id="Preview" class="wiki-text"></div>';

				echo $form->input('body', array(
					'label' => false, 'after' => $html->tag('div', $this->element('markdown_help'), array('class' => 'help'))
				));
			?>
		</fieldset>

	<?php echo $form->end(__('Submit',true));?>

</div>