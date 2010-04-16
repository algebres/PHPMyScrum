<div class="installer view">
<h2><?php  __('Install');?></h2>
<p>
<em><?php echo __('If you have already set up database, please delete app/tmp/not_installed.txt and reload screen.', true); ?></em>
</p>
<br clear="all" />
<p>
<em><?php echo __('Before start setup, you have to copy app/config/database.dist.php to app/config/database.php and edit it properly.', true); ?></em>
</p>
<br clear="all" />
<p><?php echo $this->Html->link(__('Start install', true), array('action' => 'database')); ?></p>
</ul>
</div>