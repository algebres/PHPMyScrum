<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Session', 'PmsCommon');
	var $uses = array('User', 'Sprint', 'Task', 'Project', 'Information', 'Story');

	/**
	 * Task model
	 * @var Task
	 */
	var $Task;
	/**
	 * Information model
	 * @var Information
	 */
	var $Information;
	/**
	 * Story model
	 * @var Story
	 */
	var $Story;

	/**
	 * Session
	 * @var SessionComponent
	 */
	var $Session;

	//ログイン処理
	function login()
	{
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

	function logout()
	{
		$this->Auth->logout();
		$this->Session->setFlash(__('You have finished to logout.', true));
		$this->redirect(array('action' => 'login'));
	}

	function dashboard()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$sprints = $this->Sprint->getCurrentSprint();
		$this->set('sprints', $sprints);
		$tasks = $this->Task->getUserTask($this->Auth->user('id'), false);
		$this->set('tasks', $tasks);
		$this->set('project', $this->Project->read(null, 1));
		$this->set('information', $this->Information->getLatestInformation());
		$this->set('show_link', true);

		$all_sprints = $this->Sprint->getAllSprints();
		$this->Sprint->makeSprintZero($all_sprints);
		$stories = $this->Story->getActiveStory();
		$all_sprints = $this->PmsCommon->getEachStoryPoints($all_sprints, $stories);
		$this->set("all_sprints", $all_sprints);
	}

	function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('User', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->User->recursive = 2;
		$this->set('user', $this->User->read(null, $id));
	}

	function add()
	{
		if (!empty($this->data))
		{
			// password
			$this->User->addValidationRuleChangePassword();
			$this->data['User']['password'] = AuthComponent::password ($this->data['User']['new_password']);
			$this->User->set($this->data);
			if (!$this->User->validates($this->data))
			{
				return;
			}

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

			if ($this->User->save($this->data, array('fieldList' => $this->User->fields[$key])))
			{
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('User', true)));
				if($has_admin)
				{
					$this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->redirect(array('controller' => 'projects', 'action' => 'edit'));
				}
			}
			else
			{
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('User', true)));
			}
		}
	}

	function edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('User', true)));
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

		// 編集の場合はパスワードが空の場合は何も変えない
		if (!empty( $this->data['User']['new_password']))
		{
			$this->User->addValidationRuleChangePassword(); // add validation rule
			$this->data['User']['password'] = AuthComponent::password ($this->data['User']['new_password']);
			$this->User->set($this->data);
			if (!$this->User->validates($this->data))
			{
				return;
			}
		}

		if (!empty($this->data))
		{
			if($this->Auth->user('admin'))
			{
				$key = "admin_edit";
			}
			else
			{
				$key = "edit";
			}
			if ($this->User->save($this->data, array('fieldList' => $this->User->fields[$key])))
			{
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('User', true)));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('User', true)));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('User', true)));
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
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('User', true)));
		$this->redirect(array('action'=>'index'));
	}

	// パスワード再発行
	function reset_password()
	{
		if (empty($this->data))
		{
			$this->render("reset_password");
			return;
		}

		$loginname = $this->data['User']['loginname'];
		$email = $this->data['User']['email'];

		$this->User->create();
		$this->User->changeValidationRuleForReset();	//isUniqueチェック等を削除
		$this->User->set($this->data);
		if ($this->User->validates() == false)
		{
			$this->render("reset_password");
			return;
		}

		$record = $this->User->findByLoginnameAndEmail($loginname, $email);
		if(!$record)
		{
			$this->render('reset_password_mail');
			return;
		}

		$new_password = $this->User->make_password();
		$record['User']['password'] = AuthComponent::password($new_password);
		$this->User->set($record);

		if($this->User->save())
		{
			$mailinfo = array(
				'loginname'	=> $record['User']['loginname'],
				'username'	=> $record['User']['username'],
				'email'		=> $record['User']['email'],
				'password'	=> $new_password,
			);
			$mailsetting['mail_subject'] = Configure::read('Config.mail_subject_reset_password');
			$mailsetting['mail_to'] = $record['User']['email'];
			$mailsetting['mail_template'] = 'reset_password';

			if ($this->sendmail($mailsetting, $mailinfo) )
			{
				$this->redirect(array('action'=>'reset_password_mail'));
				return;
			}
			else
			{
				$this->cakeError("sys_error", array('message' => __("We can not send an email to you. Please contact system administrator", true)));
				return;
			}
		}
		else
		{
			$this->cakeError("sys_error", array('message' => __("We can not make your new password. Please contact system administrator", true)));
			return;
		}
	}

	// パスワード再発行完了画面
	function reset_password_mail()
	{
		$this->render('reset_password_mail');
	}

}
?>