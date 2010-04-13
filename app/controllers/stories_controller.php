<?php
class StoriesController extends AppController {

	var $name = 'Stories';
	var $components = array('Session');
	var $uses = array('Story', 'Sprint', 'Priority', 'Team', 'Resolution', 'Task');

	function index() {
		$this->Story->recursive = 1;
		$this->paginate = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
			'limit' => Configure::read('Config.paginate_count'),
		);
		$this->set('stories', $this->Story->populate_data($this->paginate()));
	}

	function output() {
		$conditions = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
		);
		$data = $this->Story->find('all', $conditions);

		$type = @$this->params["named"]["type"];
		if($type === "csv")
		{
			$this->Story->saveToCSV($this->Story->populate_data($data), 'backlog.csv');
		}
		else
		{
			$this->Story->saveToExcel($this->Story->populate_data($data), 'backlog.xls');
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Story', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Story->recursive = 2;
		$this->set('story', $this->Story->read(null, $id));
	}

	function simple_view($id = null) {
		$this->layout = "ajax";
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Story', true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->Story->recursive = 2;
		$this->set('story', $this->Story->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Story->create();
			if ($this->Story->save($this->data, array('fieldList' => $this->Story->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Story', true)));
				$id = $this->Story->getLastInsertID();
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Story', true)));
			}
		}
		$priorities = $this->Priority->getActivePriorityList();
		$this->set(compact('priorities'));
		$teams = $this->Team->getActiveTeamList();
		$this->set(compact('teams'));
		$sprints = $this->Sprint->getActiveSprintList();
		$this->set(compact('sprints'));
		$resolutions = $this->Resolution->find('list');
		$this->set('resolutions', $resolutions);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), __('Story', true)));
			$this->redirect(array('action' => 'index'));
		}

		$priorities = $this->Priority->getActivePriorityList();
		$this->set(compact('priorities'));
		$teams = $this->Team->getActiveTeamList();
		$this->set(compact('teams'));
		$sprints = $this->Sprint->getActiveSprintList();
		$this->set(compact('sprints'));
		$resolutions = $this->Resolution->find('list');
		$this->set('resolutions', $resolutions);

		if (!empty($this->data)) {
			if($this->data["Story"]["resolution_id"] == RESOLUTION_DONE)
			{
				$total_remaining_hours = $this->Task->getRemainingHours($id);
				if($total_remaining_hours > 0)
				{
					$this->Session->setFlash(sprintf(__('The story has unfinished task(s).', true), __('Story', true)));
					//$this->_redirect(array('action' => 'index'));
					return;
				}
			}

			if ($this->Story->save($this->data, array('fieldList' => $this->Story->fields['save']))) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Story', true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Story', true)));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Story->read(null, $id);
		}
	}

	function done($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Story', true)));
			$this->_redirect(array('action'=>'index'));
		}
		$total_remaining_hours = $this->Task->getRemainingHours($id);
		if($total_remaining_hours > 0)
		{
			$this->Session->setFlash(sprintf(__('The story has unfinished task(s).', true), __('Story', true)));
			$this->_redirect(array('action' => 'index'));
		}

		$data = $this->Story->read(null, $id);
		$data["Story"]["resolution_id"] = RESOLUTION_DONE;
		if ($this->Story->save($data)) {
			$this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Story', true)));
			$this->_redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Story', true)));
			$this->_redirect(array('action' => 'index'));
		}
	}

	function delete($id = null) {

		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Story', true)));
			$this->_redirect(array('action'=>'index'));
		}

		// 関連するタスクがあるかチェック
		if($this->Story->hasActiveTasks($id)) {
			$this->Session->setFlash(sprintf(__('%s has related records', true), __('Priority', true)));
			$this->_redirect(array('action'=>'index'));
		}

		$this->Story->delete($id);
		$this->Session->setFlash(sprintf(__('%s deleted', true), __('Story', true)));
		$this->_redirect(array('action'=>'index'));
	}

	function upload()
	{
		// upload
		if (!empty($this->data))
		{
			$filename = @$this->data['Story']['upfile']['tmp_name'];
			if(empty($filename) || !file_exists($filename))
			{
				$this->Session->setFlash(__('File is not uploaded.', true));
				return;
			}
			// csv取り出し
			$contents = file_get_contents($filename);
			$buf = mb_convert_encoding($contents, "utf-8", "sjis");
			$fp = tmpfile();
			fwrite($fp, $buf);
			rewind($fp); 

			while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
				$num = count($data);
				$row++;
				for ($c=0; $c < $num; $c++) {
					echo $data[$c] . ",\n";
				}
				echo "<br />";
			}
			fclose($handle);
			exit;
		}
		else
		{
			// get
		}
	}
}
?>