<?php
/* Teams Test cases generated on: 2010-03-27 06:03:29 : 1269639749*/
App::import('Controller', 'Teams');

class TestTeamsController extends TeamsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TeamsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.team', 'app.teammember', 'app.user', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.remaining_time');

	function startTest() {
		$this->Teams =& new TestTeamsController();
		$this->Teams->constructClasses();
	}

	function endTest() {
		unset($this->Teams);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>