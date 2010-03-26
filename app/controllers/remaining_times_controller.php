<?php
class RemainingTimesController extends AppController {

	var $name = 'RemainingTimes';

	function index() {
		$this->RemainingTime->recursive = 0;
		$this->set('remainingTimes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'remaining time'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('remainingTime', $this->RemainingTime->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->RemainingTime->create();
			if ($this->RemainingTime->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'remaining time'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'remaining time'));
			}
		}
		$tasks = $this->RemainingTime->Task->find('list');
		$this->set(compact('tasks'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'remaining time'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->RemainingTime->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'remaining time'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'remaining time'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RemainingTime->read(null, $id);
		}
		$tasks = $this->RemainingTime->Task->find('list');
		$this->set(compact('tasks'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'remaining time'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RemainingTime->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Remaining time'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Remaining time'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->RemainingTime->recursive = 0;
		$this->set('remainingTimes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'remaining time'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('remainingTime', $this->RemainingTime->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->RemainingTime->create();
			if ($this->RemainingTime->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'remaining time'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'remaining time'));
			}
		}
		$tasks = $this->RemainingTime->Task->find('list');
		$this->set(compact('tasks'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'remaining time'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->RemainingTime->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'remaining time'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'remaining time'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RemainingTime->read(null, $id);
		}
		$tasks = $this->RemainingTime->Task->find('list');
		$this->set(compact('tasks'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'remaining time'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RemainingTime->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Remaining time'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Remaining time'));
		$this->redirect(array('action' => 'index'));
	}
}
?>