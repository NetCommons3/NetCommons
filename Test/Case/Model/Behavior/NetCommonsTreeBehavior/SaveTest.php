<?php
/**
 * NetCommonsTreeBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorSaveTest extends NetCommonsTreeBehaviorCase {

/**
 * save()前のデータ
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __beforeData() {
		return [
			'1' => [
				'id' => '1',
				'parent_id' => null,
				'tree_name' => 'Category 1',
				'weight' => '1',
				'sort_key' => '~00000001',
				'child_count' => '875',
			],
			'2' => [
				'id' => '2',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '503',
				'tree_name' => 'Category 1-1',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '250',
			],
			'3' => [
				'id' => '3',
				'parent_id' => '2',
				'lft' => '3',
				'rght' => '254',
				'tree_name' => 'Category 1-1-1',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '125',
			],
			'4' => [
				'id' => '4',
				'parent_id' => '3',
				'lft' => '4',
				'rght' => '15',
				'tree_name' => 'Category 1-1-1-1',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001-00000001',
				'child_count' => '5',
			],
			'5' => [
				'id' => '5',
				'parent_id' => '4',
				'lft' => '5',
				'rght' => '6',
				'tree_name' => 'Category 1-1-1-1-1',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001-00000001-00000001',
				'child_count' => '0',
			],
			'6' => [
				'id' => '6',
				'parent_id' => '4',
				'lft' => '7',
				'rght' => '8',
				'tree_name' => 'Category 1-1-1-1-2',
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000001-00000001-00000002',
				'child_count' => '0',
			],
			'10' => [
				'id' => '10',
				'parent_id' => '3',
				'lft' => '16',
				'rght' => '217',
				'tree_name' => 'Category 1-1-1-2',
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000001-00000002',
				'child_count' => '100',
			],
			'11' => [
				'id' => '11',
				'parent_id' => '10',
				'lft' => '17',
				'rght' => '18',
				'tree_name' => 'Category 1-1-1-2-1',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001-00000002-00000001',
				'child_count' => '0',
			],
			'12' => [
				'id' => '12',
				'parent_id' => '10',
				'lft' => '19',
				'rght' => '20',
				'tree_name' => 'Category 1-1-1-2-2',
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000001-00000002-00000002',
				'child_count' => '0',
			],
			'111' => [
				'id' => '111',
				'parent_id' => '3',
				'lft' => '218',
				'rght' => '229',
				'tree_name' => 'Category 1-1-1-3',
				'weight' => '3',
				'sort_key' => '~00000001-00000001-00000001-00000003',
				'child_count' => '5',
			],
			'123' => [
				'id' => '123',
				'parent_id' => '3',
				'lft' => '230',
				'rght' => '241',
				'tree_name' => 'Category 1-1-1-5',
				'weight' => '4',
				'sort_key' => '~00000001-00000001-00000001-00000004',
				'child_count' => '5',
			],
			'117' => [
				'id' => '117',
				'parent_id' => '3',
				'lft' => '242',
				'rght' => '253',
				'tree_name' => 'Category 1-1-1-4',
				'weight' => '5',
				'sort_key' => '~00000001-00000001-00000001-00000005',
				'child_count' => '5',
			],
			'129' => [
				'id' => '129',
				'parent_id' => '2',
				'lft' => '255',
				'rght' => '316',
				'tree_name' => 'Category 1-1-2',
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000002',
				'child_count' => '30',
			],
			'160' => [
				'id' => '160',
				'parent_id' => '2',
				'lft' => '317',
				'rght' => '378',
				'tree_name' => 'Category 1-1-3',
				'weight' => '3',
				'sort_key' => '~00000001-00000001-00000003',
				'child_count' => '30',
			],
			'191' => [
				'id' => '191',
				'parent_id' => '2',
				'lft' => '379',
				'rght' => '440',
				'tree_name' => 'Category 1-1-4',
				'weight' => '4',
				'sort_key' => '~00000001-00000001-00000004',
				'child_count' => '30',
			],
			'222' => [
				'id' => '222',
				'parent_id' => '2',
				'lft' => '441',
				'rght' => '502',
				'tree_name' => 'Category 1-1-5',
				'weight' => '5',
				'sort_key' => '~00000001-00000001-00000005',
				'child_count' => '30',
			],
			'4001' => [
				'id' => '4001',
				'parent_id' => null,
				'lft' => '8001',
				'rght' => '10006',
				'tree_name' => 'Category 6',
				'weight' => '6',
				'sort_key' => '~00000006',
				'child_count' => '1002',
			],
			'5004' => [
				'id' => '5004',
				'parent_id' => null,
				'lft' => '10007',
				'rght' => '10010',
				'tree_name' => 'Category 7',
				'weight' => '7',
				'sort_key' => '~00000007',
				'child_count' => '1',
			],
			'5005' => [
				'id' => '5005',
				'parent_id' => '5004',
				'lft' => '10008',
				'rght' => '10009',
				'tree_name' => 'Category 7-1',
				'weight' => '1',
				'sort_key' => '~00000007-00000001',
				'child_count' => '0',
			],
		];
	}

/**
 * save()テストのDataProvider
 *
 * 一つ上の階層に移動
 *
 * ### 戻り値
 *  - data 登録
 *  - returnExpected saveの戻り値の期待値
 *  - treeConditions treeをチェックする条件
 *  - treeExpected tree構成の期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider0() {
		$beforeData = $this->__beforeData();

		$result[0] = [];
		$result[0]['data'] = [
			'id' => '4',
			'parent_id' => '2',
			'tree_name' => 'Update from Category 1-1-1-1',
		];
		$result[0]['returnExpected'] = [
			'TestNetCommonsTreeModel' => [
				'id' => '4',
				'parent_id' => '2',
				'tree_name' => 'Update from Category 1-1-1-1',
				'weight' => '6',
				'sort_key' => '~00000001-00000001-00000006',
			],
		];
		$result[0]['treeConditions'] = [
			'OR' => [
				'id' => ['2', '4', '5', '6', '11', '12'],
				'parent_id' => ['2', '3']
			]
		];
		$result[0]['treeExpected'] = [
			0 => [
				'TestNetCommonsTreeModel' => $beforeData['2'],
			],
			1 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['3'], [
					'lft' => '3',
					'rght' => '242',
					'sort_key' => '~00000001-00000001-00000001',
					'child_count' => '119',
				]),
			],
			2 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['10'], [
					'lft' => '4',
					'rght' => '205',
					'sort_key' => '~00000001-00000001-00000001-00000001',
					'weight' => '1',
					'child_count' => '100',
				]),
			],
			3 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['11'], [
					'lft' => '5',
					'rght' => '6',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000001',
				]),
			],
			4 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['12'], [
					'lft' => '7',
					'rght' => '8',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000002',
				]),
			],
			5 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['111'], [
					'lft' => '206',
					'rght' => '217',
					'weight' => '2',
					'sort_key' => '~00000001-00000001-00000001-00000002',
				]),
			],
			6 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['123'], [
					'lft' => '218',
					'rght' => '229',
					'weight' => '3',
					'sort_key' => '~00000001-00000001-00000001-00000003',
				]),
			],
			7 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['117'], [
					'lft' => '230',
					'rght' => '241',
					'weight' => '4',
					'sort_key' => '~00000001-00000001-00000001-00000004',
				]),
			],
			8 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['129'], [
					'lft' => '243',
					'rght' => '304',
				]),
			],
			9 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['160'], [
					'lft' => '305',
					'rght' => '366',
				]),
			],
			10 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['191'], [
					'lft' => '367',
					'rght' => '428',
				]),
			],
			11 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['222'], [
					'lft' => '429',
					'rght' => '490',
				]),
			],
			12 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['4'], [
					'parent_id' => '2',
					'lft' => '491',
					'rght' => '502',
					'tree_name' => 'Update from Category 1-1-1-1',
					'weight' => '6',
					'sort_key' => '~00000001-00000001-00000006',
				]),
			],
			13 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['5'], [
					'lft' => '492',
					'rght' => '493',
					'sort_key' => '~00000001-00000001-00000006-00000001',
				]),
			],
			14 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['6'], [
					'lft' => '494',
					'rght' => '495',
					'sort_key' => '~00000001-00000001-00000006-00000002',
				]),
			],
		];

		return $result;
	}

/**
 * save()テストのDataProvider
 *
 * 同階層だったレコードの下に移動
 *
 * ### 戻り値
 *  - data 登録
 *  - returnExpected saveの戻り値の期待値
 *  - treeConditions treeをチェックする条件
 *  - treeExpected tree構成の期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider1() {
		$beforeData = $this->__beforeData();

		$result[1] = [];
		$result[1]['data'] = [
			'id' => '4',
			'parent_id' => '10',
			'tree_name' => 'Update from Category 1-1-1-1',
		];
		$result[1]['returnExpected'] = [
			'TestNetCommonsTreeModel' => [
				'id' => '4',
				'parent_id' => '10',
				'tree_name' => 'Update from Category 1-1-1-1',
				'weight' => '101',
				'sort_key' => '~00000001-00000001-00000001-00000001-00000101',
			],
		];
		$result[1]['treeConditions'] = [
			'OR' => [
				'id' => ['2', '4', '5', '6', '11', '12'],
				'parent_id' => ['2', '3']
			]
		];
		$result[1]['treeExpected'] = [
			0 => [
				'TestNetCommonsTreeModel' => $beforeData['2'],
			],
			1 => [
				'TestNetCommonsTreeModel' => $beforeData['3'],
			],
			2 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['10'], [
					'lft' => '4',
					//'rght' => '217',
					'weight' => '1',
					'sort_key' => '~00000001-00000001-00000001-00000001',
					'child_count' => '106',
				]),
			],
			3 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['11'], [
					'lft' => '5',
					'rght' => '6',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000001',
				]),
			],
			4 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['12'], [
					'lft' => '7',
					'rght' => '8',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000002',
				]),
			],
			5 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['4'], [
					'parent_id' => '10',
					'lft' => '205',
					'rght' => '216',
					'tree_name' => 'Update from Category 1-1-1-1',
					'weight' => '101',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000101',
					//'child_count' => '5',
				]),
			],
			6 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['5'], [
					'parent_id' => '4',
					'lft' => '206',
					'rght' => '207',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000101-00000001',
				]),
			],
			7 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['6'], [
					'lft' => '208',
					'rght' => '209',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000101-00000002',
				]),
			],
			8 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['111'], [
					'weight' => '2',
					'sort_key' => '~00000001-00000001-00000001-00000002',
				]),
			],
			9 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['123'], [
					'weight' => '3',
					'sort_key' => '~00000001-00000001-00000001-00000003',
				]),
			],
			10 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['117'], [
					'weight' => '4',
					'sort_key' => '~00000001-00000001-00000001-00000004',
				]),
			],
			11 => [
				'TestNetCommonsTreeModel' => $beforeData['129'],
			],
			12 => [
				'TestNetCommonsTreeModel' => $beforeData['160'],
			],
			13 => [
				'TestNetCommonsTreeModel' => $beforeData['191'],
			],
			14 => [
				'TestNetCommonsTreeModel' => $beforeData['222'],
			],
		];

		return $result;
	}

/**
 * save()テストのDataProvider
 *
 * ルート移動
 *
 * ### 戻り値
 *  - data 登録
 *  - returnExpected saveの戻り値の期待値
 *  - treeConditions treeをチェックする条件
 *  - treeExpected tree構成の期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider2() {
		$beforeData = $this->__beforeData();

		$result[2] = [];
		$result[2]['data'] = [
			'id' => '4',
			'parent_id' => null,
			'tree_name' => 'Update from Category 1-1-1-1',
		];
		$result[2]['returnExpected'] = [
			'TestNetCommonsTreeModel' => [
				'id' => '4',
				'parent_id' => null,
				'tree_name' => 'Update from Category 1-1-1-1',
				'weight' => '8',
				'sort_key' => '~00000008',
			],
		];
		$result[2]['treeConditions'] = [
			'OR' => [
				'id' => ['1', '2', '4', '5', '6', '11', '12'],
				'parent_id' => ['2', '3']
			]
		];
		$result[2]['treeExpected'] = [
			0 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['1'], [
					'lft' => '1',
					'rght' => '1740',
					'child_count' => '869',
				]),
			],
			1 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['2'], [
					'lft' => '2',
					'rght' => '491',
					'child_count' => '244',
				]),
			],
			2 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['3'], [
					'lft' => '3',
					'rght' => '242',
					'child_count' => '119',
				]),
			],
			3 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['10'], [
					'lft' => '4',
					'rght' => '205',
					'weight' => '1',
					'sort_key' => '~00000001-00000001-00000001-00000001',
				]),
			],
			4 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['11'], [
					'lft' => '5',
					'rght' => '6',
					'weight' => '1',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000001',
				]),
			],
			5 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['12'], [
					'id' => '12',
					'parent_id' => '10',
					'lft' => '7',
					'rght' => '8',
					'weight' => '2',
					'sort_key' => '~00000001-00000001-00000001-00000001-00000002',
				]),
			],
			6 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['111'], [
					'lft' => '206',
					'rght' => '217',
					'weight' => '2',
					'sort_key' => '~00000001-00000001-00000001-00000002',
				]),
			],
			7 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['123'], [
					'lft' => '218',
					'rght' => '229',
					'weight' => '3',
					'sort_key' => '~00000001-00000001-00000001-00000003',
				]),
			],
			8 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['117'], [
					'lft' => '230',
					'rght' => '241',
					'weight' => '4',
					'sort_key' => '~00000001-00000001-00000001-00000004',
				]),
			],
			9 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['129'], [
					'lft' => '243',
					'rght' => '304',
				]),
			],
			10 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['160'], [
					'lft' => '305',
					'rght' => '366',
				]),
			],
			11 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['191'], [
					'lft' => '367',
					'rght' => '428',
				]),
			],
			12 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['222'], [
					'lft' => '429',
					'rght' => '490',
				]),
			],
			13 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['4'], [
					'parent_id' => null,
					'lft' => '9999',
					'rght' => '10010',
					'tree_name' => 'Update from Category 1-1-1-1',
					'weight' => '8',
					'sort_key' => '~00000008',
				]),
			],
			14 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['5'], [
					'parent_id' => '4',
					'lft' => '10000',
					'rght' => '10001',
					'tree_name' => 'Category 1-1-1-1-1',
					'sort_key' => '~00000008-00000001',
				]),
			],
			15 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['6'], [
					'parent_id' => '4',
					'lft' => '10002',
					'rght' => '10003',
					'tree_name' => 'Category 1-1-1-1-2',
					'sort_key' => '~00000008-00000002',
				]),
			],
		];

		return $result;
	}

/**
 * save()テストのDataProvider
 *
 * 同階層に大量データがある場合の新規追加
 *
 * ### 戻り値
 *  - data 登録
 *  - returnExpected saveの戻り値の期待値
 *  - treeConditions treeをチェックする条件
 *  - treeExpected tree構成の期待値
 *
 * @return array データ
 */
	public function dataProvider3() {
		$beforeData = $this->__beforeData();

		$result[3] = [];
		$result[3]['data'] = [
			'id' => null,
			'parent_id' => '4001',
			'tree_name' => 'New Category',
		];
		$result[3]['returnExpected'] = [
			'TestNetCommonsTreeModel' => [
				'id' => '5006',
				'parent_id' => '4001',
				'tree_name' => 'New Category',
				'lft' => '10006',
				'rght' => '10007',
				'weight' => '1003',
				'sort_key' => '~00000006-00001003',
				'child_count' => '0',
			],
		];
		$result[3]['treeConditions'] = [
			'OR' => [
				'id' => ['4001', '5004', '5005', '5006'],
			]
		];
		$result[3]['treeExpected'] = [
			0 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['4001'], [
					'lft' => '8001',
					'rght' => '10008',
					'child_count' => '1003',
				]),
			],
			1 => [
				'TestNetCommonsTreeModel' => [
					'id' => '5006',
					'parent_id' => '4001',
					'lft' => '10006',
					'rght' => '10007',
					'tree_name' => 'New Category',
					'weight' => '1003',
					'sort_key' => '~00000006-00001003',
					'child_count' => '0',
				],
			],
			2 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['5004'], [
					'lft' => '10009',
					'rght' => '10012',
				]),
			],
			3 => [
				'TestNetCommonsTreeModel' => array_merge($beforeData['5005'], [
					'lft' => '10010',
					'rght' => '10011',
				]),
			],
		];

		return $result;
	}

