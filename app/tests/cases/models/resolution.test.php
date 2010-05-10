<?php
/* Resolution Test cases generated on: 2010-03-31 13:03:35 : 1270010495*/
App::import('Model', 'Resolution');

class ResolutionTestCase extends CakeTestCase {
	var $fixtures = array('app.resolution', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.team', 'app.teammember', 'app.user', 'app.remaining_time');

	function startTest() {
		$this->Resolution =& ClassRegistry::init('Resolution');
	}

	function endTest() {
		unset($this->Resolution);
		ClassRegistry::flush();
	}

}
?>