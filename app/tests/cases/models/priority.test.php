<?php
/* Priority Test cases generated on: 2010-03-27 06:03:55 : 1269639595*/
App::import('Model', 'Priority');

class PriorityTestCase extends CakeTestCase {
	var $fixtures = array('app.priority', 'app.story', 'app.task', 'app.sprint', 'app.user', 'app.teammember', 'app.team', 'app.remaining_time');

	function startTest() {
		$this->Priority =& ClassRegistry::init('Priority');
	}

	function endTest() {
		unset($this->Priority);
		ClassRegistry::flush();
	}

}
?>