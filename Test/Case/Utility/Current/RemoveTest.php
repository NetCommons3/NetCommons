<?php
/**
 * CurrentPage::setPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('Current', 'NetCommons.Utility');

/**
 * CurrentPage::setPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\Current
 */
class NetCommonsUtilityCurrentRemoveTest extends CakeTestCase {

/**
 * By default, all fixtures attached to this class will be truncated and reloaded after each test.
 * Set this to false to handle manually
 *
 * @var array
 */
	public $autoFixtures = false;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//Currentの実態がCurrentLibだったら処理しない
		if (get_class(new Current()) === 'CurrentLib') {
			$this->markTestSkipped();
			return;
		}

		Current::$current = [
			'Frame' => [
				'id' => '1',
			],
			'Test' => [
				'Block' => [
					'id' => '2'
				]
			],
			'Test2' => [
				'Test' => [
					'Block' => [
						'id' => '3'
					]
				],
			]
		];
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = [];
		parent::tearDown();
	}

/**
 * DataProvider
 *
 * @return array テストデータ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider() {
		$results = [];

		$results['test_case_0'] = [
			'key' => null,
			'expectedKey' => null,
			'expectedValue' => [],
		];

		$results['test_case_1'] = [
			'key' => 'Test2',
			'expectedKey' => null,
			'expectedValue' => [
				'Frame' => [
					'id' => '1',
				],
				'Test' => [
					'Block' => [
						'id' => '2'
					]
				],
			],
		];

		$results['test_case_2'] = [
			'key' => 'Test3',
			'expectedKey' => null,
			'expectedValue' => [
				'Frame' => [
					'id' => '1',
				],
				'Test' => [
					'Block' => [
						'id' => '2'
					]
				],
				'Test2' => [
					'Test' => [
						'Block' => [
							'id' => '3'
						]
					],
				]
			],
		];

		$results['test_case_3'] = [
			'key' => 'Frame.id',
			'expectedKey' => 'Frame',
			'expectedValue' => [],
		];

		$results['test_case_4'] = [
			'key' => 'Frame.name',
			'expectedKey' => 'Frame',
			'expectedValue' => [
				'id' => '1',
			],
		];

		$results['test_case_5'] = [
			'key' => 'Test.Block',
			'expectedKey' => 'Test',
			'expectedValue' => [],
		];

		$results['test_case_6'] = [
			'key' => 'Test.Block2',
			'expectedKey' => 'Test',
			'expectedValue' => [
				'Block' => [
					'id' => '2'
				],
			],
		];

		$results['test_case_8'] = [
			'key' => 'Test.Block.id',
			'expectedKey' => 'Test.Block',
			'expectedValue' => [],
		];

		$results['test_case_9'] = [
			'key' => 'Test.Block.name',
			'expectedKey' => 'Test.Block',
			'expectedValue' => [
				'id' => '2',
			],
		];

		$results['test_case_10'] = [
			'key' => 'Test2.Test.Block',
			'expectedKey' => 'Test2.Test',
			'expectedValue' => [],
		];

		$results['test_case_11'] = [
			'key' => 'Test2.Test.Block2',
			'expectedKey' => 'Test2.Test',
			'expectedValue' => [
				'Block' => [
					'id' => '3'
				],
			],
		];

		$results['test_case_12'] = [
			'key' => 'Test2.Test3.Block',
			'expectedKey' => 'Test2',
			'expectedValue' => [
				'Test' => [
					'Block' => [
						'id' => '3'
					]
				],
			],
		];

		$results['test_case_13'] = [
			'key' => 'Test2.Test.Block.id',
			'expectedKey' => 'Test2.Test.Block',
			'expectedValue' => [],
		];

		return $results;
	}

/**
 * Current::write()のテスト
 *
 * @param string|null $key 削除するキー
 * @param string|null $expectedKey 期待値のチェックするキー
 * @param string|array $expectedValue 期待値のチェックする値
 * @dataProvider dataProvider
 * @return void
 */
	public function testRemove($key, $expectedKey, $expectedValue) {
		//テスト実施
		Current::remove($key);

		if (is_null($expectedKey)) {
			$result = Current::read();
		} else {
			$result = Current::read($expectedKey);
		}
		$this->assertEquals($result, $expectedValue);
	}

}
