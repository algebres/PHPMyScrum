<?php
class StoriesController extends AppController {

	var $name = 'Stories';
	var $components = array('Session');
	var $uses = array('Story', 'Sprint', 'Priority', 'Team');

	function index() {
		$this->Story->recursive = 1;
		$this->paginate = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
		);
		$this->set('stories', $this->Story->populate_data($this->paginate()));
	}

	function output() {
		$conditions = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
		);
		$data = $this->Story->find('all', $conditions);
		$this->Story->saveToExcel($this->Story->populate_data($data), 'backlog.xls');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'story'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Story->recursive = 2;
		$this->set('story', $this->Story->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Story->create();
			if ($this->Story->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'story'));
				$id = $this->Story->getLastInsertID();
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'story'));
			}
		}
		$priorities = $this->Priority->getActivePriorityList();
		$this->set(compact('priorities'));
		$teams = $this->Team->getActiveTeamList();
		$this->set(compact('teams'));
		$sprints = $this->Sprint->getActiveSprintList();
		$this->set(compact('sprints'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'story'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Story->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'story'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'story'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Story->read(null, $id);
		}
		$priorities = $this->Priority->getActivePriorityList();
		$this->set(compact('priorities'));
		$teams = $this->Team->getActiveTeamList();
		$this->set(compact('teams'));
		$sprints = $this->Sprint->getActiveSprintList();
		$this->set(compact('sprints'));
	}

	function delete($id = null) {

		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'story'));
			$this->_redirect(array('action'=>'index'));
		}

		// 関連するタスクがあるかチェック
		if($this->Story->hasActiveTasks($id)) {
			$this->Session->setFlash(sprintf(__('%s has related records', true), 'priority'));
			$this->_redirect(array('action'=>'index'));
		}

		if ($this->Story->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Story'));
			$this->_redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Story'));
		$this->_redirect(array('action' => 'index'));
	}
}
?>