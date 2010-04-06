<?php
class TeamsController extends AppController {

	var $name = 'Teams';
	var $components = array('Session');

	function index() {
		$this->Team->recursive = 0;
		$this->set('teams', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'team'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Team->recursive = 2;
		$this->set('team', $this->Team->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Team->create();
			if ($this->Team->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'team'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'team'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'team'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Team->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'team'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'team'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Team->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'team'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Team->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), 'Team'));
		$this->redirect(array('action'=>'index'));
	}
}
?>