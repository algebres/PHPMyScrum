<?php
class M4be9aa66994c4578a7ae4acc061edf5f extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'information' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'show_anonymous' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'disabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'startdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'enddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'priorities' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'disabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'remaining_times' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'hours' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'resolutions' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
					'is_fixed' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'sprints' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'startdate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'enddate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'stories' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
					'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
					'storypoints' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'businessvalue' => array('type' => 'integer', 'null' => true, 'default' => '0'),
					'priority_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'sprint_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'resolution_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'team_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'idx_stories_key1' => array('column' => 'sprint_id', 'unique' => 0),
						'idx_stories_key2' => array('column' => 'team_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'story_comments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'story_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'comment' => array('type' => 'text', 'null' => false, 'default' => NULL),
					'disabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'idx_story_comments_key' => array('column' => 'story_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tasks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'sprint_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'story_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'estimate_hours' => array('type' => 'integer', 'null' => true, 'default' => '0'),
					'resolution_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'idx_tasks_key1' => array('column' => 'sprint_id', 'unique' => 0),
						'idx_tasks_key2' => array('column' => 'story_id', 'unique' => 0),
						'idx_tasks_key3' => array('column' => 'user_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'teammembers' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'team_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'teams' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'loginname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'unique'),
					'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
					'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
					'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
					'admin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'disabled' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'idx_users_pkey' => array('column' => 'loginname', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'wiki' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'path' => array('type' => 'string', 'null' => false, 'default' => '/', 'length' => 200),
					'slug' => array('type' => 'string', 'null' => false, 'length' => 200),
					'disabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'readonly' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'last_modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'body' => array('type' => 'text', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'information', 'priorities', 'projects', 'remaining_times', 'resolutions', 'sprints', 'stories', 'story_comments', 'tasks', 'teammembers', 'teams', 'users', 'wiki'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
?>