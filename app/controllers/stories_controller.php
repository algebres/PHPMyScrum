<?php
class StoriesController extends AppController
{

	var $name = 'Stories';
	var $components = array('Session');
	var $uses = array('Story', 'Sprint', 'Priority', 'Team', 'Resolution', 'Task');

	function index()
	{
		$this->Story->recursive = 1;
		$this->paginate = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
			'limit' => Configure::read('Config.paginate_count'),
		);
		$this->set('stories', $this->Story->populate_data($this->paginate()));
	}

	function board()
	{
		// get stories
		$this->Story->recursive = 1;
		$this->set('stories', $this->Story->getActiveStory());

		// get all sprints
		$sprints = $this->Sprint->getAllSprints();
		// make no assined record
//		$data["Sprint"]["id"] = 0;
//		$data["Sprint"]["name"] = __('Not Assigned', true);
//		array_unshift($sprints, $data);
		$this->Story->makeSprintZero($sprints);
		$this->set('sprints', $sprints);
	}

	function change_sprint()
	{
		$this->layout = "ajax";
		$id = @$this->params["named"]["story_id"];
		$sprint_id = @$this->params["named"]["sprint_id"];
		if($id == "" || $sprint_id == "")
		{
			$this->cakeError("error404");
			return;
		}
		$this->Story->recursive = -1;
		$this->data = $this->Story->read(null, $id);
		$this->data["Story"]["sprint_id"] = $sprint_id;
		if ($this->Story->save($this->data, array('fieldList' => $this->Story->fields['save']))) {
			$this->log(__('Story status was changed.', true), LOG_DEBUG);
			$message = sprintf(__('The %s has been saved', true), __('Story', true));
			$this->set("message", $message);
		} else {
			$message = sprintf(__('The %s could not be saved. Please, try again.', true), __('Story', true));
			$this->set("message", $message);
		}
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
		ini_set("max_execution_time", 0);

		// upload
		if (!empty($this->data))
		{
			$filename = @$this->data['Story']['upfile']['tmp_name'];
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

			$tmpfname = tempnam(TMP, 'pms');
			$fp = fopen($tmpfname, "a+");
			if(!$fp)
			{
				$this->log($tmpfname, LOG_INFO);
				$this->Session->setFlash(__('Can not create temporary file.', true));
				return;
			}
			fwrite($fp, $buf);
			if(!rewind($fp))
			{
				$this->Session->setFlash(__('Can not rewind temporary file.', true));
				fclose($fp);
				unlink($tmpfname);
				return;
			}

			$sprints = $this->Sprint->getActiveSprintList();
			$resolutions = $this->Resolution->getActiveResolutionList();
			$teams = $this->Team->getActiveTeamList();
			$priorities = $this->Priority->getActivePriorityList();

			$row = 0;
			$success = true;
			$success_count = 0;

			setlocale(LC_ALL,'ja_JP.UTF-8');
			while (($data = fgetcsv($fp, 10000, ",")))
			{
				if($row == 0)
				{
					if($data != $this->Story->getCSVHeader())
					{
						fclose($fp);
						unlink($tmpfname);
						$this->Session->setFlash(__('There is no header record or does not match column count.', true));
						return;
					}
					$row++;
					continue;
				}
				$row++;

				if(count($data) != count($this->Story->getCSVHeader()))
				{
					continue;
				}

				$col = 0;
				$this->data["Story"]["id"] = trim($data[$col]); $col++;
				$this->data["Story"]["name"] = trim($data[$col]); $col++;
				$this->data["Story"]["description"]	= trim($data[$col]); $col++;
				$this->data["Story"]["storypoints"] = intval($data[$col]); $col++;
				$null1 = $data[$col]; $col++;
				$null2 = $data[$col]; $col++;
				$this->data["Story"]["businessvalue"] = intval($data[$col]); $col++;
				$sprint = $data[$col]; $col++;
				$priority = $data[$col]; $col++;
				$resolution = $data[$col]; $col++;
				$team = $data[$col]; $col++;
				$null3 = $data[$col]; $col++;

				// convert
				$this->data["Story"]["sprint_id"] = $this->Sprint->getSprintId($sprints, $sprint);
				$this->data["Story"]["resolution_id"] = $this->Resolution->getResolutionId($resolutions, $resolution);
				$this->data["Story"]["team_id"] = $this->Team->getTeamId($teams, $team);
				$this->data["Story"]["priority_id"] = $this->Priority->getPriorityId($priorities, $priority);

				// story exist ?
				$this->Story->recursive = -1;
				$rec = $this->Story->read(null, intval($this->data["Story"]["id"]));

				if(!$rec)
				{
					unset($this->data["Story"]["id"]);
					$this->Story->create();
				}
				if (!$this->Story->save($this->data, array('fieldList' => $this->Story->fields['save'])))
				{
					// can't save
					$success = false;
				}
				else
				{
					$success_count++;
				}
			}
			fclose($fp);
			unlink($tmpfname);
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

	function search() {
		// the page we will redirect to
		$url['action'] = 'search_index';
	   
		// build a URL will all the search elements in it
		// the resulting URL will be
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){
				foreach ($v as $kk=>$vv){
						$url[$k.'.'.$kk]=$vv;
				}
		}

		// redirect the user to the url
		$this->redirect($url, null, true);
	}

	function search_index() {
		$priorities = $this->Priority->getActivePriorityList();
		$this->set(compact('priorities'));
		$teams = $this->Team->getActiveTeamList();
		$this->set(compact('teams'));
		$sprints = $this->Sprint->getActiveSprintList();
		$this->set(compact('sprints'));
		$resolutions = $this->Resolution->find('list');
		$this->set('resolutions', $resolutions);

		//
		// filter by id
		//
		if(isset($this->passedArgs['Search.id'])) {

				// set the conditions
				$this->paginate['conditions'][]['Story.id'] = $this->passedArgs['Search.id'];

				// set the Search data, so the form remembers the option
				$this->data['Search']['id'] = $this->passedArgs['Search.id'];
		}

		//
		// filter by keywords
		//
		if(isset($this->passedArgs['Search.keywords'])) {
				$keywords = $this->passedArgs['Search.keywords'];
				$this->paginate['conditions'][] = array(
						'OR' => array(
								'Story.name LIKE' => "%$keywords%",
								'Story.description LIKE' => "%$keywords%",
						)
				);
				$this->data['Search']['keywords'] = $keywords;
		}

		//
		// filter by name
		//
		if(isset($this->passedArgs['Search.name'])) {
				$this->paginate['conditions'][]['Story.name LIKE'] = str_replace('*','%',$this->passedArgs['Search.name']);
				$this->data['Search']['name'] = $this->passedArgs['Search.name'];
		}

		//
		// filter by description
		//
		if(isset($this->passedArgs['Search.description'])) {
				$this->paginate['conditions'][]['Story.description LIKE'] = str_replace('*','%',$this->passedArgs['Search.description']);
				$this->data['Search']['description'] = $this->passedArgs['Search.description'];
		}

		//
		// filter by sprint_id
		//
		if(isset($this->passedArgs['Search.sprint_id'])) {
				$this->paginate['conditions'][]['Story.sprint_id'] = $this->passedArgs['Search.sprint_id'];
				$this->data['Search']['sprint_id'] = $this->passedArgs['Search.sprint_id'];
		}

		//
		// filter by team_id
		//
		if(isset($this->passedArgs['Search.team_id'])) {
				$this->paginate['conditions'][]['Story.team_id'] = $this->passedArgs['Search.team_id'];
				$this->data['Search']['team_id'] = $this->passedArgs['Search.team_id'];
		}

		//
		// filter by resolution_id
		//
		if(isset($this->passedArgs['Search.resolution_id'])) {
				$this->paginate['conditions'][]['Story.resolution_id'] = $this->passedArgs['Search.resolution_id'];
				$this->data['Search']['resolution_id'] = $this->passedArgs['Search.resolution_id'];
		}

		//
		// filter by priority_id
		//
		if(isset($this->passedArgs['Search.priority_id'])) {
				$this->paginate['conditions'][]['Story.priority_id'] = $this->passedArgs['Search.priority_id'];
				$this->data['Search']['priority_id'] = $this->passedArgs['Search.priority_id'];
		}


		//
		// filter by created
		// allowing searches starting with <, >, <=, >=
		// allow human dates "2 weeks ago", "last thursday"
		//
		//if(isset($this->passedArgs['Search.created'])) {
		//		$field = '';
		//		$date = explode(' ',$this->passedArgs['Search.created']);
		//		if (isset($date[1]) && in_array($date[0],array('<','>','<=','>='))) {
		//				$field = ' '.array_shift($date);
		//		}
		//		$date = implode(' ',$date);
		//		$date = date('Y-m-d',strtotime($date));  
		//		$this->paginate['conditions'][]['Story.created'.$field] = $date;
		//		$this->data['Search']['created'] = $this->passedArgs['Search.created'];
		//}

		$stories = $this->Story->populate_data($this->paginate());
	   
		$this->set(compact('stories'));
	}
}
?>