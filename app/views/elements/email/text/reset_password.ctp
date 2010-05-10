<?php
$username = $content["loginname"];
$password = $content["password"];
?>
To: <?php echo $username;?>

Your new password is below.
========================================================================
<?php echo ($password . "\n"); ?>
========================================================================

