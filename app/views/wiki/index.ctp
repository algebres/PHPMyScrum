<?php
App::import('Vendor', 'include_path');
App::import(
	'Vendor',
	'Text_Wiki_Mediawiki', 
	array('file' => 'Text' . DS . 'Wiki' . DS . 'Mediawiki.php')
);
$wiki_engine=new Text_Wiki_Mediawiki();
$wiki_engine->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
?>

<?php echo $this->Html->css('wiki'); ?>

<?php if ($canWrite):?>
<div id="snavi">
<ul>
	<?php if ((empty($content['Wiki']['readonly']) || $CurrentUser->id == $page['Wiki']['last_modified_user_id'])):?>
		<li><?php echo $html->link(sprintf(__('Edit %s',true), __('Page', true)), array('controller' => 'wiki', 'action' => 'edit', $path, $slug));?></li>
		<li><?php echo $html->link(sprintf(__('New %s',true),__('Page', true)), array('controller' => 'wiki', 'action' => 'add', $path, 'new-page'));?></li>
	<?php endif;?>
</ul>
</div>
<?php endif;?>

<div class="breadcrumbs">
	<?php //echo $chaw->breadcrumbs($path, $slug);?>
</div>

<div class="wiki">

<div id="wiki-left-box">
<?php if (!empty($page)): ?>
	<div class="wiki-content">
		<div class="wiki-text">
			<?php echo $wiki_engine->transform($page['Wiki']['body']);?>
		</div>
	</div>
<?php endif; ?>

<?php if (empty($page) && !empty($wiki)): ?>
	<div class="wiki-content">

		<?php foreach($wiki as $content):
			//TODO:cut off at 420bytes
			//$data = $text->truncate($wiki_engine->transform($content['Wiki']['body']), 420, '...', false, true);
			$data = $wiki_engine->transform($content['Wiki']['body']);
		?>
			<?php if (strpos($data, '##') === false):?>
				<h2 class="wiki-content-separator"><?php
					echo $html->link(Inflector::humanize($content['Wiki']['slug']), array(
						'controller' => 'wiki', 'action' => 'index',
						$content['Wiki']['path'], $content['Wiki']['slug']
					));?>
				</h2>
			<?php endif; ?>

			<div class="wiki-text">
				<?php echo $data; ?>
			</div>

			<div class="actions">
				<?php echo $html->link(__('View',true), array(
						'controller' => 'wiki', 'action' => 'index',
						$content['Wiki']['path'], $content['Wiki']['slug']));
				?>
				<?php if (!empty($canWrite) && (empty($content['Wiki']['read_only']) || $CurrentUser->id == $content['Wiki']['last_modified_user_id'])):?>
					|
					<?php echo $html->link(__('Edit',true), array(
							'controller' => 'wiki', 'action' => 'edit',
							$content['Wiki']['path'], $content['Wiki']['slug']));
					?>
					|
					<?php echo $html->link(sprintf(__('New %s',true), __('Page', true)), array(
							'controller' => 'wiki', 'action' => 'add',
							$content['Wiki']['path'], 'new-page'));
					?>
				<?php endif; ?>
			</div>
			<br clear="all" />
		<?php endforeach; ?>

	</div>
<?php endif; ?>

<?php if (empty($revisions) && !empty($page)):?>
<div class="wiki-footer">
	<p class="author">
		last revision by
		<strong><?php echo $page['User']['username']?></strong>
		on <?php echo date('Y-m-d', strtotime($page['Wiki']['created']));?>
	</p>
</div>
<?php endif;?>

<?php if (!empty($revisions) && !empty($page)):?>
<div class="wiki-footer revisions">
	<?php
		echo $form->create(array('url' => array('action' => 'index', $path, $slug)));
		echo $form->input('revision', array('value' => $page['Wiki']['id']));
		$buttons =
			$form->submit(__('view',true), array('div' => false, 'name' => 'view'))
			. "&nbsp;" . $form->submit(__('activate',true), array('div' => false, 'name' => 'activate'));
		if (!empty($canDelete)) {
			$buttons .= "&nbsp;" . $form->submit(__('delete',true), array('div' => false, 'name' => 'delete'));
		}
		echo $html->tag('div', $buttons, array('class' => 'submit'));
		echo $form->end();
	?>
</div>
<?php endif;?>

</div><!-- #left column -->


<div id="wiki-right-box">

	<?php if (!empty($subNav)):?>
		<?php
			$nav = null;
			foreach ($subNav as $subpage):
					$title = ltrim($subpage['Wiki']['path'] . '/' . $subpage['Wiki']['slug'], '/');
					$nav .= $html->tag('li',
						$html->link($title, array($subpage['Wiki']['path'], $subpage['Wiki']['slug']))
					);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h2 class="wiki-menu">Sub Nav</h2>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

	<?php if (!empty($wikiNav)):?>
		<?php
			$nav = null;
			foreach ($wikiNav as $category):
				$nav .= $html->tag('li',
					$html->link(ltrim($category, '/'), array($category))
				);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h2 class="wiki-menu">'.__('Wiki Nav',true).'</h2>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

	<?php if (!empty($recentEntries)):?>
		<?php
			$nav = null;
			foreach ($recentEntries as $recent):
					$title = ltrim($recent['Wiki']['path'] . '/' . $recent['Wiki']['slug'], '/');
					$nav .= $html->tag('li',
						$html->link($title, array($recent['Wiki']['path'], $recent['Wiki']['slug']))
					);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h2 class="wiki-menu">'.__('Recent Entries',true).'</h2>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

</div><!-- #right column -->

</div><!-- #wiki view -->
