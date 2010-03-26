<?php
class TeammembersController extends AppController {

	var $name = 'Teammembers';

	function index() {
		$this->Teammember->recursive = 0;
		$this->set('teammembers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'teammember'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('teammember', $this->Teammember->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Teammember->create();
			if ($this->Teammember->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'teammember'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'teammember'));
			}
		}
		$teams = $this->Teammember->Team->find('list');
		$users = $this->Teammember->User->find('list');
		$this->set(compact('teams', 'users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'teammember'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Teammember->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'teammember'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'teammember'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Teammember->read(null, $id);
		}
		$teams = $this->Teammember->Team->find('list');
		$users = $this->Teammember->User->find('list');
		$this->set(compact('teams', 'users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'teammember'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Teammember->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Teammember'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Teammember'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Teammember->recursive = 0;
		$this->set('teammembers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'teammember'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('teammember', $this->Teammember->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Teammember->create();
			if ($this->Teammember->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'teammember'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'teammember'));
			}
		}
		$teams = $this->Teammember->Team->find('list');
		$users = $this->Teammember->User->find('list');
		$this->set(compact('teams', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'teammember'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Teammember->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'teammember'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'teammember'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Teammember->read(null, $id);
		}
		$teams = $this->Teammember->Team->find('list');
		$users = $this->Teammember->User->find('list');
		$this->set(compact('teams', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'teammember'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Teammember->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Teammember'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Teammember'));
		$this->redirect(array('action' => 'index'));
	}
}
?>