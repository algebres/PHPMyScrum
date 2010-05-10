<?php
/* Sprints Test cases generated on: 2010-03-27 06:03:40 : 1269639820*/
App::import('Controller', 'Sprints');

class TestSprintsController extends SprintsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SprintsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.sprint', 'app.task', 'app.story', 'app.priority', 'app.user', 'app.teammember', 'app.team', 'app.remaining_time');

	function startTest() {
		$this->Sprints =& new TestSprintsController();
		$this->Sprints->constructClasses();
	}

	function endTest() {
		unset($this->Sprints);
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