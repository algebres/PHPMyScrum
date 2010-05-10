<?php
/* RemainingTimes Test cases generated on: 2010-03-27 06:03:53 : 1269639833*/
App::import('Controller', 'RemainingTimes');

class TestRemainingTimesController extends RemainingTimesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RemainingTimesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.remaining_time', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.user', 'app.teammember', 'app.team');

	function startTest() {
		$this->RemainingTimes =& new TestRemainingTimesController();
		$this->RemainingTimes->constructClasses();
	}

	function endTest() {
		unset($this->RemainingTimes);
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