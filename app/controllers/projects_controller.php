<?php
class ProjectsController extends AppController {

	var $name = 'Projects';
	var $components = array('Session');
	var $helpers = array('Html', 'Form', 'Javascript', 'Session');

	function view() {
		$id = 1;
		$this->set('project', $this->Project->read(null, $id));
	}

	function edit() {
		$id = 1;
		if (!empty($this->data)) {
			if ($this->Project->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'project'));
				$this->redirect(array('action' => 'view'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'project'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}
	}
}
?>