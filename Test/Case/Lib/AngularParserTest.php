<?php
/**
 * Current::read()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AngularParser', 'NetCommons.Lib');

/**
 * AngularParser::parse()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\Current
 */
class AngularParserTest extends CakeTestCase {

/**
 * DataProvider
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		$results = [];

		$results['test_case_0'] = [
			'input' => [
				'{{0_root}}',
				'1_root',
				'Test1_1' => '{{Test1_1}}',
				'Test1_2' => 'Test1_2',
				'Test2' => [
					'{{Test2_0}}',
					'Test2_1'
				],
				'Test3' => [
					'id' => '{{Test3_id}}'
				],
				'Test4' => [
					'id' => '{{Test3_id}}',
					'Test4_1' => [
						'{{Test4_0_0}}',
						'Test4_1_1',
						'id' => '{{Test4_1_id}}',
						'Test4_1_1' => [
							'{{Test4_1_1_0}}',
							'Test4_1_1_1',
							'id' => '{{Test4_1_1_id}}',
						],
					],
				],
			],
			'expect' => [
				'{ { 0_root } }',
				'1_root',
				'Test1_1' => '{ { Test1_1 } }',
				'Test1_2' => 'Test1_2',
				'Test2' => [
					'{ { Test2_0 } }',
					'Test2_1'
				],
				'Test3' => [
					'id' => '{ { Test3_id } }'
				],
				'Test4' => [
					'id' => '{ { Test3_id } }',
					'Test4_1' => [
						'{ { Test4_0_0 } }',
						'Test4_1_1',
						'id' => '{ { Test4_1_id } }',
						'Test4_1_1' => [
							'{ { Test4_1_1_0 } }',
							'Test4_1_1_1',
							'id' => '{ { Test4_1_1_id } }',
						],
					],
				],
			],
		];
		$results['test_case_1'] = [
			'input' => [
				'{{{root_1}}}',
				'{ {{root_2}} }',
				'{{ {root_3} }}',
				'{{{{root_4}}}}',
			],
			'expect' => [
				'{ { {root_1 }  } }',
				'{ { { root_2 } } }',
				'{ {  {root_3}  } }',
				'{ { { { root_4 } } } }',
			],
		];

		return $results;
	}

/**
 * AngularParser::parse()のテスト
 *
 * @param array $input 入力値
 * @param array $expect 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testParser($input, $expect) {
		//テスト実施
		AngularParser::parse($input);
		$this->assertTrue(AngularParser::parse($input));
		//debug($input);
		$this->assertEquals($input, $expect);
	}

}
