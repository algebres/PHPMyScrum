<?php
class PrioritiesController extends AppController {

	var $name = 'Priorities';
	var $components = array('Session');

	function index() {
		$this->Priority->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Priority.disabled' => 0,
			),
		);
		$this->set('priorities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'priority'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('priority', $this->Priority->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Priority->create();
			if ($this->Priority->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'priority'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'priority'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'priority'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Priority->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'priority'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'priority'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Priority->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'priority'));
			$this->redirect(array('action'=>'index'));
		}
		// 関連するストーリーがあるかチェック
		if($this->Priority->hasActiveStories($id)) {
			$this->Session->setFlash(sprintf(__('%s has related records', true), 'priority'));
			$this->redirect(array('action'=>'index'));
		}

		if ($this->Priority->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Priority'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Priority'));
		$this->redirect(array('action' => 'index'));
	}
}
?>