<?php
class Priority extends AppModel {
	var $name = 'Priority';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false));
	var $displayField = 'name';
	var $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	var $hasMany = array(
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'priority_id',
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
		'save' => array('name'),
	);

	/**
	 * 有効な優先順位の一覧を取得する
	 * @return リスト形式用配列
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
	 * 優先順位文字列に該当するIDを取得する
	 * @param $priorities 優先順位文字列の配列
	 * @param $name 調べたい文字列
	 * @return integer ID
	 */
	function getPriorityId($priorities, $name)
	{
		foreach($priorities as $key => $value)
		{
			if($value === $name)
			{
				return $key;
			}
		}
		return null;
	}

	/**
	 * この優先順位が有効なストーリーを持っているか
	 * @param $id
	 * @return boolean
	 */
	function hasActiveStories($id)
	{
		$this->recursive = 1;
		$has_many = $this->hasMany;
		$this->hasMany["Story"]["conditions"] = "Story.disabled = 0";
		$record = $this->read(null, $id);
		$this->hasMany = $has_many;
		return (count($record["Story"]) != 0);
	}
}
?>