<?php
/* StoryComments Test cases generated on: 2010-04-12 09:04:52 : 1271031472*/
App::import('Controller', 'StoryComments');

class TestStoryCommentsController extends StoryCommentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StoryCommentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.story_comment', 'app.story', 'app.priority', 'app.team', 'app.teammember', 'app.user', 'app.task', 'app.sprint', 'app.resolution', 'app.remaining_time', 'app.project');

	function startTest() {
		$this->StoryComments =& new TestStoryCommentsController();
		$this->StoryComments->constructClasses();
	}

	function endTest() {
		unset($this->StoryComments);
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