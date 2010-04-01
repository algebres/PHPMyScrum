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
		)
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
	 * 合計タスク数や合計残り時間を計算
	 */
	function populate_data($data)
	{
/**
//foreachに変える
		for($i=0; $i< count($data); $i++)
		{
			$data[$i]["Story"]["task_count"] = count($data[$i]["Task"]);
			$sum = 0;
			//foreach($data[$i]["Task"] as $task)
			//{
			//	$sum += $task["estimate_hours"];
			//}
			$data[$i]["Story"]["total_hours"] = $sum;
		}
**/
		return $data;
	}

}
?>