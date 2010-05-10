<?php
/* Task Test cases generated on: 2010-03-27 06:03:24 : 1269639324*/
App::import('Model', 'Task');

class TaskTestCase extends CakeTestCase {
	var $fixtures = array('app.task', 'app.sprint', 'app.story', 'app.priority', 'app.user', 'app.remaining_time');

	function startTest() {
		$this->Task =& ClassRegistry::init('Task');
	}

	function endTest() {
		unset($this->Task);
		ClassRegistry::flush();
	}

}
?>