/**
 * save()のテスト
 *
 * @param array $data 登録
 * @param array $returnExpected saveの戻り値の期待値
 * @param array $treeConditions treeをチェックする条件
 * @param array $treeExpected tree構成の期待値
 * @dataProvider dataProvider0
 * @dataProvider dataProvider1
 * @dataProvider dataProvider2
 * @dataProvider dataProvider3
 * @return void
 */
	public function testSave($data, $returnExpected, $treeConditions, $treeExpected) {
		$returnExpected = $this->_removeUnnecessaryFields($returnExpected);
		$treeExpected = $this->_removeUnnecessaryFields($treeExpected);

		//テスト実施
		$this->TestModel->create(false);

		$this->_debugStart();
		$result = $this->TestModel->save($data);
		$this->_debugEnd(['data' => $data]);

		$this->assertEquals($returnExpected, $result);

		if ($this->TestModel->Behaviors->loaded('NetCommons.NetCommonsTree')) {
			$order = 'sort_key asc';
		} else {
			$order = 'lft asc';
		}
		$result = $this->TestModel->find('all', [
			'recursive' => -1,
			'conditions' => $treeConditions,
			'order' => $order,
		]);
		$result = $this->_removeUnnecessaryFields($result);

		$this->assertEquals($treeExpected, $result);
	}

