<?php
/* RemainingTime Test cases generated on: 2010-03-27 06:03:56 : 1269638936*/
App::import('Model', 'RemainingTime');

class RemainingTimeTestCase extends CakeTestCase {
	var $fixtures = array('app.remaining_time', 'app.task');

	function startTest() {
		$this->RemainingTime =& ClassRegistry::init('RemainingTime');
	}

	function endTest() {
		unset($this->RemainingTime);
		ClassRegistry::flush();
	}

}
?>