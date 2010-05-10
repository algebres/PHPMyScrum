<?php
/* Teammember Test cases generated on: 2010-03-27 06:03:32 : 1269639392*/
App::import('Model', 'Teammember');

class TeammemberTestCase extends CakeTestCase {
	var $fixtures = array('app.teammember', 'app.team', 'app.user');

	function startTest() {
		$this->Teammember =& ClassRegistry::init('Teammember');
	}

	function endTest() {
		unset($this->Teammember);
		ClassRegistry::flush();
	}

}
?>