<?php
/**
 * NetCommonsTreeBehavior::getLevel()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::getLevel()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorGetLevelTest extends NetCommonsTreeBehaviorCase {

/**
 * getLevel()のテスト
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 */
	public function testGetLevel($number) {
		$arguments = [];

		//ルートのID
		$arguments['id'] = '1';
		$expected = 0;
		$this->__execAndAssert($arguments, $expected);

		$arguments['id'] = '877';
		$expected = 0;
		$this->__execAndAssert($arguments, $expected);

		//子のID
		$arguments['id'] = '2';
		$expected = 1;
		$this->__execAndAssert($arguments, $expected);

		//最下層のID
		$arguments['id'] = '9';
		$expected = 4;
		$this->__execAndAssert($arguments, $expected);

		$arguments['id'] = '8';
		$expected = 4;
		$this->__execAndAssert($arguments, $expected);

		//Model->idにセットした場合
		$this->TestModel->id = '10';
		$arguments['id'] = null;
		$expected = 3;
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
		], $arguments);

		extract($arguments);

		$this->_debugStart();
		$result = $this->TestModel->getLevel($id);
		$this->_debugEnd($arguments);

		$this->assertEquals($expected, $result);
	}

}
