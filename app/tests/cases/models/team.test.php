<?php
/* Team Test cases generated on: 2010-03-27 06:03:19 : 1269639439*/
App::import('Model', 'Team');

class TeamTestCase extends CakeTestCase {
	var $fixtures = array('app.team', 'app.teammember', 'app.user');

	function startTest() {
		$this->Team =& ClassRegistry::init('Team');
	}

	function endTest() {
		unset($this->Team);
		ClassRegistry::flush();
	}

}
?>