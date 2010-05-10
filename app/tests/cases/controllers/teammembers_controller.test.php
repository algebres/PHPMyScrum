<?php
/* Teammembers Test cases generated on: 2010-03-27 06:03:45 : 1269639765*/
App::import('Controller', 'Teammembers');

class TestTeammembersController extends TeammembersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TeammembersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.teammember', 'app.team', 'app.user', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.remaining_time');

	function startTest() {
		$this->Teammembers =& new TestTeammembersController();
		$this->Teammembers->constructClasses();
	}

	function endTest() {
		unset($this->Teammembers);
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