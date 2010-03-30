<?php
class Priority extends AppModel {
	var $name = 'Priority';
	// soft delete
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false)); 
	var $displayField = 'name';
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
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'priority_id',
			'dependent' => false,
			'conditions' => '',
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
	 * ���ݗL���ȗD�揇��
	 */
	function getActivePriorityList()
	{
		$conditions = array(
			'conditions' => array(
				'Priority.disabled' => 0,
			),
		);
		return $this->find('list', $conditions);
	}

	/**
	 * �w�肵���D�揇�ʂ͗L���ȃX�g�[���[�ƕR�t���Ă��邩
	 */
	function hasActiveStories($id)
	{
		$this->recursive = 1;
		$has_many = $this->hasMany;
		$this->hasMany["Story"]["conditions"] = "Story.disabled = 0";
		$record = $this->read(null, $id);
		$this->hasMany = $has_many;	// ���ɖ߂�
		return (count($record["Story"]) != 0); 
	}
}
?>