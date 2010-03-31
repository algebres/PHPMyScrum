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
	 * 現在有効なストーリー
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



}
?>