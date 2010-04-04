<?php
/* Information Fixture generated on: 2010-04-04 15:04:18 : 1270363038 */
class InformationFixture extends CakeTestFixture {
	var $name = 'Information';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'show_anonymous' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'disabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'startdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'enddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
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
			'show_anonymous' => 1,
			'disabled' => 1,
			'startdate' => '2010-04-04 15:37:18',
			'enddate' => '2010-04-04 15:37:18',
			'created' => '2010-04-04 15:37:18',
			'updated' => '2010-04-04 15:37:18'
		),
	);
}
?>