<?php
/**
 * NetCommonsTreeBehavior::getParentNode()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::getParentNode()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorGetParentNodeTest extends NetCommonsTreeBehaviorCase {

/**
 * getParentNode()のテスト
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 */
	public function testGetParentNode($number) {
		//IDのみ指定
		$arguments = [];
		$arguments['id'] = '10';
		$expected = [
			'TestNetCommonsTreeModel' => [
				'id' => '3',
				'parent_id' => '2',
				'lft' => '3',
				'rght' => '254',
				'sort_key' => '~00000001-00000001-00000001',
				'tree_name' => 'Category 1-1-1',
				'weight' => '1',
				'child_count' => '125',
			],
		];
		$this->__execAndAssert($arguments, $expected);

		//ルートのIDを指定
		$arguments = [];
		$arguments['id'] = '1';
		$expected = [];
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
			'TestNetCommonsTreeModel' => [
				'id' => '3',
				'tree_name' => 'Category 1-1-1',
			],
			'ParentTestNetCommonsTreeModel' => [
				'id' => '2',
				'tree_name' => 'Category 1-1',
			],
		];
		$this->__execAndAssert($arguments, $expected);

		//存在しないIDを指定
		$arguments = [];
		$arguments['id'] = '9999999';
		$expected = false;
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
		$result = $this->TestModel->getParentNode($id, $fields, $recursive);
		$this->_debugEnd($arguments);

		$result = $this->_removeUnnecessaryFields($result);

		$this->assertEquals($expected, $result);
	}

}
