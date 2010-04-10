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

</div>