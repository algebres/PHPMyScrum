<div style="background:#ffffff; color:#000000;">

<h2><?php  __('Story');?>&nbsp;#<?php echo $story['Story']['id']; ?>&nbsp;<?php echo $story['Story']['name']; ?></h2>
<div>
<?php echo nl2br(h($story['Story']['description'])); ?>
</div>

<div>
<?php echo __('Businessvalue', true); ?> : <?php echo $story['Story']['businessvalue']; ?>
</div>

<div>
<?php echo __('Story Points', true); ?> : <?php echo $story['Story']['storypoints']; ?>
</div>

<?php echo $this->Html->link(sprintf(__('Confirm %s', true), __('Story', true)), array('action' => 'view', $story['Story']['id']), array('escape' => false)); ?>
<br />
<?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Story', true)), array('action' => 'edit', $story['Story']['id']), array('escape' => false)); ?>
<br />
<?php echo $this->Html->link(sprintf(__('Add %s', true), __('Task', true)), array('controller' => 'tasks', 'action' => 'add', 'story_id:' . $story['Story']['id'], 'sprint_id:' . $story['Story']['sprint_id'])); ?>


</div>