<?php
/* Project Test cases generated on: 2010-04-04 15:04:50 : 1270362890*/
App::import('Model', 'Project');

class ProjectTestCase extends CakeTestCase {
	var $fixtures = array('app.project');

	function startTest() {
		$this->Project =& ClassRegistry::init('Project');
	}

	function endTest() {
		unset($this->Project);
		ClassRegistry::flush();
	}

}
?>