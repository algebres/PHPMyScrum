<?php
/* Priorities Test cases generated on: 2010-03-27 06:03:10 : 1269639850*/
App::import('Controller', 'Priorities');

class TestPrioritiesController extends PrioritiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PrioritiesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.priority', 'app.story', 'app.task', 'app.sprint', 'app.user', 'app.teammember', 'app.team', 'app.remaining_time');

	function startTest() {
		$this->Priorities =& new TestPrioritiesController();
		$this->Priorities->constructClasses();
	}

	function endTest() {
		unset($this->Priorities);
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