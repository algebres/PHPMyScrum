<?php
/* Information Test cases generated on: 2010-04-05 04:04:25 : 1270408525*/
App::import('Controller', 'Information');

class TestInformationController extends InformationController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class InformationControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.information', 'app.user', 'app.task', 'app.sprint', 'app.story', 'app.priority', 'app.team', 'app.teammember', 'app.resolution', 'app.remaining_time', 'app.project');

	function startTest() {
		$this->Information =& new TestInformationController();
		$this->Information->constructClasses();
	}

	function endTest() {
		unset($this->Information);
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

}
?>