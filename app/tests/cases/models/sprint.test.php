<?php
/* Sprint Test cases generated on: 2010-03-27 06:03:30 : 1269639030*/
App::import('Model', 'Sprint');

class SprintTestCase extends CakeTestCase {
	var $fixtures = array('app.sprint', 'app.task');

	function startTest() {
		$this->Sprint =& ClassRegistry::init('Sprint');
	}

	function endTest() {
		unset($this->Sprint);
		ClassRegistry::flush();
	}

}
?>