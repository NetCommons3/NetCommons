<?php
/**
 * NetCommonsTreeBehavior::saveField()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::saveField()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorSaveFieldTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.net_commons_tree_model2',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsTreeModel2');
	}

/**
 * saveField()のテスト
 *
 * @param int $id ID
 * @param int|null $parentId 親ID
 * @param array $returnExtected メソッド戻り値の期待値
 * @param array $afterSaveExtected 登録後のデータの期待値
 *
 * @dataProvider caseSave1
 * @dataProvider caseSave2
 * @dataProvider caseSave3
 *
 * @return void
 */
	public function testSave($id, $parentId, $returnExtected, $afterSaveExtected) {
		//テスト実施
		$this->TestModel->id = $id;
		$result = $this->TestModel->saveField('parent_id', $parentId);
		$this->assertEquals($returnExtected, $result);

		$results = $this->TestModel->find('all', [
			'recursive' => -1,
			'order' => 'sort_key'
		]);
		$this->assertEquals($afterSaveExtected, $results);
	}

/**
 * Save用DataProvider
 *
 * @return array テストデータ
 */
	public function caseSave1() {
		$case['caseSave1'] = [
			'id' => '4002',
			'parentId' => '5002',
			'returnExtected' => [
				'TestNetCommonsTreeModel2' => [
					'id' => '4002',
					'parent_id' => '5002',
					'weight' => '2',
					'sort_key' => '~00000001-00000002-00000002',
				],
			],
			'afterSaveExtected' => [
				0 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4001',
						'parent_id' => null,
						'tree_name' => 'Category 6',
						'weight' => '1',
						'sort_key' => '~00000001',
						'child_count' => '6'
					],
				],
				1 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5001',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1000',
						'weight' => '1',
						'sort_key' => '~00000001-00000001',
						'child_count' => '0'
					],
				],
				2 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5002',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1001',
						'weight' => '2',
						'sort_key' => '~00000001-00000002',
						'child_count' => '3',
					],
				],
				3 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5003',
						'parent_id' => '5002',
						'tree_name' => 'Category 6-1001-1',
						'weight' => '1',
						'sort_key' => '~00000001-00000002-00000001',
						'child_count' => '0'
					],
				],
				4 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4002',
						'parent_id' => '5002',
						'tree_name' => 'Category 7',
						'weight' => '2',
						'sort_key' => '~00000001-00000002-00000002',
						'child_count' => '1',
					],
				],
				5 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5005',
						'parent_id' => '4002',
						'tree_name' => 'Category 7-1',
						'weight' => '1',
						'sort_key' => '~00000001-00000002-00000002-00000001',
						'child_count' => '0',
					],
				],
				6 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5004',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1002',
						'weight' => '3',
						'sort_key' => '~00000001-00000003',
						'child_count' => '0',
					],
				],
			]
		];

		return $case;
	}

/**
 * Save用DataProvider
 *
 * @return array テストデータ
 */
	public function caseSave2() {
		$case['caseSave2'] = [
			'id' => '4001',
			'parentId' => null,
			'returnExtected' => [
				'TestNetCommonsTreeModel2' => [
					'id' => '4001',
					'parent_id' => null,
					//'weight' => '1',
					//'sort_key' => '~00000001',
				],
			],
			'afterSaveExtected' => [
				0 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4001',
						'parent_id' => null,
						'tree_name' => 'Category 6',
						'weight' => '1',
						'sort_key' => '~00000001',
						'child_count' => '4'
					],
				],
				1 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5001',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1000',
						'weight' => '1',
						'sort_key' => '~00000001-00000001',
						'child_count' => '0'
					],
				],
				2 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5002',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1001',
						'weight' => '2',
						'sort_key' => '~00000001-00000002',
						'child_count' => '1'
					],
				],
				3 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5003',
						'parent_id' => '5002',
						'tree_name' => 'Category 6-1001-1',
						'weight' => '1',
						'sort_key' => '~00000001-00000002-00000001',
						'child_count' => '0'
					],
				],
				4 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5004',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1002',
						'weight' => '3',
						'sort_key' => '~00000001-00000003',
						'child_count' => '0'
					],
				],
				5 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4002',
						'parent_id' => null,
						'tree_name' => 'Category 7',
						'weight' => '1',
						'sort_key' => '~00000002',
						'child_count' => '1'
					],
				],
				6 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5005',
						'parent_id' => '4002',
						'tree_name' => 'Category 7-1',
						'weight' => '1',
						'sort_key' => '~00000002-00000001',
						'child_count' => '0'
					],
				],
			]
		];

		return $case;
	}

/**
 * Save用DataProvider
 *
 * @return array テストデータ
 */
	public function caseSave3() {
		$case['caseSave3'] = [
			'id' => '5002',
			'parentId' => '5004',
			'returnExtected' => [
				'TestNetCommonsTreeModel2' => [
					'id' => '5002',
					'parent_id' => '5004',
					'weight' => '1',
					'sort_key' => '~00000001-00000002-00000001',
				],
			],
			'afterSaveExtected' => [
				0 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4001',
						'parent_id' => null,
						'tree_name' => 'Category 6',
						'weight' => '1',
						'sort_key' => '~00000001',
						'child_count' => '4'
					],
				],
				1 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5001',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1000',
						'weight' => '1',
						'sort_key' => '~00000001-00000001',
						'child_count' => '0'
					],
				],
				2 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5004',
						'parent_id' => '4001',
						'tree_name' => 'Category 6-1002',
						'weight' => '2',
						'sort_key' => '~00000001-00000002',
						'child_count' => '2'
					],
				],
				3 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5002',
						'parent_id' => '5004',
						'tree_name' => 'Category 6-1001',
						'weight' => '1',
						'sort_key' => '~00000001-00000002-00000001',
						'child_count' => '1'
					],
				],
				4 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5003',
						'parent_id' => '5002',
						'tree_name' => 'Category 6-1001-1',
						'weight' => '1',
						'sort_key' => '~00000001-00000002-00000001-00000001',
						'child_count' => '0'
					],
				],
				5 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '4002',
						'parent_id' => null,
						'tree_name' => 'Category 7',
						'weight' => '1',
						'sort_key' => '~00000002',
						'child_count' => '1'
					],
				],
				6 => [
					'TestNetCommonsTreeModel2' => [
						'id' => '5005',
						'parent_id' => '4002',
						'tree_name' => 'Category 7-1',
						'weight' => '1',
						'sort_key' => '~00000002-00000001',
						'child_count' => '0'
					],
				],
			]
		];

		return $case;
	}

}
