<?php
class FramesRoomIdNull extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'frames_room_id_null';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
			'alter_field' => array(
				'frames' => array(
					'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'alter_field' => array(
				'frames' => array(
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
