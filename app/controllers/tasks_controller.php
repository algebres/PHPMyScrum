<?php
class TasksController extends AppController {

	var $name = 'Tasks';
	var $components = array('Session');
	var $uses = array('Task', 'User', 'Sprint', 'Story', 'Resolution');

	function index() {
		$this->Task->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Task.disabled' => 0,
			),
		);
		$this->set('tasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('task', $this->Task->read(null, $id));

		$format = $this->params['named']['format'];
		if($format === "ajax")
		{
			Configure::write('debug', 0);
			$this->layout = "ajax";
			$this->render('ajax_view');
		}
		else
		{
			$this->render();
		}
	}

	function add() {
		if (!empty($this->data)) {
			$this->Task->create();
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}
			if ($this->Task->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'task'));
				$id = $this->Task->getLastInsertID();
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'task'));
			}
		}
		$story_id = @$this->params['named']['story_id'];
		$sprints = $this->Sprint->getActiveSprintList();
		$stories = $this->Story->getActiveStoryList();
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('story_id', 'sprints', 'stories', 'users', 'resolutions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}

			if ($this->Task->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'task'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'task'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Task->read(null, $id);
		}
		$sprints = $this->Sprint->getActiveSprintList();
		$stories = $this->Story->getActiveStoryList();
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('sprints', 'stories', 'users', 'resolutions'));
	}

	function done($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'task'));
			$this->_redirect(array('action'=>'index'));
		}
		$data = $this->Task->read(null, $id);
		$data["Task"]["resolution_id"] = 1;
		$data["Task"]["estimate_hours"] = 0;
		if ($this->Task->save($data)) {
			$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'task'));
			$this->_redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'task'));
			$this->_redirect(array('action' => 'index'));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'task'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Task->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Task'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Task'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Task->recursive = 0;
		$this->set('tasks', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('task', $this->Task->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Task->create();
			if ($this->Task->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'task'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'task'));
			}
		}
		$sprints = $this->Task->Sprint->find('list');
		$stories = $this->Task->Story->find('list');
		$users = $this->Task->User->find('list');
		$this->set(compact('sprints', 'stories', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Task->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'task'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'task'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Task->read(null, $id);
		}
		$sprints = $this->Task->Sprint->find('list');
		$stories = $this->Task->Story->find('list');
		$users = $this->Task->User->find('list');
		$this->set(compact('sprints', 'stories', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'task'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Task->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Task'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Task'));
		$this->redirect(array('action' => 'index'));
	}
}
?>