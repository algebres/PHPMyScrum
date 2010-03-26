<?php
/* Stories Test cases generated on: 2010-03-27 06:03:28 : 1269639808*/
App::import('Controller', 'Stories');

class TestStoriesController extends StoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.story', 'app.priority', 'app.task', 'app.sprint', 'app.user', 'app.teammember', 'app.team', 'app.remaining_time');

	function startTest() {
		$this->Stories =& new TestStoriesController();
		$this->Stories->constructClasses();
	}

	function endTest() {
		unset($this->Stories);
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