<?php
class Resolution extends AppModel {
	var $name = 'Resolution';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	var $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'resolution_id',
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
	 * 解決に該当する状況かどうか
	 * @param $id
	 * @return boolean
	 */
	function is_fixed($id)
	{
		$record = $this->findById($id);
		if($record)
		{
			return ($record["Resolution"]["is_fixed"] == 1);
		}
		else
		{
			return false;
		}
	}

	/**
	 * 現在有効な解決状況のリストを取得する(プルダウン用)
	 * @return リスト
	 */
	function getActiveResolutionList()
	{
		$conditions = array();
		return $this->find('list', $conditions);
	}

	/**
	 * 解決状況一覧から名前に合致する解決状況のIDを探す
	 * @param $resolutions 解決状況の名前のリスト
	 * @param $name 調べたい解決状況
	 * @return integer
	 */
	function getResolutionId($resolutions, $name)
	{
		foreach($resolutions as $key => $value)
		{
			if($value === $name)
			{
				return $key;
			}
		}
		return null;
	}

	/**
	 * 初期データ
	 * @return boolean
	 */
	function makeInitialRecord()
	{
		$rec = $this->find('list');
		if(count($rec) == 0)
		{
			$data["Resolution"]["id"] = RESOLUTION_TODO;
			$data["Resolution"]["name"] = __("TODO", true);
			$data["Resolution"]["is_fixed"] = 0;
			$this->create();
			$this->save($data);
			$data["Resolution"]["id"] = RESOLUTION_DOING;
			$data["Resolution"]["name"] = __("DOING", true);
			$data["Resolution"]["is_fixed"] = 0;
			$this->create();
			$this->save($data);
			$data["Resolution"]["id"] = RESOLUTION_DONE;
			$data["Resolution"]["name"] = __("DONE", true);
			$data["Resolution"]["is_fixed"] = 1;
			$this->create();
			$this->save($data);
		}
		return true;
	}
}
?>