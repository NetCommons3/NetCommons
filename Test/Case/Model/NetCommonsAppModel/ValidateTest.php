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
 * notBlankバリデーションのテストデータ
 *
 * ※わかりやすく、全角・半角スペース
 * ␣：半角スペース
 * □：全角スペース
 *
 * ### テストケース1
 * 'not_blank_1' => OK
 *
 * ### テストケース2
 * '' => Error
 *
 * ### テストケース3
 * '␣' => Error
 *
 * ### テストケース4
 * '␣␣' => Error
 *
 * ### テストケース5
 * '□' => Error
 *
 * ### テストケース6
 * '□□' => Error
 *
 * ### テストケース7
 * $$ => Error
 *
 * ### テストケース8
 * $␣$ => Error
 *
 * ### テストケース9
 * ␣&nbsp␣; => Error
 *
 * ### テストケース10
 * `` => Error
 *
 * ### テストケース11
 * `␣` => Error
 *
 * ### テストケース12
 * '$aaaa$' => OK
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
			'not_blank_12' => [
				'data' => [
					'key' => '$aaaa$',
					'value' => 'Value Not blank',
				],
				'isError' => false,
			],
		];
	}

/**
 * notBlankバリデーションのテスト
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

/**
 * booleanバリデーションのテストデータ
 *
 * ### テストケース1
 * true => OK
 *
 * ### テストケース2
 * false => OK
 *
 * ### テストケース3
 * '1' => OK
 *
 * ### テストケース4
 * '0' => OK
 *
 * ### テストケース5
 * 1 => OK
 *
 * ### テストケース6
 * 0 => OK
 *
 * ### テストケース7
 * 'a' => Error
 *
 * ### テストケース8
 * 'true' => Error
 *
 * ### テストケース9
 * 'false' => Error
 *
 * ### テストケース10
 * 2 => Error
 *
 * ### テストケース11
 * '' => Error
 *
 * ### テストケース12(allowEmpty=trueにした場合)
 * '' => OK
 *
 * @return void
 */
	public function dataProviderBool() {
		return [
			'boolean_1' => [
				'data' => [
					'key' => true,
				],
				'isError' => false,
			],
			'boolean_2' => [
				'data' => [
					'key' => false,
				],
				'isError' => false,
			],
			'boolean_3' => [
				'data' => [
					'key' => '1',
				],
				'isError' => false,
			],
			'boolean_4' => [
				'data' => [
					'key' => '0',
				],
				'isError' => false,
			],
			'boolean_5' => [
				'data' => [
					'key' => 1,
				],
				'isError' => false,
			],
			'boolean_6' => [
				'data' => [
					'key' => 0,
				],
				'isError' => false,
			],
			'boolean_7' => [
				'data' => [
					'key' => 'a',
				],
				'isError' => true,
			],
			'boolean_8' => [
				'data' => [
					'key' => 'true',
				],
				'isError' => true,
			],
			'boolean_9' => [
				'data' => [
					'key' => 'false',
				],
				'isError' => true,
			],
			'boolean_10' => [
				'data' => [
					'key' => 2,
				],
				'isError' => true,
			],
			'boolean_11' => [
				'data' => [
					'key' => '',
				],
				'isError' => true,
			],
			'boolean_12' => [
				'data' => [
					'key' => '',
				],
				'isError' => false,
				'allowEmpty' => true,
			],
		];
	}

/**
 * booleanバリデーションのテスト
 *
 * @param array $data テストデータ
 * @param bool $isError エラーかどうか
 * @param bool|null $allowEmpty 空文字を許可するかどうか
 * @return void
 * @dataProvider dataProviderBool
 */
	public function testBoolean($data, $isError, $allowEmpty = null) {
		$this->assertEmpty($this->TestModel->validationErrors);

		$this->TestModel->validate = [
			'key' => [
				'boolean' => [
					'rule' => ['boolean'],
					'message' => 'Not boolean',
					'allowEmpty' => $allowEmpty,
				]
			]
		];
		$this->TestModel->set($data);

		$result = $this->TestModel->validates();
		if ($isError) {
			$this->assertFalse($result);
			$expected = [
				'key' => [
					0 => 'Not boolean'
				],
			];
			$this->assertEquals($expected, $this->TestModel->validationErrors);
		} else {
			$this->assertTrue($result);
		}
	}

/**
 * multipleバリデーションのテストデータ
 *
 * ### テストケース1
 * ['key_1', 'key_2'] => OK
 *
 * ### テストケース2
 * ['key_1'] => OK
 *
 * ### テストケース3
 * [] => OK
 *
 * ### テストケース4
 * 'key_1' => OK
 *
 * ### テストケース5
 * ['key_1', 'key_3'] => Error
 *
 * ### テストケース6
 * 'key_3' => Error
 *
 * @return void
 */
	public function dataProviderMultiple() {
		return [
			'multiple_1' => [
				'data' => [
					'key' => ['key_1', 'key_2'],
				],
				'isError' => false,
			],
			'multiple_2' => [
				'data' => [
					'key' => ['key_1'],
				],
				'isError' => false,
			],
			'multiple_3' => [
				'data' => [
					'key' => [],
				],
				'isError' => false,
				'allowEmpty' => true,
			],
			'multiple_4' => [
				'data' => [
					'key' => 'key_1',
				],
				'isError' => false,
			],
			'multiple_5' => [
				'data' => [
					'key' => ['key_1', 'key_3'],
				],
				'isError' => true,
			],
			'multiple_6' => [
				'data' => [
					'key' => 'key_3',
				],
				'isError' => true,
			],
		];
	}

/**
 * オリジナル(multiple)バリデーションのテスト
 *
 * @param array $data テストデータ
 * @param bool $isError エラーかどうか
 * @param bool|null $allowEmpty 空文字を許可するかどうか
 * @return void
 * @dataProvider dataProviderMultiple
 */
	public function testMultiple($data, $isError, $allowEmpty = null) {
		$this->assertEmpty($this->TestModel->validationErrors);

		$this->TestModel->validate = [
			'key' => [
				'multiple' => [
					'rule' => ['multiple', ['in' => ['key_1', 'key_2']]],
					'message' => 'Error multiple',
					'allowEmpty' => $allowEmpty,
				]
			]
		];
		$this->TestModel->set($data);

		$result = $this->TestModel->validates();
		if ($isError) {
			$this->assertFalse($result);
			$expected = [
				'key' => [
					0 => 'Error multiple'
				],
			];
			$this->assertEquals($expected, $this->TestModel->validationErrors);
		} else {
			$this->assertTrue($result);
		}
	}

}
