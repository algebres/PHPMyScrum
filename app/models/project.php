<?php
class Project extends AppModel {
	var $name = 'Project';
	var $displayField = 'name';
	var $validate = array(
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
		'disabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * プロジェクト情報を取得
	 */
	function getProjectInfo()
	{
		$id = 1;
		$rec = $this->findById($id);
		if(!$rec)
		{
			$data["Project"]["id"] = $id;
			$data["Project"]["name"] = __("Default Project", true);
			$data["Project"]["description"] = __("This is Default Project", true);
			$this->create();
			$this->save($data);
			return $data;
		}
		else
		{
			return $rec;
		}
	}
}
?>