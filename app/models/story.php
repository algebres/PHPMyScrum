<?php
class Story extends AppModel {
	var $name = 'Story';
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
		'storypoints' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'businessvalue' => array(
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
		'Priority' => array(
			'className' => 'Priority',
			'foreignKey' => 'priority_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Team' => array(
			'className' => 'Team',
			'foreignKey' => 'team_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sprint' => array(
			'className' => 'Sprint',
			'foreignKey' => 'sprint_id',
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
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'story_id',
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
		'StoryComment' => array(
			'className' => 'StoryComment',
			'foreignKey' => 'story_id',
			'dependent' => false,
			'conditions' => 'StoryComment.disabled = 0',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	var $fields = array(
		'save' => array('name', 'description', 'storypoints', 'businessvalue', 'priority_id', 'sprint_id', 'resolution_id', 'team_id'),
	);

	/**
	 * 現在有効なストーリーの名前をリストボックス用に取得
	 */
	function getActiveStoryList()
	{
		$conditions = array(
			'conditions' => array(
				'Story.disabled' => 0,
			),
		);
		return $this->find('list', $conditions);
	}

	/**
	 * 指定したストーリーは有効なタスクと紐付いているか
	 */
	function hasActiveTasks($id)
	{
		$this->recursive = 1;
		$has_many = $this->hasMany;
		$this->hasMany["Task"]["conditions"] = "Task.disabled = 0";
		$record = $this->read(null, $id);
		$this->hasMany = $has_many;	// 元に戻す
		return (count($record["Task"]) != 0); 
	}

	/**
	 * 解決状況一覧から名前に合致する解決状況のIDを探す
	 */
	function isValidStoryId($stories, $id)
	{
		foreach($stories as $key => $value)
		{
			if($key === $id)
			{
				return true;
			}
		}
		return false;
	}


	/**
	 * 合計タスク数や合計残り時間を計算
	 *
	 * @description このモデルを主キーにした場合のみ利用可能
	 */
	function populate_data($data)
	{
		$return = array();
		foreach($data as $item) {
			$item["Story"]["task_count"] = count($item["Task"]);
			$sum = 0;
			foreach($item["Task"] as $task)
			{
				$sum += $task["estimate_hours"];
			}
			$item["Story"]["total_hours"] = $sum;
			$return[] = $item;
		}
		return $return;
	}

	/**
	 * Excel保存
	 */
	function saveToExcel($data, $filename)
	{
		Configure::write('debug', 0);
		App::import('Vendor', 'include_path');
		App::import(
			'Vendor',
			'Spreadsheet_Excel_Writer', 
			array('file' => 'Spreadsheet' . DS . 'Excel' . DS . 'Writer.php')
		);

		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->send($filename);
		$worksheet =& $workbook->addWorksheet('story');
		$format =& $workbook->addFormat();
		$format->setSize(9);
		$header_format =& $workbook->addFormat();
		$header_format->setSize(9);
		$header_format->setFgColor('gray');

		// ヘッダー
		$header = array('Story Id', 'Story', 'Description', 'Story Points', 
			sprintf(__('Count of %s', true), (__('Task', true))),  
			sprintf(__('Sum of %s', true), (__('Remaining Hours', true))),
			'Businessvalue', 'Sprint', 'Priority', 'Resolution', 'Team', 'Created',
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
			$worksheet->writeNumber($row, $col, $this->sjis($item["Story"]["id"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["name"]), $format);						$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["description"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["storypoints"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["task_count"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["total_hours"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis($item["Story"]["businessvalue"]), $format);				$col++;
			$worksheet->write($row, $col, $this->sjis($item["Sprint"]["name"]), $format);						$col++;
			$worksheet->write($row, $col, $this->sjis($item["Priority"]["name"]), $format);						$col++;
			$worksheet->write($row, $col, $this->sjis(@$item["Resolution"]["name"]), $format);					$col++;
			$worksheet->write($row, $col, $this->sjis(@$item["Team"]["name"]), $format);						$col++;
			$worksheet->write($row, $col, date('Y-m-d', strtotime($item["Story"]["created"])), $format);		$col++;
			$row++;
		}

		// 横幅設定
		$width = array(4, 50, 50 ,10, 10, 10, 10, 10, 20, 10, 10);
		for($i = 0; $i<count($width); $i++)
		{
			$worksheet->setColumn($i, $i, $width[$i]);
		}

		$workbook->close();
		exit;
	}

	/**
	 * CSVのヘッダー
	 */
	function getCSVHeader()
	{
		// header
		$header = array('Story Id', 'Story', 'Description', 'Story Points', 
			sprintf(__('Count of %s', true), (__('Task', true))),  
			sprintf(__('Sum of %s', true), (__('Remaining Hours', true))),
			'Businessvalue', 'Sprint', 'Priority', 'Resolution', 'Team', 'Created',
		);
		$row = array();
		for($i = 0; $i < count($header); $i++)
		{
			$row[] = __($header[$i], true);
		}
		return $row;
	}

	/**
	 * CSV保存
	 */
	function saveToCSV($data, $filename)
	{
		Configure::write('debug', 0);

		$list = array();

		$list[] = $this->getCSVHeader();

		// data
		foreach($data as $item)
		{
			$row = array();
			$row[] = $item["Story"]["id"];
			$row[] = $item["Story"]["name"];
			$row[] = $item["Story"]["description"];
			$row[] = $item["Story"]["storypoints"];
			$row[] = $item["Story"]["task_count"];
			$row[] = $item["Story"]["total_hours"];
			$row[] = $item["Story"]["businessvalue"];
			$row[] = $item["Sprint"]["name"];
			$row[] = $item["Priority"]["name"];
			$row[] = $item["Resolution"]["name"];
			$row[] = $item["Team"]["name"];
			$row[] = date('Y-m-d', strtotime($item["Story"]["created"]));
			$list[] = $row;
		}
		$this->makeCSV($filename, $list);
		exit;
	}

}
?>