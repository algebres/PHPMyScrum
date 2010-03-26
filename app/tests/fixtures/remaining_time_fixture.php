<?php
/* RemainingTime Fixture generated on: 2010-03-27 06:03:56 : 1269638936 */
class RemainingTimeFixture extends CakeTestFixture {
	var $name = 'RemainingTime';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'hours' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'task_id' => 1,
			'hours' => 1,
			'created' => '2010-03-27'
		),
	);
}
?>