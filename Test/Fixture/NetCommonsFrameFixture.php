<?php
/**
 * FrameFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for FrameFixture
 */
class NetCommonsFrameFixture extends CakeTestFixture {

/**
 * table
 *
 * @var string
 */
	public $table = 'frames';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'room_id' => 1,
			'box_id' => 1,
			'plugin_id' => 1,
			'block_id' => 1,
			'weight' => 1,
			'is_published' => true,
			'from' => '2014-07-07 10:00:00',
			'to' => '2014-08-07 10:00:00',
			'created_user_id' => 1,
			'created' => '2014-07-07 10:00:00',
		),
		array(
			'id' => 2,
			'room_id' => 1,
			'box_id' => 1,
			'plugin_id' => 1,
			'block_id' => 1,
			'weight' => 1,
			'is_published' => true,
			'from' => '2014-07-07 10:00:00',
			'to' => '2014-08-07 10:00:00',
			'created_user_id' => 1,
			'created' => '2014-07-07 10:00:00',
		)
	);

}
