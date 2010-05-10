<div>
<style type="text/css">
form #TaskSimpleViewForm {
	margin:0px;
	padding:0px;
	font-size : 100% !important;
}
form #TaskSimpleViewForm div {
	margin-bottom: 0px !important;
}

label, input, textarea {
	font-size : 100% !important;
	margin-bottom: 0px !important;
}

</style>
<?php echo $this->Form->create('Task');?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('description');
		echo $this->Form->input('estimate_hours');
		echo $this->Form->input('user_id', array('options' => $users, 'empty' => ' '));
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
