<?php
/**
 * NetCommonsTreeBehavior::childCount()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::childCount()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorChildCountTest extends NetCommonsTreeBehaviorCase {

/**
 * childCount()のテスト
 *
 * @param int $number インデックス
 * @return void
 * @dataProvider dataProvider
 */
	public function testChildCount($number) {
		//トップ
		$arguments = [];
		$arguments['id'] = null;
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = 5005;
		$this->__execAndAssert($arguments, $expected);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = 7;
		$this->__execAndAssert($arguments, $expected);

		//孫ID指定
		$arguments = [];
		$arguments['id'] = '3';
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = 125;
		$this->__execAndAssert($arguments, $expected);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = 5;
		$this->__execAndAssert($arguments, $expected);

		//下位がないID
		$arguments = [];
		$arguments['id'] = '6';
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = 0;
		$this->__execAndAssert($arguments, $expected);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = 0;
		$this->__execAndAssert($arguments, $expected);

		//$this->idがある場合
		$arguments = [];
		$arguments['id'] = '9999';
		$this->TestModel->id = $arguments['id'];
		$this->TestModel->data[$this->TestModel->alias]['child_count'] = 30;
		$this->TestModel->data[$this->TestModel->alias]['lft'] = 3; //CakeTreeBehavorとの比較のため
		$this->TestModel->data[$this->TestModel->alias]['rght'] = 64; //CakeTreeBehavorとの比較のため
		// - (下位全て)
		$arguments['direct'] = false;
		$expected = 30;
		$this->__execAndAssert($arguments, $expected);
		// - (直下のみ)
		$arguments['direct'] = true;
		$expected = 0;
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
			'recursive' => null,
		], $arguments);

		extract($arguments);

		$this->_debugStart();
		$result = $this->TestModel->childCount($id, $direct);
		$this->_debugEnd($arguments);

		$this->assertEquals($expected, $result);
	}

}
