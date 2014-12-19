<?php
/**
 * UserFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for UserFixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 1,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 2,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 2,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 2,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 3,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 3,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 3,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 4,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 4,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 4,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 5,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 5,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 5,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 6,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 6,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 6,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 7,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 7,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 7,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 8,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 8,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 8,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 9,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 9,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 9,
			'modified' => '2014-11-26 01:47:31'
		),
		array(
			'id' => 10,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role_key' => 'Lorem ipsum dolor sit amet',
			'created_user' => 10,
			'created' => '2014-11-26 01:47:31',
			'modified_user' => 10,
			'modified' => '2014-11-26 01:47:31'
		),
	);

}
