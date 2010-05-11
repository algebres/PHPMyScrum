<?php
class M4be9d0b79718406d96e96588061edf5f extends CakeMigration {

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
			'alter_field' => array(
						'users' => array(
							'username' => array('name' => 'display_name', 'type' => 'string', 'null' => false, 'length' => 100, 'default' => NULL),
						),
					),
		),
		'down' => array(
			'alter_field' => array(
						'users' => array(
							'display_name' => array('name' => 'username', 'type' => 'string', 'null' => false, 'length' => 100, 'default' => NULL),
						),
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