<?php

class ChangeLogsController extends AppController
{
	var $name = "ChangeLogs";

	function index()
	{
		$val = $this->paginate();
		$this->set('change_logs', $val);
	}
}

?>
