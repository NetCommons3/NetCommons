<?php
/**
 * NetCommonsTreeBehavior::moveUp()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::moveUp()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorMoveUpTest extends NetCommonsTreeBehaviorCase {

/**
 * moveUp()テストのDataProvider
 *
 * ### 戻り値
 *  - id 移動するレコードのID
 *  - number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 *  - parentId 親ID
 *  - expected 期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider() {
		$result[0] = [];
		$result[0]['id'] = '7';
		$result[0]['number'] = 1;
		$result[0]['parentId'] = '4';
		$result[0]['expected'] = [
			4 => '4',
			5 => '_5',
			7 => '_7',
			6 => '_6',
			9 => '_9',
			8 => '_8',
		];

		$result[1] = [];
		$result[1]['id'] = '7';
		$result[1]['number'] = 10;
		$result[1]['parentId'] = '4';
		$result[1]['expected'] = [
			4 => '4',
			7 => '_7',
			5 => '_5',
			6 => '_6',
			9 => '_9',
			8 => '_8',
		];

		$result[2] = [];
		$result[2]['id'] = '111';
		$result[2]['number'] = 1;
		$result[2]['parentId'] = ['3', '4', '111'];
		$result[2]['expected'] = [
			3 => '3',
			4 => '_4',
			5 => '__5',
			6 => '__6',
			7 => '__7',
			9 => '__9',
			8 => '__8',
			111 => '_111',
			112 => '__112',
			113 => '__113',
			114 => '__114',
			115 => '__115',
			116 => '__116',
			10 => '_10',
			123 => '_123',
			117 => '_117',
		];

		$result[3] = [];
		$result[3]['id'] = '5004';
		$result[3]['number'] = 5;
		$result[3]['parentId'] = [null, '1', '2', '3', '877', '878', '879', '1658', '1659', '1660', '5004', '5005'];
		$result[3]['expected'] = [
			1 => '1',
			2 => '_2',
			3 => '__3',
			4 => '___4',
			10 => '___10',
			111 => '___111',
			123 => '___123',
			117 => '___117',
			129 => '__129',
			160 => '__160',
			191 => '__191',
			222 => '__222',
			253 => '_253',
			409 => '_409',
			565 => '_565',
			721 => '_721',
			5004 => '5004',
			5005 => '_5005',
			877 => '877',
			878 => '_878',
			879 => '__879',
			880 => '___880',
			886 => '___886',
			892 => '___892',
			898 => '___898',
			904 => '___904',
			910 => '__910',
			941 => '__941',
			972 => '__972',
			1003 => '__1003',
			1034 => '_1034',
			1190 => '_1190',
			1346 => '_1346',
			1502 => '_1502',
			1658 => '1658',
			1659 => '_1659',
			1660 => '__1660',
			1661 => '___1661',
			1667 => '___1667',
			1673 => '___1673',
			1679 => '___1679',
			1685 => '___1685',
			1691 => '__1691',
			1722 => '__1722',
			1753 => '__1753',
			1784 => '__1784',
			1815 => '_1815',
			1971 => '_1971',
			2127 => '_2127',
			2283 => '_2283',
		];

		$result[4] = [];
		$result[4]['id'] = '4001';
		$result[4]['number'] = 1;
		$result[4]['parentId'] = null;
		$result[4]['expected'] = [
			1 => '1',
			877 => '877',
			2439 => '2439',
			1658 => '1658',
			4001 => '4001',
			3220 => '3220',
			5004 => '5004',
		];

		$result[5] = [];
		$result[5]['id'] = '123';
		$result[5]['number'] = true;
		$result[5]['parentId'] = ['3', '4'];
		$result[5]['expected'] = [
			3 => '3',
			123 => '_123',
			4 => '_4',
			5 => '__5',
			6 => '__6',
			7 => '__7',
			9 => '__9',
			8 => '__8',
			10 => '_10',
			111 => '_111',
			117 => '_117',
		];

		return $result;
	}

/**
 * moveUp()のテスト
 *
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @param string|int $parentId 親ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
	public function testMoveDown($id, $number, $parentId, $expected) {
		//テスト実施
		$arguments = [];
		$arguments['id'] = $id;
		$arguments['number'] = $number;

		extract($arguments);

		$this->_debugStart();
		$result = $this->TestModel->moveUp($id, $number);
		$this->_debugEnd($arguments);

		$this->assertTrue($result);

		$result = $this->TestModel->generateTreeList([
			'OR' => [
				$this->TestModel->alias . '.id' => $parentId,
				$this->TestModel->alias . '.parent_id' => $parentId,
			]
		]);

		//順番が入れ替わっても正常となってしまうため、Jsonで比較する
		$this->assertEquals(json_encode($expected), json_encode($result));
	}

/**
 * 計測用
 *
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @param string|int $parentId 親ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testMoveDown2($id, $number, $parentId, $expected) {
		if (self:: MEASUREMENT_NUMBER >= 2) {
			$this->testMoveDown($id, $number, $parentId, $expected);
		}
	}

/**
 * 計測用
 *
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @param string|int $parentId 親ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testMoveDown3($id, $number, $parentId, $expected) {
		if (self:: MEASUREMENT_NUMBER >= 3) {
			$this->testMoveDown($id, $number, $parentId, $expected);
		}
	}

/**
 * 計測用
 *
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @param string|int $parentId 親ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testMoveDown4($id, $number, $parentId, $expected) {
		if (self:: MEASUREMENT_NUMBER >= 4) {
			$this->testMoveDown($id, $number, $parentId, $expected);
		}
	}

/**
 * 計測用
 *
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @param string|int $parentId 親ID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testMoveDown5($id, $number, $parentId, $expected) {
		if (self:: MEASUREMENT_NUMBER >= 5) {
			$this->testMoveDown($id, $number, $parentId, $expected);
		}
	}

}
