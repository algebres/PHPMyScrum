<?php
/* Information Test cases generated on: 2010-04-04 15:04:18 : 1270363038*/
App::import('Model', 'Information');

class InformationTestCase extends CakeTestCase {
	var $fixtures = array('app.information');

	function startTest() {
		$this->Information =& ClassRegistry::init('Information');
	}

	function endTest() {
		unset($this->Information);
		ClassRegistry::flush();
	}

}
?>