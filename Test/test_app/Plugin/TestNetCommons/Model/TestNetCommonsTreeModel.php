<?php
/**
 * NetCommonsTreeBehaviorテスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * NetCommonsTreeBehaviorテスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\test_app\Plugin\TestNetCommons\Model
 */
class TestNetCommonsTreeModel extends AppModel {

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = 'net_commons_tree_models'; //public $useTable = 'cake_tree_models';

/**
 * 使用するビヘイビア
 *
 * @var array
 */
	public $actsAs = [
		//'Tree',
		'NetCommons.NetCommonsTree',
	];

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentTestNetCommonsTreeModel' => array(
			'className' => 'TestNetCommons.TestNetCommonsTreeModel',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildTestNetCommonsTreeModel' => array(
			'className' => 'TestNetCommons.TestNetCommonsTreeModel',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}
