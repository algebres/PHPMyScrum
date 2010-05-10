<?php
/* Task Fixture generated on: 2010-03-27 06:03:24 : 1269639324 */
class TaskFixture extends CakeTestFixture {
	var $name = 'Task';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sprint_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'story_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'estimate_hours' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'sprint_id' => 1,
			'story_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'estimate_hours' => 1,
			'user_id' => 1,
			'disabled' => 1,
			'created' => '2010-03-27 06:35:24',
			'updated' => '2010-03-27 06:35:24'
		),
	);
}
?>