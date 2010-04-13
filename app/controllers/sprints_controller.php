<?php
class SprintsController extends AppController {

	var $name = 'Sprints';
	var $components = array('Session');
	var $uses = array('Sprint', 'Story', 'Resolution');

	function index() {
		$this->Sprint->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Sprint.disabled' => 0,
			),
		);
		$this->set('sprints', $this->paginate());
	}

	function view($id = null) {
		if (!$id) 
		{
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Sprint', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Sprint->recursive = 1;	// story–¼“™
		$sprint = $this->Sprint->read(null, $id);
		$this->set('sprint', $sprint);
		$this->set('total_story_point', $this->Sprint->getTotalStoryPoint($sprint));
		$this->set('total_finished_story_point', $this->Sprint->getTotalFinishedStoryPoint($sprint));
		$this->set('sprint_term', $this->Sprint->getSprintTerm($sprint["Sprint"]["id"]));
		$this->set('sprint_calendar', $this->Sprint->getSprintCalendar($sprint["Sprint"]["id"]));

		$sprint_remaining_hours = $this->Sprint->getSprintRemainingHours($id);
		$this->set('sprint_remaining_hours', $sprint_remaining_hours);
	}

	function taskboard($id = null)
	{
		if (!$id) 
		{
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Sprint', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Sprint->recursive = 2;	// story–¼“™
		$sprint = $this->Sprint->read(null, $id);
		$this->set('sprint', $sprint);
		$this->Resolution->recursive = -1;
		$this->set('resolutions', $this->Resolution->find('all'));
	}

	function output($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Sprint', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Sprint->saveToExcel($id, 'sprint.xls');
	}

	function storylist($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Sprint', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Sprint->recursive = 2;	// story–¼“™
		$sprint = $this->Sprint->read(null, $id);
		$this->set('sprint', $sprint);
		$this->set('sprint_term', $this->Sprint->getSprintTerm($sprint["Sprint"]["id"]));
		$this->set('total_story_point', $this->Sprint->getTotalStoryPoint($sprint));
	}


	function add() {
		if (!empty($this->data)) {
			$this->Sprint->create();
			if ($this->Sprint->save($this->data, array('fieldList' => $this->Sprint->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Sprint', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'sprint'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Sprint', true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sprint->save($this->data, array('fieldList' => $this->Sprint->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Sprint', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Sprint', true)));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sprint->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Sprint', true)));
			$this->_redirect(array('action'=>'index'));
		}
		// ŠÖ˜A‚·‚é‚à‚Ì‚ª‚ ‚é‚©Šm”F
		if($this->Sprint->hasActiveStoriesAndTask($id))
		{
			$this->Session->setFlash(sprintf(__('%s has related records', true), __('Sprint', true)));
			$this->_redirect(array('action'=>'index'));
		}

		$this->Sprint->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('Sprint', true)));
		$this->_redirect(array('action'=>'index'));
	}
}
?>