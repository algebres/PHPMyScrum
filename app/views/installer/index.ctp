<div class="installer view">
<h2><?php  __('Install');?></h2>
<p>
<?php echo __('If you have already set up database, please delete app/tmp/not_installed.txt and reload screen.', true); ?>
</p>
<p>
<?php echo $this->Html->link(__('Start install'), array('action' => 'database')); ?>
</p>
</div>