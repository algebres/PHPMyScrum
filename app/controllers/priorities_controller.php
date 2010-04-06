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
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Priority', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('priority', $this->Priority->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Priority->create();
			if ($this->Priority->save($this->data, array('fieldList' => $this->Priority->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Priority', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Priority', true)));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Priority', true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Priority->save($this->data, array('fieldList' => $this->Priority->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Priority', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Priority', true)));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Priority->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Priority', true)));
			$this->redirect(array('action'=>'index'));
		}
		// 関連するストーリーがあるかチェック
		if($this->Priority->hasActiveStories($id)) {
			$this->Session->setFlash(sprintf(__('%s has related records', true), __('Priority', true)));
			$this->redirect(array('action'=>'index'));
		}

		$this->Priority->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('Priority', true)));
		$this->redirect(array('action'=>'index'));
	}
}
?>