<?php
/**
 * NetCommonsTreeBehavior::generateTreeList()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::generateTreeList()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorGenerateTreeListTest extends NetCommonsTreeBehaviorCase {

/**
 * generateTreeList()のテスト
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 */
	public function testGenerateTreeList($number) {
		//条件のみ指定
		$arguments = [];
		$arguments['conditions'] = [
			$this->TestModel->alias . '.id' => [
				8, 9, 10, 11, 12, 111, 112, 113, 114, 253, 254, 255, 257, 260, 409
			]
		];
		//$arguments['valuePath'] = '{n}.' . $this->TestModel->alias . '.tree_name';
		$expected = [
			9 => '9',
			8 => '8',
			10 => '10',
			11 => '_11',
			12 => '_12',
			111 => '111',
			112 => '_112',
			113 => '_113',
			114 => '_114',
			253 => '253',
			254 => '_254',
			255 => '__255',
			257 => '___257',
			260 => '___260',
			409 => '409',
		];
		$this->__execAndAssert($arguments, $expected);

		//条件、keyPath、valuePath指定
		$arguments = [];
		$arguments['conditions'] = [
			$this->TestModel->alias . '.id' => [
				8, 9, 10, 11, 12, 111, 112, 113, 114, 253, 254, 255, 257, 260, 409
			]
		];
		$arguments['keyPath'] = '{n}.' . $this->TestModel->alias . '.sort_key';
		$arguments['valuePath'] = '{n}.' . $this->TestModel->alias . '.tree_name';
		$arguments['spacer'] = '> ';
		$expected = [
			'~00000001-00000001-00000001-00000001-00000004' => 'Category 1-1-1-1-5',
			'~00000001-00000001-00000001-00000001-00000005' => 'Category 1-1-1-1-4',
			'~00000001-00000001-00000001-00000002' => 'Category 1-1-1-2',
			'~00000001-00000001-00000001-00000002-00000001' => '> Category 1-1-1-2-1',
			'~00000001-00000001-00000001-00000002-00000002' => '> Category 1-1-1-2-2',
			'~00000001-00000001-00000001-00000003' => 'Category 1-1-1-3',
			'~00000001-00000001-00000001-00000003-00000001' => '> Category 1-1-1-3-1',
			'~00000001-00000001-00000001-00000003-00000002' => '> Category 1-1-1-3-2',
			'~00000001-00000001-00000001-00000003-00000003' => '> Category 1-1-1-3-3',
			'~00000001-00000002' => 'Category 1-2',
			'~00000001-00000002-00000001' => '> Category 1-2-1',
			'~00000001-00000002-00000001-00000001' => '> > Category 1-2-1-1',
			'~00000001-00000002-00000001-00000001-00000002' => '> > > Category 1-2-1-1-2',
			'~00000001-00000002-00000001-00000001-00000005' => '> > > Category 1-2-1-1-5',
			'~00000001-00000003' => 'Category 1-3',
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
			'conditions' => null,
			'keyPath' => null,
			'valuePath' => null,
			'spacer' => '_',
			'recursive' => null,
		], $arguments);

		extract($arguments);

		$this->_debugStart();
		$result = $this->TestModel->generateTreeList($conditions, $keyPath, $valuePath, $spacer, $recursive);
		$this->_debugEnd($arguments);

		$this->assertEquals($expected, $result);
	}

}
