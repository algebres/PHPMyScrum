<?php
class SprintsController extends AppController {

	var $name = 'Sprints';

	function index() {
		$this->Sprint->recursive = 0;
		$this->set('sprints', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'sprint'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sprint', $this->Sprint->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Sprint->create();
			if ($this->Sprint->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'sprint'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'sprint'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'sprint'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sprint->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'sprint'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'sprint'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sprint->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'sprint'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sprint->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Sprint'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Sprint'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Sprint->recursive = 0;
		$this->set('sprints', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'sprint'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sprint', $this->Sprint->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Sprint->create();
			if ($this->Sprint->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'sprint'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'sprint'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'sprint'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sprint->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'sprint'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'sprint'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sprint->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'sprint'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sprint->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Sprint'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Sprint'));
		$this->redirect(array('action' => 'index'));
	}
}
?>