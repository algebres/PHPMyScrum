<?php
/* StoryComment Test cases generated on: 2010-04-12 09:04:42 : 1271031402*/
App::import('Model', 'StoryComment');

class StoryCommentTestCase extends CakeTestCase {
	var $fixtures = array('app.story_comment', 'app.story', 'app.priority', 'app.team', 'app.teammember', 'app.user', 'app.task', 'app.sprint', 'app.resolution', 'app.remaining_time');

	function startTest() {
		$this->StoryComment =& ClassRegistry::init('StoryComment');
	}

	function endTest() {
		unset($this->StoryComment);
		ClassRegistry::flush();
	}

}
?>