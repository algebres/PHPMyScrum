<?php
class Information extends AppModel {
	var $name = 'Information';
	var $displayField = 'name';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false));
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'show_anonymous' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'disabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'startdate' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'enddate' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	var $fields = array(
		'save' => array('name', 'description', 'startdate', 'enddate', 'show_anonymous'),
	);

	/**
	 * Get active information
	 * @param $show_anonymous
	 * @return unknown_type
	 */
	function getLatestInformation($show_anonymous = false)
	{
		$conditions = array(
			'conditions' => array(
				'Information.startdate <=' =>  date('Y-m-d'),
				'Information.enddate > ' =>  date('Y-m-d', strtotime("+1 day")),
				'Information.disabled' => 0,
			),
			'order' => 'Information.startdate desc',
		);
		if($show_anonymous)
		{
			$conditions["conditions"]["Information.show_anonymous"] = 1;
		}
		return $this->find('all', $conditions);
	}
}
?>