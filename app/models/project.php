<?php
class Project extends AppModel {
	var $name = 'Project';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'disabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

	/**
	 * プロジェクト情報を取得する
	 * @return プロジェクト情報
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