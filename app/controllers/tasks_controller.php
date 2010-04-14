<?php
class TasksController extends AppController {

	var $name = 'Tasks';
	var $components = array('Session');
	var $uses = array('Task', 'User', 'Sprint', 'Story', 'Resolution');


	function index() {
		$this->Task->recursive = 0;
		$param = @$this->params["named"]["filter"];
		$this->paginate = $this->Task->getSelectConditon($param, $this->Auth->user('id'));
		$this->paginate['limit'] = Configure::read('Config.paginate_count');
		$this->set('tasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'task'));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('task', $this->Task->read(null, $id));

		$format = @$this->params['named']['format'];
		if($format === "ajax")
		{
			Configure::write('debug', 0);
			$this->layout = "ajax";
			$this->render('ajax_view');
		}
		else
		{
			$this->render();
		}
	}

	function simple_view($id = null)
	{
		$this->layout = "ajax";
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Task', true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}

			if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['simple_save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
				$this->redirect(array('action' => 'simple_view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Task->read(null, $id);
		}
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('users', 'resolutions'));
	}

	// Excelo—Í
	function output()
	{
		$param = @$this->params["named"]["filter"];
		$type = @$this->params["named"]["type"];
		$conditions = $this->Task->getSelectConditon($param, $this->Auth->user('id'));
		$data = $this->Task->find('all', $conditions);
		if($type === "csv")
		{
			$this->Task->saveToCSV($data, 'task.csv');
		}
		else
		{
			$this->Task->saveToExcel($data, 'task.xls');
		}
	}

	// ó‹µ‚ð•ÏX
	function change_resolution()
	{
		$this->layout = "ajax";
		$id = @$this->params["named"]["task_id"];
		$resolution_id = @$this->params["named"]["resolution_id"];
		if($id == "" || $resolution_id == "")
		{
			$this->cakeError("error404");
			return;
		}
		$this->Task->recursive = -1;
		$this->data = $this->Task->read(null, $id);
		$this->data["Task"]["resolution_id"] = $resolution_id;
		if($this->Resolution->is_fixed($resolution_id))
		{
			$this->data["Task"]["estimate_hours"] = 0;
		}
		if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['save']))) {
			$this->log(__('Task status was changed.', true), LOG_DEBUG);
			$message = sprintf(__('The %s has been saved', true), __('Task', true));
			//$this->Session->setFlash($message);
			//$this->redirect(array('action' => 'index'));
			$this->set("message", $message);
		} else {
			$message = sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true));
			//$this->Session->setFlash($message);
			$this->set("message", $message);
		}
	}

	function add() {
		if (!empty($this->data)) {
			$this->Task->create();
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}
			if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
				$id = $this->Task->getLastInsertID();
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			}
		}
		$story_id = @$this->params['named']['story_id'];
		$sprint_id = @$this->params['named']['sprint_id'];

		$sprints = $this->Sprint->getActiveSprintList();
		$stories = $this->Story->getActiveStoryList();
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('story_id', 'sprint_id', 'sprints', 'stories', 'users', 'resolutions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Task', true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$resolution_id = $this->data["Task"]["resolution_id"];
			if($this->Resolution->is_fixed($resolution_id))
			{
				$this->data["Task"]["estimate_hours"] = 0;
			}

			if ($this->Task->save($this->data, array('fieldList' => $this->Task->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Task->read(null, $id);
		}
		$sprints = $this->Sprint->getActiveSprintList();
		$stories = $this->Story->getActiveStoryList();
		$users = $this->User->getActiveUserList();
		$resolutions = $this->Resolution->find('list');
		$this->set(compact('sprints', 'stories', 'users', 'resolutions'));
	}

	function done($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Task', true)));
			$this->_redirect(array('action'=>'index'));
		}
		$data = $this->Task->read(null, $id);
		$data["Task"]["resolution_id"] = RESOLUTION_DONE;
		$data["Task"]["estimate_hours"] = 0;
		if ($this->Task->save($data)) {
			$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Task', true)));
			$this->_redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Task', true)));
			$this->_redirect(array('action' => 'index'));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Task', true)));
			$this->redirect(array('action'=>'index'));
		}
		$this->Task->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('Task', true)));
		$this->redirect(array('action'=>'index'));
	}

	function upload()
	{
		ini_set("max_execution_time", 0);

		// upload
		if (!empty($this->data))
		{
			$filename = @$this->data['Task']['upfile']['tmp_name'];
			if(empty($filename) || !file_exists($filename))
			{
				$this->Session->setFlash(__('File is not uploaded.', true));
				return;
			}
			// set properly encoding
			$contents = file_get_contents($filename);
			if(function_exists("mb_convert_encoding"))
			{
				$buf = mb_convert_encoding($contents, "utf-8", "utf-8, sjis, euc-jp");
			}
			else
			{
				$buf = $contents;
			}
			$fp = tmpfile(sys_get_temp_dir(), 'pms');
			if(!$fp)
			{
				$this->log();
				$this->Session->setFlash(__('Can not create temporary file.', true));
				return;
			}
			fwrite($fp, $buf);
			rewind($fp); 

			// get available data
			$sprints = $this->Sprint->getActiveSprintList();
			$resolutions = $this->Resolution->getActiveResolutionList();
			$users = $this->User->getActiveUserList();
			$stories = $this->Story->getActiveStoryList();

			$row = 0;
			$success = true;
			$success_count = 0;
			while (($data = fgetcsv($fp, 10000, ","))) 
			{
				if($row == 0)
				{
					if($data != $this->Task->getCSVHeader())
					{
						fclose($handle);
						$this->Session->setFlash(__('There is no header record or does not match column count.', true));
						return;
					}
					$row++;
					continue;
				}
				$row++;

				if(count($data) != count($this->Task->getCSVHeader()))
				{
					continue;
				}

				$col = 0;
				$this->data["Task"]["id"] = trim($data[$col]); $col++;
				$this->data["Task"]["sprint_id"] = $this->Sprint->getSprintId($sprints,trim($data[$col])); $col++;
				$this->data["Task"]["story_id"] = intval($data[$col]); $col++;
				$null1 = $data[$col]; $col++;	// story name
				$this->data["Task"]["name"]	= trim($data[$col]); $col++;
				$this->data["Task"]["description"]	= trim($data[$col]); $col++;
				$this->data["Task"]["estimate_hours"] = intval($data[$col]); $col++;
				$this->data["Task"]["user_id"] = $this->User->getUserId($users,trim($data[$col])); $col++;
				$this->data["Task"]["resolution_id"] = $this->Resolution->getResolutionId($resolutions,trim($data[$col])); $col++;

				// story exist?
				if(!$this->Story->isValidStoryId($stories, $this->data["Task"]["story_id"]))
				{
					continue;
				}

				// task exist ?
				$this->Task->recursive = -1;
				$rec = $this->Task->read(null, intval($this->data["Task"]["id"]));

				if(!$rec)
				{
					unset($this->data["Task"]["id"]);
					$this->Task->create();
				}
				if (!$this->Task->save($this->data, array('fieldList' => $this->Task->fields['save'])))
				{
					// can't save
					$success = false;
				}
				else
				{
					$success_count++;
				}
			}
			fclose($handle);
			if($success)
			{
				$this->Session->setFlash(sprintf(__('%d records has been imported!', true), $success_count));
			}
			else
			{
				$this->Session->setFlash(sprintf(__('%d records has been imported. but some records failed to insert or update.', true), $success_count));
			}
			$this->redirect(array('action' => 'index'));
		}
		else
		{
			// get
		}
	}

}
?>