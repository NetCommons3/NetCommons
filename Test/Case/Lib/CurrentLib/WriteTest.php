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

App::uses('CurrentLib', 'NetCommons.Lib');
App::uses('Current', 'NetCommons.Utility');

/**
 * Current::write()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\CurrentLib
 */
class NetCommonsLibCurrentLibWriteTest extends CakeTestCase {

/**
 * By default, all fixtures attached to this class will be truncated and reloaded after each test.
 * Set this to false to handle manually
 *
 * @var array
 */
	public $autoFixtures = false;

/**
 * Called when a test case method is about to start (to be overridden when needed.)
 *
 * @param string $method Test method about to get executed.
 * @return void
 */
	public function startTest($method) {
		//Currentの実態がCurrentLibでなかったら処理しない
		if (get_class(new Current()) !== 'CurrentLib') {
			$this->markTestSkipped();
			return;
		}
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		CurrentLib::$current = [
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
		CurrentLib::$current = [];
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
			'value' => [
				'Frame' => [
					'id' => '9',
					'name' => 'aaaaa',
				],
				'Test2' => [
					'Test' => [
						'Block' => [
							'id' => '7'
						]
					],
				]
			],
			'expectedKey' => null,
			'expectedValue' => [
				'Frame' => [
					'id' => '9',
					'name' => 'aaaaa',
				],
				'Test' => [
					'Block' => [
						'id' => '2'
					]
				],
				'Test2' => [
					'Test' => [
						'Block' => [
							'id' => '7'
						]
					],
				]
			],
		];

		$results['test_case_1'] = [
			'key' => 'Test2',
			'value' => [
				'Test' => [
					'Block' => [
						'name' => 'aaaa'
					]
				],
				'TestNew' => [
					'Block' => [
						'id' => '9'
					]
				],
			],
			'expectedKey' => 'Test2',
			'expectedValue' => [
				'Test' => [
					'Block' => [
						'name' => 'aaaa'
					]
				],
				'TestNew' => [
					'Block' => [
						'id' => '9'
					]
				],
			],
		];

		$results['test_case_2'] = [
			'key' => 'Test3',
			'value' => [
				'TestNew2' => [
					'Block' => [
						'id' => '9'
					]
				],
			],
			'expectedKey' => 'Test3',
			'expectedValue' => [
				'TestNew2' => [
					'Block' => [
						'id' => '9'
					]
				],
			],
		];

		$results['test_case_3'] = [
			'key' => 'Frame.id',
			'value' => '999',
			'expectedKey' => 'Frame.id',
			'expectedValue' => '999',
		];

		$results['test_case_4'] = [
			'key' => 'Frame.name',
			'value' => 'aaaaa',
			'expectedKey' => 'Frame',
			'expectedValue' => [
				'id' => '1',
				'name' => 'aaaaa',
			],
		];

		$results['test_case_5'] = [
			'key' => 'Test.Block',
			'value' => [
				'name' => 'aaaaa',
			],
			'expectedKey' => 'Test.Block',
			'expectedValue' => [
				'name' => 'aaaaa',
			],
		];

		$results['test_case_6'] = [
			'key' => 'Test.Block2',
			'value' => [
				'name' => 'bbbbb',
			],
			'expectedKey' => 'Test',
			'expectedValue' => [
				'Block' => [
					'id' => '2'
				],
				'Block2' => [
					'name' => 'bbbbb',
				]
			],
		];

		$results['test_case_7'] = [
			'key' => 'Test2.Test',
			'value' => [
				'name' => 'ccccc',
			],
			'expectedKey' => 'Test2',
			'expectedValue' => [
				'Test' => [
					'name' => 'ccccc',
				]
			],
		];

		$results['test_case_8'] = [
			'key' => 'Test.Block.id',
			'value' => '999',
			'expectedKey' => 'Test.Block.id',
			'expectedValue' => '999',
		];

		$results['test_case_9'] = [
			'key' => 'Test.Block.name',
			'value' => 'aaaaa',
			'expectedKey' => 'Test.Block',
			'expectedValue' => [
				'id' => '2',
				'name' => 'aaaaa',
			],
		];

		$results['test_case_10'] = [
			'key' => 'Test2.Test.Block',
			'value' => [
				'name' => 'bbbbb',
			],
			'expectedKey' => 'Test2.Test.Block',
			'expectedValue' => [
				'name' => 'bbbbb',
			],
		];

		$results['test_case_11'] = [
			'key' => 'Test2.Test.Block2',
			'value' => [
				'name' => 'bbbbb',
			],
			'expectedKey' => 'Test2.Test',
			'expectedValue' => [
				'Block' => [
					'id' => '3'
				],
				'Block2' => [
					'name' => 'bbbbb',
				],
			],
		];

		$results['test_case_12'] = [
			'key' => 'Test2.Test3.Block',
			'value' => [
				'name' => 'bbbbb',
			],
			'expectedKey' => 'Test2',
			'expectedValue' => [
				'Test' => [
					'Block' => [
						'id' => '3'
					]
				],
				'Test3' => [
					'Block' => [
						'name' => 'bbbbb'
					]
				],
			],
		];

		return $results;
	}

/**
 * Current::write()のテスト
 *
 * @param string|null $key 書き込みするキー
 * @param string|array $value 書き込みする値
 * @param string|null $expectedKey 期待値のチェックするキー
 * @param string|array $expectedValue 期待値のチェックする値
 * @dataProvider dataProvider
 * @return void
 */
	public function testWrite($key, $value, $expectedKey, $expectedValue) {
		//テスト実施
		CurrentLib::write($key, $value);

		if (is_null($expectedKey)) {
			$result = CurrentLib::read();
		} else {
			$result = CurrentLib::read($expectedKey);
		}
		$this->assertEquals($result, $expectedValue);
	}

}
