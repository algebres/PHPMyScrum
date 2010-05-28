<?php

class ChangeLogsController extends AppController
{
	var $name = "ChangeLogs";

	var $paginate = array(
		'limit' => 20,
		'order' => array(
			'ChangeLog.id' => 'desc'
		),
	);

	function index()
	{
		$val = $this->paginate();
		$this->set('change_logs', $val);
	}
}

?>
