<?php
/* Sprint Fixture generated on: 2010-03-27 06:03:30 : 1269639030 */
class SprintFixture extends CakeTestFixture {
	var $name = 'Sprint';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'startdate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'enddate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'startdate' => '2010-03-27 06:30:30',
			'enddate' => '2010-03-27 06:30:30',
			'disabled' => 1,
			'created' => '2010-03-27 06:30:30',
			'updated' => '2010-03-27 06:30:30'
		),
	);
}
?>