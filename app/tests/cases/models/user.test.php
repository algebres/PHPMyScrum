<?php
/* User Test cases generated on: 2010-03-27 06:03:18 : 1269639558*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.remaining_time', 'app.teammember', 'app.team');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
?>