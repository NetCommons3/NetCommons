<?php
/**
 * RmNetCommonsIndexAppModel::Behaviorsに関するテスト
 *
 * @author Japan Science and Technology Agency
 * @author National Institute of Informatics
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RmNetCommonsIndexAppModel::Behaviorsに関するテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package Researchmap\RmNetCommons\Test\Case\Model\RmNetCommonsIndexAppModel
 */
class NetCommonsAppModelValidateTest extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'net_commons';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsValidationRuleModel');
	}

/**
 * notBlank()バリデーションのテストデータ
 *
 * ### テストケース1
 * エラーでない正常値
 *
 * ### テストケース2
 * 空値
 *
 * ### テストケース3
 * 半角スペース1つ
 *
 * ### テストケース4
 * 半角スペース2つ
 *
 * ### テストケース5
 * 全角スペース1つ
 *
 * ### テストケース6
 * 全角スペース2つ
 *
 * ### テストケース7
 * $$
 *
 * ### テストケース8
 * $␣$
 *
 * ### テストケース9
 * ␣&nbsp␣;
 *
 * ### テストケース10
 * ``
 *
 * ### テストケース11
 * `␣`
 *
 * @return void
 */
	public function dataProviderNotBlank() {
		return [
			'not_blank_1' => [
				'data' => [
					'key' => 'not_blank_1',
					'value' => 'Value Not blank',
				],
				'isError' => false,
			],
			'not_blank_2' => [
				'data' => [
					'key' => '',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_3' => [
				'data' => [
					'key' => ' ',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_4' => [
				'data' => [
					'key' => '  ',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_5' => [
				'data' => [
					'key' => '　',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_6' => [
				'data' => [
					'key' => '　　',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_7' => [
				'data' => [
					'key' => '$$',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_8' => [
				'data' => [
					'key' => '$ $',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_9' => [
				'data' => [
					'key' => ' &nbsp; ',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_10' => [
				'data' => [
					'key' => '``',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
			'not_blank_11' => [
				'data' => [
					'key' => '` `',
					'value' => 'Value Not blank',
				],
				'isError' => true,
			],
		];
	}

/**
 * notBlank()バリデーションのテスト
 *
 * @param array $data テストデータ
 * @param bool $isError エラーかどうか
 * @return void
 * @dataProvider dataProviderNotBlank
 */
	public function testNotBlank($data, $isError) {
		$this->assertEmpty($this->TestModel->validationErrors);

		$this->TestModel->validate = [
			'key' => [
				'notBlank' => [
					'rule' => ['notBlank'],
					'message' => 'Not Blank'
				]
			]
		];
		$this->TestModel->set($data);

		$result = $this->TestModel->validates();
		if ($isError) {
			$this->assertFalse($result);
			$expected = [
				'key' => [
					0 => 'Not Blank'
				],
			];
			$this->assertEquals($expected, $this->TestModel->validationErrors);
		} else {
			$this->assertTrue($result);
		}
	}

}
