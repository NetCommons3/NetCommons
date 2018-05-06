<?php
/**
 * NetCommonsTreeBehavior::children()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::children()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorChildrenTest extends NetCommonsTreeBehaviorCase {

/**
 * children()のテスト
 *
 * - $id 検索するためのレコードのID
 * - $direct 直下のノードのみを返すために true を設定します
 * - $fields 戻り値に含まれるフィールド名の文字列またはフィールドの配列
 * - $order ORDER BY の SQL 文字列
 * - $limit SQL の LIMIT 構文
 * - $page ページつけられた結果にアクセスするための引数
 * - $recursive 再帰的に関連付けられたモデルの深さのレベル数
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function testChildren($number) {
		//全表示
		// - (下位全て)
		$arguments = [];
		$arguments['direct'] = false;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '1', 'parent_id' => null,
					'lft' => '1', 'rght' => '1752',
					'tree_name' => 'Category 1',
					'weight' => '1', 'sort_key' => '~00000001', 'child_count' => '875',
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '2', 'parent_id' => '1',
					'lft' => '2', 'rght' => '503',
					'tree_name' => 'Category 1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001', 'child_count' => '250',
				],
			],
			2 => [
				$this->TestModel->alias => [
					'id' => '3', 'parent_id' => '2',
					'lft' => '3', 'rght' => '254',
					'tree_name' => 'Category 1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001', 'child_count' => '125',
				],
			],
			3 => [
				$this->TestModel->alias => [
					'id' => '4', 'parent_id' => '3',
					'lft' => '4', 'rght' => '15',
					'tree_name' => 'Category 1-1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001-00000001', 'child_count' => '5'
				],
			],
			7 => [
				$this->TestModel->alias => [
				'id' => '9', 'parent_id' => '4',
					'lft' => '11', 'rght' => '12',
					'tree_name' => 'Category 1-1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000001-00000004', 'child_count' => '0'
				],
			],
			8 => [
				$this->TestModel->alias => [
					'id' => '8', 'parent_id' => '4',
					'lft' => '13', 'rght' => '14',
					'tree_name' => 'Category 1-1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000001-00000005', 'child_count' => '0'
				],
			],
			116 => [
				$this->TestModel->alias => [
					'id' => '123', 'parent_id' => '3',
					'lft' => '230', 'rght' => '241',
					'tree_name' => 'Category 1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000004', 'child_count' => '5'
				],
			],
			122 => [
				$this->TestModel->alias => [
					'id' => '117', 'parent_id' => '3',
					'lft' => '242', 'rght' => '253',
					'tree_name' => 'Category 1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000005', 'child_count' => '5'
				],
			],
			252 => [
				$this->TestModel->alias => [
					'id' => '253', 'parent_id' => '1',
					'lft' => '504', 'rght' => '815',
					'tree_name' => 'Category 1-2',
					'weight' => '2', 'sort_key' => '~00000001-00000002', 'child_count' => '155'
				],
			],
			876 => [
				$this->TestModel->alias => [
					'id' => '877', 'parent_id' => null,
					'lft' => '1753', 'rght' => '3314',
					'tree_name' => 'Category 2',
					'weight' => '2', 'sort_key' => '~00000002', 'child_count' => '780'
				],
			],
			877 => [
				$this->TestModel->alias => [
					'id' => '878', 'parent_id' => '877',
					'lft' => '1754', 'rght' => '2065',
					'tree_name' => 'Category 2-1',
					'weight' => '1', 'sort_key' => '~00000002-00000001', 'child_count' => '155'
				],
			],
			1657 => [
				$this->TestModel->alias => [
					'id' => '2439', 'parent_id' => null,
					'lft' => '3315', 'rght' => '4876',
					'tree_name' => 'Category 4',
					'weight' => '3', 'sort_key' => '~00000003', 'child_count' => '780'
				],
			],
			2438 => [
				$this->TestModel->alias => [
					'id' => '1658', 'parent_id' => null,
					'lft' => '4877', 'rght' => '6438',
					'tree_name' => 'Category 3',
					'weight' => '4', 'sort_key' => '~00000004', 'child_count' => '780'
				],
			],
			3218 => [
				$this->TestModel->alias => [
					'id' => '2438', 'parent_id' => '2433',
					'lft' => '6433', 'rght' => '6434',
					'tree_name' => 'Category 3-5-5-5-5',
					'weight' => '5', 'sort_key' => '~00000004-00000005-00000005-00000005-00000005', 'child_count' => '0'
				],
			],
		];
		$expectedCount = 5005;
		$this->__execAndAssert($arguments, $expected, $expectedCount);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '1', 'parent_id' => null,
					'lft' => '1', 'rght' => '1752',
					'tree_name' => 'Category 1',
					'weight' => '1', 'sort_key' => '~00000001', 'child_count' => '875',
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '877', 'parent_id' => null,
					'lft' => '1753', 'rght' => '3314',
					'tree_name' => 'Category 2',
					'weight' => '2', 'sort_key' => '~00000002', 'child_count' => '780'
				],
			],
			2 => [
				$this->TestModel->alias => [
					'id' => '2439', 'parent_id' => null,
					'lft' => '3315', 'rght' => '4876',
					'tree_name' => 'Category 4',
					'weight' => '3', 'sort_key' => '~00000003', 'child_count' => '780'
				],
			],
			3 => [
				$this->TestModel->alias => [
					'id' => '1658', 'parent_id' => null,
					'lft' => '4877', 'rght' => '6438',
					'tree_name' => 'Category 3',
					'weight' => '4', 'sort_key' => '~00000004', 'child_count' => '780'
				],
			],
			4 => [
				$this->TestModel->alias => [
					'id' => '3220', 'parent_id' => null,
					'lft' => '6439', 'rght' => '8000',
					'tree_name' => 'Category 5',
					'weight' => '5', 'sort_key' => '~00000005', 'child_count' => '780'
				],
			],
			5 => [
				$this->TestModel->alias => [
					'id' => '4001', 'parent_id' => null,
					'lft' => '8001', 'rght' => '10006',
					'tree_name' => 'Category 6',
					'weight' => '6', 'sort_key' => '~00000006', 'child_count' => '1002'
				],
			],
			6 => [
				$this->TestModel->alias => [
					'id' => '5004', 'parent_id' => null,
					'lft' => '10007', 'rght' => '10010',
					'tree_name' => 'Category 7',
					'weight' => '7', 'sort_key' => '~00000007', 'child_count' => '1'
				],
			],
		];
		$expectedCount = 7;
		$this->__execAndAssert($arguments, $expected, $expectedCount);

		//親ID指定
		$arguments = [];
		$arguments['id'] = '2';
		$arguments['fields'] = [
			$this->TestModel->alias . '.*',
			$this->TestModel->ParentTestNetCommonsTreeModel->alias . '.id'
		];
		$arguments['recursive'] = 0;
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '3', 'parent_id' => '2',
					'lft' => '3', 'rght' => '254',
					'tree_name' => 'Category 1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001', 'child_count' => '125',
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '2'
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '4', 'parent_id' => '3',
					'lft' => '4', 'rght' => '15',
					'tree_name' => 'Category 1-1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001-00000001', 'child_count' => '5'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '3'
				],
			],
			5 => [
				$this->TestModel->alias => [
					'id' => '9', 'parent_id' => '4',
					'lft' => '11', 'rght' => '12',
					'tree_name' => 'Category 1-1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000001-00000004', 'child_count' => '0'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '4'
				],
			],
			6 => [
				$this->TestModel->alias => [
					'id' => '8', 'parent_id' => '4',
					'lft' => '13', 'rght' => '14',
					'tree_name' => 'Category 1-1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000001-00000005', 'child_count' => '0'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '4'
				],
			],
			114 => [
				$this->TestModel->alias => [
					'id' => '123', 'parent_id' => '3',
					'lft' => '230', 'rght' => '241',
					'tree_name' => 'Category 1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000004', 'child_count' => '5'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '3'
				],
			],
			120 => [
				$this->TestModel->alias => [
					'id' => '117', 'parent_id' => '3',
					'lft' => '242', 'rght' => '253',
					'tree_name' => 'Category 1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000005', 'child_count' => '5'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '3'
				],
			],
			126 => [
				$this->TestModel->alias => [
					'id' => '129', 'parent_id' => '2',
					'lft' => '255', 'rght' => '316',
					'tree_name' => 'Category 1-1-2',
					'weight' => '2', 'sort_key' => '~00000001-00000001-00000002', 'child_count' => '30',
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => '2'
				],
			],
		];
		$expectedCount = 250;
		$this->__execAndAssert($arguments, $expected, $expectedCount);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '3', 'parent_id' => '2',
					'lft' => '3', 'rght' => '254',
					'tree_name' => 'Category 1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001', 'child_count' => '125',
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => $arguments['id']
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '129', 'parent_id' => '2',
					'lft' => '255', 'rght' => '316',
					'tree_name' => 'Category 1-1-2',
					'weight' => '2', 'sort_key' => '~00000001-00000001-00000002', 'child_count' => '30',
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => $arguments['id']
				],
			],
			2 => [
				$this->TestModel->alias => [
					'id' => '160', 'parent_id' => '2',
					'lft' => '317', 'rght' => '378',
					'tree_name' => 'Category 1-1-3',
					'weight' => '3', 'sort_key' => '~00000001-00000001-00000003', 'child_count' => '30'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => $arguments['id']
				],
			],
			3 => [
				$this->TestModel->alias => [
					'id' => '191', 'parent_id' => '2',
					'lft' => '379', 'rght' => '440',
					'tree_name' => 'Category 1-1-4',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000004', 'child_count' => '30'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => $arguments['id']
				],
			],
			4 => [
				$this->TestModel->alias => [
					'id' => '222', 'parent_id' => $arguments['id'],
					'lft' => '441', 'rght' => '502',
					'tree_name' => 'Category 1-1-5',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000005', 'child_count' => '30'
				],
				$this->TestModel->ParentTestNetCommonsTreeModel->alias => [
					'id' => $arguments['id']
				],
			],
		];
		$expectedCount = 5;
		$this->__execAndAssert($arguments, $expected, $expectedCount);

		//孫ID指定
		$arguments = [];
		$arguments['id'] = '3';
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '4', 'parent_id' => '3',
					'lft' => '4', 'rght' => '15',
					'tree_name' => 'Category 1-1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001-00000001', 'child_count' => '5'
				],
			],
			4 => [
				$this->TestModel->alias => [
					'id' => '9', 'parent_id' => '4',
					'lft' => '11', 'rght' => '12',
					'tree_name' => 'Category 1-1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000001-00000004', 'child_count' => '0'
				],
			],
			5 => [
				$this->TestModel->alias => [
					'id' => '8', 'parent_id' => '4',
					'lft' => '13', 'rght' => '14',
					'tree_name' => 'Category 1-1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000001-00000005', 'child_count' => '0'
				],
			],
			6 => [
				$this->TestModel->alias => [
					'id' => '10', 'parent_id' => '3',
					'lft' => '16', 'rght' => '217',
					'tree_name' => 'Category 1-1-1-2',
					'weight' => '2', 'sort_key' => '~00000001-00000001-00000001-00000002', 'child_count' => '100'
				],
			],
			107 => [
				$this->TestModel->alias => [
					'id' => '111', 'parent_id' => '3',
					'lft' => '218', 'rght' => '229',
					'tree_name' => 'Category 1-1-1-3',
					'weight' => '3', 'sort_key' => '~00000001-00000001-00000001-00000003', 'child_count' => '5'
				],
			],
			113 => [
				$this->TestModel->alias => [
					'id' => '123', 'parent_id' => '3',
					'lft' => '230', 'rght' => '241',
					'tree_name' => 'Category 1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000004', 'child_count' => '5'
				],
			],
			119 => [
				$this->TestModel->alias => [
					'id' => '117', 'parent_id' => '3',
					'lft' => '242', 'rght' => '253',
					'tree_name' => 'Category 1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000005', 'child_count' => '5'
				],
			],
		];
		$expectedCount = 125;
		$this->__execAndAssert($arguments, $expected, $expectedCount);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '4', 'parent_id' => '3',
					'lft' => '4', 'rght' => '15',
					'tree_name' => 'Category 1-1-1-1',
					'weight' => '1', 'sort_key' => '~00000001-00000001-00000001-00000001', 'child_count' => '5'
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '10', 'parent_id' => '3',
					'lft' => '16', 'rght' => '217',
					'tree_name' => 'Category 1-1-1-2',
					'weight' => '2', 'sort_key' => '~00000001-00000001-00000001-00000002', 'child_count' => '100'
				],
			],
			2 => [
				$this->TestModel->alias => [
					'id' => '111', 'parent_id' => '3',
					'lft' => '218', 'rght' => '229',
					'tree_name' => 'Category 1-1-1-3',
					'weight' => '3', 'sort_key' => '~00000001-00000001-00000001-00000003', 'child_count' => '5'
				],
			],
			3 => [
				$this->TestModel->alias => [
					'id' => '123', 'parent_id' => '3',
					'lft' => '230', 'rght' => '241',
					'tree_name' => 'Category 1-1-1-5',
					'weight' => '4', 'sort_key' => '~00000001-00000001-00000001-00000004', 'child_count' => '5'
				],
			],
			4 => [
				$this->TestModel->alias => [
					'id' => '117', 'parent_id' => '3',
					'lft' => '242', 'rght' => '253',
					'tree_name' => 'Category 1-1-1-4',
					'weight' => '5', 'sort_key' => '~00000001-00000001-00000001-00000005', 'child_count' => '5'
				],
			],
		];
		$expectedCount = 5;
		$this->__execAndAssert($arguments, $expected, $expectedCount);

		//大量データの親ID指定
		$arguments = [];
		$arguments['id'] = '4001';
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '4002', 'parent_id' => '4001',
					'lft' => '8002', 'rght' => '8003',
					'tree_name' => 'Category 6-1',
					'weight' => '1', 'sort_key' => '~00000006-00000001', 'child_count' => '0'
				],
			],
		];
		$expectedCount = 1002;
		$this->__execAndAssert($arguments, $expected, $expectedCount);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '4002', 'parent_id' => '4001',
					'lft' => '8002', 'rght' => '8003',
					'tree_name' => 'Category 6-1',
					'weight' => '1', 'sort_key' => '~00000006-00000001', 'child_count' => '0'
				],
			],
		];
		$expectedCount = 1002;
		$this->__execAndAssert($arguments, $expected, $expectedCount);
	}

/**
 * チェック
 *
 * @param array $arguments メソッド引数とするデータ。extractで変数にする
 * @param array $expected 期待値
 * @param int $expectedCount 取得件数の期待値
 * @return void
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
	private function __execAndAssert($arguments, $expected, $expectedCount) {
		$arguments = array_merge([
			'id' => null,
			'fields' => null,
			'order' => null,
			'limit' => null,
			'page' => 1,
			'recursive' => null,
		], $arguments);

		extract($arguments);
		$expected = $this->_removeUnnecessaryFields($expected);

		$this->_debugStart();
		$result = $this->TestModel->children($id, $direct, $fields, $order, $limit, $page, $recursive);
		$this->_debugEnd($arguments);

		$this->assertEquals($expectedCount, count($result));

		$actual = [];
		foreach (array_keys($expected) as $i) {
			$actual[$i] = $this->_removeUnnecessaryFields($result[$i]);
		}

		$this->assertEquals($expected, $actual);
	}

}
