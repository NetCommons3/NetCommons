<?php
/**
 * NetCommonsTreeBehaviorModelFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * NetCommonsTreeBehaviorModelFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Fixture
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class NetCommonsTreeModel2Fixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'tree_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'sort_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'key' => 'index'),
		'child_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => ['parent_id', 'sort_key', 'id'], 'unique' => 0),
			'sort_key' => array('column' => ['sort_key', 'id'], 'unique' => 0),
			'weight' => array('column' => ['parent_id', 'weight'], 'unique' => 0),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = [
		['id' => '4001', 'parent_id' => null, 'tree_name' => 'Category 6', 'weight' => '1', 'sort_key' => '~00000001', 'child_count' => '3'],
		['id' => '5001', 'parent_id' => '4001', 'tree_name' => 'Category 6-1000', 'weight' => '1000', 'sort_key' => '~00000001-00001000', 'child_count' => '0'],
		['id' => '5002', 'parent_id' => '4001', 'tree_name' => 'Category 6-1001', 'weight' => '1001', 'sort_key' => '~00000001-00001001', 'child_count' => '0'],
		['id' => '5003', 'parent_id' => '4001', 'tree_name' => 'Category 6-1002', 'weight' => '1002', 'sort_key' => '~00000001-00001002', 'child_count' => '0'],
		['id' => '5004', 'parent_id' => null, 'tree_name' => 'Category 7', 'weight' => '1', 'sort_key' => '~00000002', 'child_count' => '1'],
		['id' => '5005', 'parent_id' => '5004', 'tree_name' => 'Category 7-1', 'weight' => '1', 'sort_key' => '~00000002-00000001', 'child_count' => '0'],
	];
}
