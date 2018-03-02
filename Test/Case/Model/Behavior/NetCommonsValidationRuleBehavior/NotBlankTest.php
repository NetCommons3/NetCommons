<?php
/**
 * NetCommonsValidationRuleBehavior::notBlank()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsValidationRuleBehavior::notBlank()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsValidationRuleBehavior
 */
class NetCommonsValidationRuleBehaviorNotBlankTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsValidationRuleBehaviorModel');
	}

/**
 * notBlank()テストのDataProvider
 *
 * ### 戻り値
 *  - check チェック値
 *
 * @return array データ
 */
	public function dataProvider() {
		return [
			['check' => ['field' => 'a&nbsp;a'], 'expected' => true],
			['check' => ['field' => 'a　a'], 'expected' => true],
			['check' => ['field' => 'a a'], 'expected' => true],
			['check' => ['field' => '`aa`'], 'expected' => true],
			['check' => ['field' => '$aa$'], 'expected' => true],
			['check' => ['field' => '  '], 'expected' => false],
			['check' => ['field' => '$$'], 'expected' => false],
			['check' => ['field' => '$　$'], 'expected' => false],
			['check' => ['field' => '$&nbsp;$'], 'expected' => false],
			['check' => ['field' => '``'], 'expected' => false],
			['check' => ['field' => '`　`'], 'expected' => false],
			['check' => ['field' => '`&nbsp;`'], 'expected' => false],
		];
	}

/**
 * notBlank()のテスト
 *
 * @param array $check チェック値
 * @param bool $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testNotBlank($check, $expected) {
		//テスト実施
		$result = $this->TestModel->notBlank($check);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
