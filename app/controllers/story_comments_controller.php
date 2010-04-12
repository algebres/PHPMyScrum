<?php
class StoryCommentsController extends AppController {

	var $name = 'StoryComments';
	var $components = array('Session');

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'story comment'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('storyComment', $this->StoryComment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->data["StoryComment"]["user_id"] = $this->Auth->user('id');
			$this->StoryComment->create();
			if ($this->StoryComment->save($this->data, array('fieldList' => $this->StoryComment->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'story comment'));
				//$this->redirect(array('action' => 'index'));
				$this->_redirect(array('controller' => 'stories', 'action' => 'view', $this->data["StoryComment"]["story_id"]));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'story comment'));
			}
		}
		$story_id = @$this->params['named']['story_id'];
		$this->set('story_id', $story_id);
		$stories = $this->StoryComment->Story->find('list');
		$users = $this->StoryComment->User->find('list');
		$this->set(compact('stories', 'users'));
	}
}
?>