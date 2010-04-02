<?php
App::import('Mode', 'RemainingTime');

class Task extends AppModel {
	var $name = 'Task';
	var $displayField = 'name';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false)); 
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
		'sprint_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'story_id' => array(
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
		),
		'estimate_hours' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Sprint' => array(
			'className' => 'Sprint',
			'foreignKey' => 'sprint_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'story_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Resolution' => array(
			'className' => 'Resolution',
			'foreignKey' => 'resolution_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'RemainingTime' => array(
			'className' => 'RemainingTime',
			'foreignKey' => 'task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'RemainingTime.created desc',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/**
	 * タスク更新の際には時間を残時間テーブルにも突っ込む
	 */
	function afterSave($created)
	{
		if($created)
		{
			$task_id = $this->getInsertID();
		}
		else
		{
			$task_id = @$this->data["Task"]["id"];
			if(!$task_id)
			{
				$task_id = $this->getID();
			}
		}
		$this->recursive = 0;
		$data = $this->findById($task_id);
		if(empty($data))
		{
			return;
		}
		$hours = $data["Task"]["estimate_hours"];
		$disabled = $data["Task"]["disabled"];
		$created = date('Y-m-d');
		if($disabled == 0)
		{
			$this->RemainingTime = new RemainingTime();
			$rec = $this->RemainingTime->findByTaskIdAndCreated($task_id, $created);
			if($rec)
			{
				$d["RemainingTime"]["id"] = $rec["RemainingTime"]["id"];
			}
			$d["RemainingTime"]["task_id"] = $task_id;
			$d["RemainingTime"]["hours"] = $hours;
			$this->RemainingTime->save($d);
		}
		else
		{
			$this->deleteRemaining($task_id);
		}
	}

	/**
	 * タスクを削除したあと残時間データも削除
	 */
	function deleteRemaining($task_id)
	{
		$this->RemainingTime = new RemainingTime();
		$conditions = array(
			'RemainingTime.task_id' => $task_id,
		);
		$this->RemainingTime->deleteAll($conditions, false);
	}

	/**
	 * 自分のタスクを取得
	 */
	function getUserTask($user_id, $include_finished_data = false)
	{
		$belongsto = $this->belongsTo;
		$this->recursive = 1;
		$this->belongsTo["Sprint"]["order"] = "Sprint.startdate asc";
		$this->belongsTo["Story"]["order"] = "Story.id asc";

		$conditions = array(
			'conditions' => array(
				'Task.user_id' => $user_id,
				'Task.disabled' => 0,
			),
		);
		$records = $this->find('all', $conditions);
		$this->belongsTo = $belongsto;

		// 完了済みを含めない場合は掃除
		if(!$include_finished_data)
		{
			for($i=count($records)-1; $i>=0; $i--)
			{
				if($records[$i]["Resolution"]["is_fixed"] == true)
				{
					unset($records[$i]);
				}
			}
		}
		return $records;
	}

	/**
	 * Excel保存
	 */
	function saveToExcel($data, $filename)
	{
		Configure::write('debug', 0);
		App::import(
			'Vendor',
			'Spreadsheet_Excel_Writer', 
			array('file' => 'Spreadsheet' . DS . 'Excel' . DS . 'Writer.php')
		);

		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->send($filename);
		$worksheet =& $workbook->addWorksheet('task');
		$format =& $workbook->addFormat();
		$format->setSize(9);
		$header_format =& $workbook->addFormat();
		$header_format->setSize(9);
		$header_format->setFgColor('gray');

		// ヘッダー
		$header = array('Task Id', 'Sprint', 'Story', 'Task', 'Description', 
			'Estimate Hours', 'Username', 'Resolution', 'Created'
		);
		$row = 0;
		$col = 0;
		for($i = 0; $i < count($header); $i++)
		{
			$worksheet->write($row, $col, $this->sjis(__($header[$i], true)), $header_format);
			$col++;
		}

		// データ
		$row++;
		foreach($data as $item)
		{
			$col = 0;
			$worksheet->writeNumber($row, $col, $this->sjis($item["Task"]["id"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Sprint"]["name"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["name"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Task"]["name"]), $format);						$col++;
			$worksheet->write($row, $col, $this->sjis($item["Task"]["description"]), $format);				$col++;
			$worksheet->writeNumber($row, $col, $this->sjis($item["Task"]["estimate_hours"]), $format);		$col++;
			$worksheet->write($row, $col, $this->sjis($item["User"]["username"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Resolution"]["name"]), $format);				$col++;
			$worksheet->write($row, $col, date('Y-m-d', strtotime($item["Task"]["created"])), $format);		$col++;
			$row++;
		}

		// 横幅設定
		$width = array(4, 14, 50, 50 ,50, 10, 10, 10, 10);
		for($i = 0; $i<count($width); $i++)
		{
			$worksheet->setColumn($i, $i, $width[$i]);
		}

		$workbook->close();
		exit;
	}
}
?>
