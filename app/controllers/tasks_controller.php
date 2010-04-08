<?php
class TasksController extends AppController {

	var $name = 'Tasks';
	var $components = array('Session');
	var $uses = array('Task', 'User', 'Sprint', 'Story', 'Resolution');


	function index() {
		$this->Task->recursive = 0;
		$param = @$this->params["named"]["filter"];
		$this->paginate = $this->Task->getSelectConditon($param, $this->Auth->user('id'));
		$this->set('tasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('task', $this->Task->read(null, $id));

		$format = @$this->params['named']['format'];
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

	// Excelo—Í
	function output()
	{
		$param = @$this->params["named"]["filter"];
		$conditions = $this->Task->getSelectConditon($param, $this->Auth->user('id'));
		$data = $this->Task->find('all', $conditions);
		$this->Task->saveToExcel($data, 'task.xls');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Task->create();
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}
			if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
				$id = $this->Task->getLastInsertID();
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			}
		}
		$story_id = @$this->params['named']['story_id'];
		$sprint_id = @$this->params['named']['sprint_id'];

		$sprints = $this->Sprint->getActiveSprintList();
		$stories = $this->Story->getActiveStoryList();
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('story_id', 'sprint_id', 'sprints', 'stories', 'users', 'resolutions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Task', true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}

			if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
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
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Task', true)));
			$this->_redirect(array('action'=>'index'));
		}
		$data = $this->Task->read(null, $id);
		$data["Task"]["resolution_id"] = RESOLUTION_DONE;
		$data["Task"]["estimate_hours"] = 0;
		if ($this->Task->save($data)) {
			$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
			$this->_redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			$this->_redirect(array('action' => 'index'));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Task', true)));
			$this->redirect(array('action'=>'index'));
		}
		$this->Task->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('Task', true)));
		$this->redirect(array('action'=>'index'));
	}
}
?>