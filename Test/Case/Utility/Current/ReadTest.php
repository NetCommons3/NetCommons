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
class NetCommonsUtilityCurrentReadTest extends CakeTestCase {

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
 */
	public function dataProvider() {
		$results = [];

		$results['test_case_0'] = [
			'test' => null,
			'expected' => [
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

		$results['test_case_1'] = [
			'test' => 'Test2',
			'expected' => [
				'Test' => [
					'Block' => [
						'id' => '3'
					]
				],
			],
		];

		$results['test_case_2'] = [
			'test' => 'Test3',
			'expected' => null,
		];

		$results['test_case_3'] = [
			'test' => 'Frame.id',
			'expected' => '1',
		];

		$results['test_case_4'] = [
			'test' => 'Frame.name',
			'expected' => null,
		];

		$results['test_case_5'] = [
			'test' => 'Test.Block',
			'expected' => [
				'id' => '2'
			],
		];

		$results['test_case_6'] = [
			'test' => 'Test.Block.id',
			'expected' => '2',
		];

		$results['test_case_7'] = [
			'test' => 'Test.Block.name',
			'expected' => null,
		];

		$results['test_case_8'] = [
			'test' => 'Test2.Test.Block.id',
			'expected' => '3',
		];

		$results['test_case_9'] = [
			'test' => 'Test2.Test.Block.name',
			'expected' => null,
		];

		return $results;
	}

/**
 * Current::read()のdefault引数なしテスト
 *
 * @param string|null $key テストのHashのパスキー
 * @param array|string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testReadWithoutDefault($key, $expected) {
		//テスト実施
		$result = Current::read($key);
		$this->assertEquals($result, $expected);

		if (is_null($key)) {
			$result = Current::read();
			$this->assertEquals($result, $expected);
		}
	}

/**
 * Current::read()のdefault引数なしテスト
 *
 * @param string|null $key テストのHashのパスキー
 * @param array|string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testReadWithDefault($key, $expected) {
		//テスト実施
		if (is_null($expected)) {
			$expected = 'default';
		}
		$result = Current::read($key, 'default');
		$this->assertEquals($result, $expected);
	}

}
