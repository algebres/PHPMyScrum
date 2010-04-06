<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Session');
	var $helpers = array('Html', 'Form', 'Javascript', 'Session');
	var $uses = array('User', 'Sprint', 'Task', 'Project', 'Information');

	//ログイン処理
	function login(){
		if ($this->Auth->user())
		{
			if (!empty($this->data))
			{
				//ログインに成功した時の処理
				$this->log("ログイン処理-成功",LOG_DEBUG);

				$this->redirect(array('action'=> 'dashboard'));
			}
			else
			{
				$this->redirect(array('action' => 'dashboard'));
			}
		}
		else
		{
			if (!empty($this->data))
			{
				$this->log("ログイン処理-失敗",LOG_DEBUG);
				$this->Session->setFlash($this->Auth->loginError);
			}
			$this->set('information', $this->Information->getLatestInformation(true));
		}
	}

	function logout() {
		$this->Auth->logout();
		$this->Session->setFlash(__('You have finished to logout.', true));
		$this->redirect(array('action' => 'login'));
	}

	function dashboard() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$sprints = $this->Sprint->getCurrentSprint();
		$this->set('sprints', $sprints);
		$tasks = $this->Task->getUserTask($this->Auth->user('id'), false);
		$this->set('tasks', $tasks);
		$this->set('project', $this->Project->read(null, 1));
		$this->set('information', $this->Information->getLatestInformation());
		$this->set('show_link', true);
	}

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
			$this->redirect(array('action' => 'index'));
		}
		$this->User->recursive = 2;
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			// まだ管理者がいない場合は強制的に管理者フラグをたてる
			$has_admin = $this->User->hasAdminUser();
			if(!$has_admin)
			{
				$this->data["User"]["admin"] = true;
			}

			// 現在のユーザーをチェックし管理者かどうかチェック
			if($has_admin == false || $this->Auth->user('admin') == true)
			{
				$key = "admin_add";
			}
			else
			{
				$key = "add";
			}

			if ($this->User->save($this->data, array('fieldList' => $this->User->fields[$key]))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
				if($has_admin)
				{
					$this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->redirect(array('controller' => 'projects', 'action' => 'edit'));
				}
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
			$this->redirect(array('action' => 'index'));
		}

		if(!$this->Auth->user('admin'))
		{
			if($id != $this->Auth->user('id'))
			{
				$this->Session->setFlash(__('You have no privileges', true));
				$this->redirect(array('action' => 'index'));
			}
		}

		if (!empty( $this->data['User']['new_password'] ) )
		{
			$this->data['User']['password'] = AuthComponent::password ($this->data['User']['new_password']);
		}

		if (!empty($this->data)) {
			if($this->Auth->user('admin'))
			{
				$key = "admin_edit";
			}
			else
			{
				$key = "edit";
			}
			if ($this->User->save($this->data, array('fieldList' => $this->User->fields[$key]))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
			$this->redirect(array('action'=>'index'));
		}

		if(!$this->Auth->user('admin'))
		{
			if($id != $this->Auth->user('id'))
			{
				$this->Session->setFlash(__('You have no privileges', true));
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->User->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
		$this->redirect(array('action'=>'index'));
	}
}
?>