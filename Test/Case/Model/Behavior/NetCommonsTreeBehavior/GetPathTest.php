<?php
/**
 * NetCommonsTreeBehavior::getPath()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::getPath()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorGetPathTest extends NetCommonsTreeBehaviorCase {

/**
 * getPath()のテスト
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function testGetPath($number) {
		//IDのみ指定
		$arguments = [];
		$arguments['id'] = '10';
		$expected = [
			0 => [
				'TestNetCommonsTreeModel' => [
					'id' => '1',
					'parent_id' => null,
					'lft' => '1',
					'rght' => '1752',
					'tree_name' => 'Category 1',
					'weight' => '1',
					'sort_key' => '~00000001',
					'child_count' => '875',
				],
			],
			1 => [
				'TestNetCommonsTreeModel' => [
					'id' => '2',
					'parent_id' => '1',
					'lft' => '2',
					'rght' => '503',
					'tree_name' => 'Category 1-1',
					'weight' => '1',
					'sort_key' => '~00000001-00000001',
					'child_count' => '250',
				],
			],
			2 => [
				'TestNetCommonsTreeModel' => [
					'id' => '3',
					'parent_id' => '2',
					'lft' => '3',
					'rght' => '254',
					'tree_name' => 'Category 1-1-1',
					'weight' => '1',
					'sort_key' => '~00000001-00000001-00000001',
					'child_count' => '125',
				],
			],
			3 => [
				'TestNetCommonsTreeModel' => [
					'id' => '10',
					'parent_id' => '3',
					'lft' => '16',
					'rght' => '217',
					'tree_name' => 'Category 1-1-1-2',
					'weight' => '2',
					'sort_key' => '~00000001-00000001-00000001-00000002',
					'child_count' => '100',
				],
			],
		];
		$this->__execAndAssert($arguments, $expected);

		//ルートのIDを指定
		$arguments = [];
		$arguments['id'] = '1';
		$expected = [
			0 => [
				'TestNetCommonsTreeModel' => [
					'id' => '1',
					'parent_id' => null,
					'lft' => '1',
					'rght' => '1752',
					'tree_name' => 'Category 1',
					'weight' => '1',
					'sort_key' => '~00000001',
					'child_count' => '875',
				],
			],
		];
		$this->__execAndAssert($arguments, $expected);

		//fieldsとrecursiveを指定
		$arguments['id'] = '10';
		$arguments['fields'] = [
			'TestNetCommonsTreeModel.id',
			'TestNetCommonsTreeModel.tree_name',
			'ParentTestNetCommonsTreeModel.id',
			'ParentTestNetCommonsTreeModel.tree_name',
		];
		$arguments['recursive'] = 0;
		$expected = [
			0 => [
				'TestNetCommonsTreeModel' => [
					'id' => '1',
					'tree_name' => 'Category 1',
				],
				'ParentTestNetCommonsTreeModel' => [
					'id' => null,
					'tree_name' => null,
				],
			],
			1 => [
				'TestNetCommonsTreeModel' => [
					'id' => '2',
					'tree_name' => 'Category 1-1',
				],
				'ParentTestNetCommonsTreeModel' => [
					'id' => '1',
					'tree_name' => 'Category 1',
				],
			],
			2 => [
				'TestNetCommonsTreeModel' => [
					'id' => '3',
					'tree_name' => 'Category 1-1-1',
				],
				'ParentTestNetCommonsTreeModel' => [
					'id' => '2',
					'tree_name' => 'Category 1-1',
				],
			],
			3 => [
				'TestNetCommonsTreeModel' => [
					'id' => '10',
					'tree_name' => 'Category 1-1-1-2',
				],
				'ParentTestNetCommonsTreeModel' => [
					'id' => '3',
					'tree_name' => 'Category 1-1-1',
				],
			],
		];
		$this->__execAndAssert($arguments, $expected);

		//存在しないIDを指定
		$arguments = [];
		$arguments['id'] = '9999999';
		$expected = [];
		$this->__execAndAssert($arguments, $expected);

		//同じ親IDを持つデータが大量にあるIDのみ指定
		$arguments = [];
		$arguments['id'] = '4990';
		$expected = [
			0 => [
				'TestNetCommonsTreeModel' => [
					'id' => '4001',
					'parent_id' => null,
					'lft' => '8001',
					'rght' => '10006',
					'tree_name' => 'Category 6',
					'weight' => '6',
					'sort_key' => '~00000006',
					'child_count' => '1002',
				],
			],
			1 => [
				'TestNetCommonsTreeModel' => [
					'id' => '4990',
					'parent_id' => '4001',
					'lft' => '9978',
					'rght' => '9979',
					'tree_name' => 'Category 6-989',
					'weight' => '989',
					'sort_key' => '~00000006-00000989',
					'child_count' => '0'
				],
			],
		];
		$this->__execAndAssert($arguments, $expected);
	}

/**
 * チェック
 *
 * @param array $arguments メソッド引数とするデータ。extractで変数にする
 * @param array $expected 期待値
 * @return void
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
	private function __execAndAssert($arguments, $expected) {
		$arguments = array_merge([
			'id' => null,
			'fields' => null,
			'recursive' => null,
		], $arguments);

		extract($arguments);

		$expected = $this->_removeUnnecessaryFields($expected);

		$this->_debugStart();
		$result = $this->TestModel->getPath($id, $fields, $recursive);
		$this->_debugEnd($arguments);

		$result = $this->_removeUnnecessaryFields($result);

		$this->assertEquals($expected, $result);
	}

}