/**
 * 計測用
 *
 * @param array $data 登録
 * @param array $returnExpected saveの戻り値の期待値
 * @param array $treeConditions treeをチェックする条件
 * @param array $treeExpected tree構成の期待値
 * @dataProvider dataProvider0
 * @dataProvider dataProvider1
 * @dataProvider dataProvider2
 * @dataProvider dataProvider3
 * @return void
 */
	public function testSave2($data, $returnExpected, $treeConditions, $treeExpected) {
		if (self:: MEASUREMENT_NUMBER >= 2) {
			$this->testSave($data, $returnExpected, $treeConditions, $treeExpected);
		}
	}

/**
 * 計測用
 *
 * @param array $data 登録
 * @param array $returnExpected saveの戻り値の期待値
 * @param array $treeConditions treeをチェックする条件
 * @param array $treeExpected tree構成の期待値
 * @dataProvider dataProvider0
 * @dataProvider dataProvider1
 * @dataProvider dataProvider2
 * @dataProvider dataProvider3
 * @return void
 */
	public function testSave3($data, $returnExpected, $treeConditions, $treeExpected) {
		if (self:: MEASUREMENT_NUMBER >= 3) {
			$this->testSave($data, $returnExpected, $treeConditions, $treeExpected);
		}
	}

/**
 * 計測用
 *
 * @param array $data 登録
 * @param array $returnExpected saveの戻り値の期待値
 * @param array $treeConditions treeをチェックする条件
 * @param array $treeExpected tree構成の期待値
 * @dataProvider dataProvider0
 * @dataProvider dataProvider1
 * @dataProvider dataProvider2
 * @dataProvider dataProvider3
 * @return void
 */
	public function testSave4($data, $returnExpected, $treeConditions, $treeExpected) {
		if (self:: MEASUREMENT_NUMBER >= 4) {
			$this->testSave($data, $returnExpected, $treeConditions, $treeExpected);
		}
	}

/**
 * 計測用
 *
 * @param array $data 登録
 * @param array $returnExpected saveの戻り値の期待値
 * @param array $treeConditions treeをチェックする条件
 * @param array $treeExpected tree構成の期待値
 * @dataProvider dataProvider0
 * @dataProvider dataProvider1
 * @dataProvider dataProvider2
 * @dataProvider dataProvider3
 * @return void
 */
	public function testSave5($data, $returnExpected, $treeConditions, $treeExpected) {
		if (self:: MEASUREMENT_NUMBER >= 5) {
			$this->testSave($data, $returnExpected, $treeConditions, $treeExpected);
		}
	}

}
