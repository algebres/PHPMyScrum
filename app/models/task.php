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

	var $fields = array(
		'save' => array('name', 'description', 'sprint_id', 'story_id', 'estimate_hours', 'resolution_id', 'user_id'),
		'simple_save' => array('description', 'estimate_hours', 'resolution_id', 'user_id'),
	);


	/**
	 * �^�X�N�X�V�̍ۂɂ͎��Ԃ��c���ԃe�[�u���ɂ��˂�����
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
	 * �^�X�N���폜�������Ǝc���ԃf�[�^���폜
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
	 * �����̃^�X�N���擾
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

		// �����ς݂��܂߂Ȃ��ꍇ�͑|��
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

	function getRemainingHours($story_id)
	{
		// �֘A����^�X�N�̎c�莞�Ԃ��擾
		$conditions =  array(
				'conditions' => array(
					'Task.disabled' => 0,
					'Task.story_id' => $story_id,
				),
			);
		$tasks = $this->find('all', $conditions);
		$total_remaining_hours = 0;
		foreach($tasks as $task)
		{
			$total_remaining_hours += $task["Task"]["estimate_hours"];
		}
		return $total_remaining_hours;
	}

	/**
	 * Excel�ۑ�
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
		$worksheet =& $workbook->addWorksheet('task');
		$format =& $workbook->addFormat();
		$format->setSize(9);
		$header_format =& $workbook->addFormat();
		$header_format->setSize(9);
		$header_format->setFgColor('gray');

		// �w�b�_�[
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

		// �f�[�^
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

		// �����ݒ�
		$width = array(4, 14, 50, 50 ,50, 10, 10, 10, 10);
		for($i = 0; $i<count($width); $i++)
		{
			$worksheet->setColumn($i, $i, $width[$i]);
		}

		$workbook->close();
		exit;
	}

	/**
	 * CSV�ۑ�
	 */
	function saveToCSV($data, $filename)
	{
		Configure::write('debug', 0);

		$list = array();

		// header
		$header = array('Task Id', 'Sprint', 'Story Id', 'Story', 'Task', 'Description', 
			'Estimate Hours', 'Username', 'Resolution', 'Created'
		);
		$row = array();
		for($i = 0; $i < count($header); $i++)
		{
			$row[] = __($header[$i], true);
		}
		$list[] = $row;

		// data
		foreach($data as $item)
		{
			$row = array();
			$row[] = $item["Task"]["id"];
			$row[] = $item["Sprint"]["name"];
			$row[] = $item["Story"]["id"];
			$row[] = $item["Story"]["name"];
			$row[] = $item["Task"]["name"];
			$row[] = $item["Task"]["description"];
			$row[] = $item["Task"]["estimate_hours"];
			$row[] = $item["User"]["username"];
			$row[] = $item["Resolution"]["name"];
			$row[] = date('Y-m-d', strtotime($item["Task"]["created"]));
			$list[] = $row;
		}
		$this->makeCSV($filename, $list);
		exit;
	}

	/**
	 * ��������
	 */
	function getSelectConditon($param, $user_id)
	{
		if ($param == "yours")
		{
			return array(
				'conditions' => array(
					'Task.disabled' => 0,
					'Task.user_id' => $user_id,
				),
			);
		}
		if ($param == "unfinished")
		{
			return array(
				'conditions' => array(
					'Task.disabled' => 0,
					'or' => array(
						'Resolution.is_fixed !=' => 1,
						'Task.resolution_id' => null,
					),
				),
			);
		}
		if ($param == "your_unfinished")
		{
			return array(
				'conditions' => array(
					'Task.disabled' => 0,
					'Task.user_id' => $user_id,
					'or' => array(
						'Resolution.is_fixed !=' => 1,
						'Task.resolution_id' => null,
					),
				),
			);
		}
		return array(
				'conditions' => array(
					'Task.disabled' => 0,
				),
		);
	}

}
?>
