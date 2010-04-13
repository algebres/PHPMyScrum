<?php
class Sprint extends AppModel {
	var $name = 'Sprint';
	var $displayField = 'name';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false, )); 
	var $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
			),
		),
		'startdate' => array(
		//	'date' => array(
		//		//'rule' => array('date'),
		//		//'message' => 'Your custom message here',
		//		//'allowEmpty' => false,
		//		//'required' => false,
		//		//'last' => false, // Stop validation after this rule
		//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		//	),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'enddate' => array(
		//	'date' => array(
		//		//'rule' => array('date'),
		//		//'message' => 'Your custom message here',
		//		//'allowEmpty' => false,
		//		//'required' => false,
		//		//'last' => false, // Stop validation after this rule
		//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		//	),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'sprint_id',
			'dependent' => false,
			'conditions' => 'Task.disabled = 0',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'sprint_id',
			'dependent' => false,
			'conditions' => 'Story.disabled = 0',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $fields = array(
		'save' => array('name', 'description', 'startdate', 'enddate'),
	);


	function getCurrentSprint()
	{
		$current = date('Y-m-d H:i:s');
		$condition = array(
			"conditions" => array(
				'Sprint.startdate <=' => $current,
				'Sprint.enddate >= ' => $current,
				'Sprint.disabled' => 0,
			),
		);
		return $this->find('all', $condition);
	}

	/**
	 * 現在有効なユーザー
	 */
	function getActiveSprintList()
	{
		$conditions = array(
			'conditions' => array(
				'Sprint.disabled' => 0,
			),
		);
		return $this->find('list', $conditions);
	}

	/**
	 * スプリント期間の日数
	 */
	function getSprintTerm($sprint_id)
	{
		$this->recursive = 0;
		$sprint = $this->findById($sprint_id);

		// 一旦時刻へ
		$start_date = strtotime($sprint["Sprint"]["startdate"]);
		$end_date = strtotime($sprint["Sprint"]["enddate"]) -1 ;

		return $this->datediff($start_date, $end_date);
	}

	private function datediff($start_date, $end_date)
	{
		// 日付にばらす
		$start_date_y = date('Y', $start_date);
		$start_date_m = date('m', $start_date);
		$start_date_d = date('d', $start_date);
		$end_date_y = date('Y', $end_date);
		$end_date_m = date('m', $end_date);
		$end_date_d = date('d', $end_date);

		// 期間が何日あるか調べる
		$dt1 = mktime(0, 0, 0, $start_date_m, $start_date_d, $start_date_y);
		$dt2 = mktime(0, 0, 0, $end_date_m, $end_date_d, $end_date_y);
		$diff = $dt2 - $dt1;
		return ($diff / 86400) + 1;
	}

	function getSprintCalendar($sprint_id)
	{
		$this->recursive = 0;
		$sprint = $this->findById($sprint_id);

		// 一旦時刻へ
		$start_date = strtotime($sprint["Sprint"]["startdate"]);
		$end_date = strtotime($sprint["Sprint"]["enddate"]) -1 ;

		return $this->createCalendar($start_date, $end_date);
	}

	function getSprintRemainingHours($sprint_id)
	{
		$this->recursive = 2;
		//storyのIDとタスクのID順に並べる
		$this->hasMany["Task"]["order"] = "Task.story_id asc, Task.id asc";
		$sprint = $this->findById($sprint_id);
		$start_date = strtotime($sprint["Sprint"]["startdate"]);
		$end_date = strtotime($sprint["Sprint"]["enddate"]) -1 ;

		$data = array();
		$calendar = $this->createCalendar($start_date, $end_date);
		$today_key = date('Y-m-d');

		foreach($sprint["Task"] as $task)
		{
			$remaining = $task["RemainingTime"];
			
			// 日付キーで回す
			for($i=0; $i<count($calendar); $i++)
			{
				$key = $calendar[$i];
				$task["Hours"][$key] = "";
				// 残存時間履歴をチェック
				foreach($remaining as $tmp)
				{
					if($tmp["created"] === $key)
					{
						$task["Hours"][$key] = $tmp["hours"];
					}
				}
			}

			//TODO:スプリント期間前で一番直近の入力時間を取得する
			$recent_initial_hours = "";
			$recent_initial_created = "";
			foreach($remaining as $tmp)
			{
				if($tmp["created"] <= @$calendar[0])
				{
					if($recent_initial_hours == "")
					{
						$recent_initial_hours = $tmp["hours"];
						$recent_initial_created = $tmp["created"];
					}
					else
					{
						if($tmp["created"] > $recent_initial_created)
						{
							$recent_initial_hours = $tmp["hours"];
							$recent_initial_created = $tmp["created"];
						}
					}
				}
			}

			// 空白の地点を埋める
			for($i=1; $i<count($calendar); $i++)
			{
				$old_key = $calendar[$i-1];
				$now_key = $calendar[$i];
				// 1日前の残り時間をチェック
				if($i == 1 && $task["Hours"][$old_key] == "")
				{
					$task["Hours"][$old_key] = $recent_initial_hours;
				}

				// 埋める
				if($task["Hours"][$now_key] === "")
				{
					$task["Hours"][$now_key] = $task["Hours"][$old_key];
				}
			}

			$data[] = $task;
		}
		return $data;
	}

	private function createCalendar($start_date, $end_date)
	{
		$diff = $this->datediff($start_date, $end_date);
		$cal = array();
		for($i = 0; $i < $diff; $i++)
		{
			$cal[] = date('Y-m-d', $start_date + $i * 86400);
		}
		return $cal;
	}

	/**
	 * 指定したスプリントに関連するストーリーとタスクがあるか
	 */
	function hasActiveStoriesAndTask($id)
	{
		$this->recursive = 1;
		$has_many = $this->hasMany;
		$this->hasMany["Story"]["conditions"] = "Story.disabled = 0";
		$this->hasMany["Task"]["conditions"] = "Story.disabled = 0";
		$record = $this->read(null, $id);
		$this->hasMany = $has_many;	// 元に戻す
		return (count($record["Story"]) != 0 || count($record["Task"]) != 0); 
	}

	/**
	 * そのスプリントの合計ストーリーポイントを取得
	 */
	function getTotalStoryPoint($data)
	{
		$sum = 0;
		foreach($data["Story"] as $story)
		{
			$sum += $story["storypoints"];
		}
		return $sum;
	}

	function getTotalFinishedStoryPoint($data)
	{
		$sum = 0;
		foreach($data["Story"] as $story)
		{
			if($story["resolution_id"] == RESOLUTION_DONE)
			{
				$sum += $story["storypoints"];
			}
		}
		return $sum;
	}


	function saveToExcel($id, $filename)
	{
		Configure::write('debug', 0);
		App::import('Vendor', 'include_path');
		App::import(
			'Vendor',
			'Spreadsheet_Excel_Writer', 
			array('file' => 'Spreadsheet' . DS . 'Excel' . DS . 'Writer.php')
		);

		// 必要なデータを収集する
		$this->recursive = 2;	// story名等
		$sprint = $this->read(null, $id);
		$sprint_term = $this->getSprintTerm($sprint["Sprint"]["id"]);
		$sprint_calendar = $this->getSprintCalendar($sprint["Sprint"]["id"]);
		$sprint_remaining_hours = $this->getSprintRemainingHours($id);

		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->send($filename);
		$worksheet =& $workbook->addWorksheet('sprint');
		$format =& $workbook->addFormat();
		$format->setSize(9);
		$header_format =& $workbook->addFormat();
		$header_format->setSize(9);
		$header_format->setFgColor('gray');
		$story_format =& $workbook->addFormat();
		$story_format->setSize(9);
		$story_format->setFgColor(38);
		$footer_format =& $workbook->addFormat();
		$footer_format->setSize(9);
		$footer_format->setFgColor('gray');
		$footer_format->setBold();

		// 横軸カレンダー
		$day_count = 0;
		$row = 0;
		$col = 0;
		$worksheet->write($row, $col, '', $header_format);
		$col++;
		$worksheet->write($row, $col, $this->sjis(__('Task', true)), $header_format);
		$col++;
		$worksheet->write($row, $col, '', $header_format);
		$col++;
		foreach($sprint_calendar as $cal) { 
			$day_count++;
			$worksheet->write($row, $col, date('d', strtotime($cal)), $header_format);
			$col++;
		}

		// 幅
		$worksheet->setColumn(0, 0, 3);
		$worksheet->setColumn(1, 1, 40);
		$worksheet->setColumn(2, 1, 10);
		// 日付と実績の幅を設定
		$worksheet->setColumn(3, 3+$day_count, 3);

		// 残り時間
		$row++;
		// 縦
		$story_id = "";
		foreach($sprint_remaining_hours as $a) {
			if($a["Story"]["id"] != $story_id)
			{
				$col = 0;
				$story_id = $a["Story"]["id"];
				$worksheet->write($row, $col, $this->sjis($a["Story"]["name"]), $story_format);
				// セル結合
				$worksheet->mergeCells($row, 0, $row, 2 + $day_count);
				$row++;
			}
			$col = 0;
			$worksheet->write($row, $col, $this->sjis($a["id"]), $format);
			$col++;
			$worksheet->write($row, $col, $this->sjis($a["name"]), $format);
			$col++;
			$worksheet->write($row, $col, $this->sjis($a["User"]["username"]), $format);
			$col++;
			// 横
			foreach($sprint_calendar as $cal) {
				$worksheet->write($row, $col, $a["Hours"][$cal], $format);
				$col++;
			}
			$row++;
		}

		// タスクの合計時間
		$col = 0;
		$worksheet->write($row, $col, '', $header_format);
		$col++;
		$worksheet->write($row, $col, $this->sjis(__('Sum', true)), $header_format);
		$col++;
		$worksheet->write($row, $col, '', $header_format);
		$col++;
		foreach($sprint_calendar as $cal) 
		{
			$sum = 0;
			foreach($sprint_remaining_hours as $a) {
				$sum += $a["Hours"][$cal];
			}
			$worksheet->write($row, $col, $sum, $footer_format);
			$col++;
		}

		$workbook->close();
		exit;
		
	}

}
?>