<?php
/**
 * TrackablesUserFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for TrackablesUserFixture
 */
class TrackablesUserFixture extends CakeTestFixture {

	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'trackable_id' =>  array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'trackable_id' => 1,
			'user_id' => 1
		),
		array(
			'id' => 2,
			'trackable_id' => 1,
			'user_id' => 2
		),
		array(
			'id' => 3,
			'trackable_id' => 2,
			'user_id' => 1
		),
		array(
			'id' => 4,
			'trackable_id' => 2,
			'user_id' => 2
		)
	);
}
