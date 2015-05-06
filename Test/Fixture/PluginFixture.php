<?php
/**
 * PluginFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for PluginFixture
 */
class PluginFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key to identify plugin.
Must be equivalent to plugin name used in router url.
e.g.) user_manager, auth, pages', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Human friendly name for the plugin.
e.g.) User Manager, Auth, Pages', 'charset' => 'utf8'),
		'namespace' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Unique namespace for package management system.
e.g.) packagist', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '1:for frame,2:for control panel'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'language_id' => 2,
			'key' => 'test_plugin',
			'weight' => 1,
			'type' => 1,
			'created_user' => 1,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 1,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 2,
			'language_id' => 2,
			'key' => 'test_plugin',
			'weight' => 2,
			'type' => 1,
			'created_user' => 2,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 2,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 3,
			'language_id' => 2,
			'key' => 'plugin_3',
			'weight' => 3,
			'type' => 1,
			'created_user' => 3,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 3,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 4,
			'language_id' => 2,
			'key' => 'plugin_4',
			'weight' => 4,
			'type' => 1,
			'created_user' => 4,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 4,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 5,
			'language_id' => 2,
			'key' => 'plugin_5',
			'weight' => 5,
			'type' => 1,
			'created_user' => 5,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 5,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 6,
			'language_id' => 2,
			'key' => 'plugin_6',
			'weight' => 6,
			'type' => 1,
			'created_user' => 6,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 6,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 7,
			'language_id' => 2,
			'key' => 'plugin_7',
			'weight' => 7,
			'type' => 1,
			'created_user' => 7,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 7,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 8,
			'language_id' => 2,
			'key' => 'plugin_8',
			'weight' => 8,
			'type' => 1,
			'created_user' => 8,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 8,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 9,
			'language_id' => 2,
			'key' => 'plugin_9',
			'weight' => 9,
			'type' => 1,
			'created_user' => 9,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 9,
			'modified' => '2014-07-25 08:16:24'
		),
		array(
			'id' => 10,
			'language_id' => 2,
			'key' => 'plugin_10',
			'weight' => 10,
			'type' => 1,
			'created_user' => 10,
			'created' => '2014-07-25 08:16:24',
			'modified_user' => 10,
			'modified' => '2014-07-25 08:16:24'
		)
	);

}
