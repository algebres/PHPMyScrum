<?php
/* Teammember Fixture generated on: 2010-03-27 06:03:32 : 1269639392 */
class TeammemberFixture extends CakeTestFixture {
	var $name = 'Teammember';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'team_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'team_id' => 1,
			'user_id' => 1,
			'disabled' => 1,
			'updated' => '2010-03-27 06:36:32',
			'created' => '2010-03-27 06:36:32'
		),
	);
}
?>