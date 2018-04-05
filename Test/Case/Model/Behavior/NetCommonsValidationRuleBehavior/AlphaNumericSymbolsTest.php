<?php
/**
 * NetCommonsValidationRuleBehavior::alphaNumericSymbols()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsValidationRuleBehavior::alphaNumericSymbols()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsValidationRuleBehavior
 */
class NetCommonsValidationRuleBehaviorAlphaNumericSymbolsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Fixture merge
 *
 * @var array
 */
	protected $_isFixtureMerged = false;

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
 * alphaNumericSymbols()テストのDataProvider
 *
 * ### 戻り値
 *  - check チェック値
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			//英字小文字
			array('check' => array('field' => 'abcdefghijklmnopqrstuvwxyz'), 'expected' => true),
			//英字大文字
			array('check' => array('field' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 'expected' => true),
			//数字
			array('check' => array('field' => '0123456789'), 'expected' => true),
			//「_」
			array('check' => array('field' => 'aaaa_aaaa'), 'expected' => true),
			//「-」
			array('check' => array('field' => 'aaaa-aaaa'), 'expected' => true),
			//「<」
			array('check' => array('field' => 'aaaa<aaaa'), 'expected' => true),
			//「>」
			array('check' => array('field' => 'aaaa>aaaa'), 'expected' => true),
			//「,」
			array('check' => array('field' => 'aaaa,aaaa'), 'expected' => true),
			//「.」
			array('check' => array('field' => 'aaaa.aaaa'), 'expected' => true),
			//「$」
			array('check' => array('field' => 'aaaa$aaaa'), 'expected' => true),
			//「%」
			array('check' => array('field' => 'aaaa%aaaa'), 'expected' => true),
			//「#」
			array('check' => array('field' => 'aaaa#aaaa'), 'expected' => true),
			//「@」
			array('check' => array('field' => 'aaaa@aaaa'), 'expected' => true),
			//「!」
			array('check' => array('field' => 'aaaa!aaaa'), 'expected' => true),
			//「\」
			array('check' => array('field' => 'aaaa\\aaaa'), 'expected' => true),
			//「'」
			array('check' => array('field' => "aaaa'aaaa"), 'expected' => true),
			//「"」
			array('check' => array('field' => 'aaaa"aaaa'), 'expected' => true),
			//「+」
			array('check' => array('field' => 'aaaa+aaaa'), 'expected' => true),
			//「&」
			array('check' => array('field' => 'aaaa&aaaa'), 'expected' => true),
			//「?」
			array('check' => array('field' => 'aaaa?aaaa'), 'expected' => true),
			//「=」
			array('check' => array('field' => 'aaaa=aaaa'), 'expected' => true),
			//「~」
			array('check' => array('field' => 'aaaa~aaaa'), 'expected' => true),
			//「:」
			array('check' => array('field' => 'aaaa:aaaa'), 'expected' => true),
			//「;」
			array('check' => array('field' => 'aaaa;aaaa'), 'expected' => true),
			//「|」
			array('check' => array('field' => 'aaaa|aaaa'), 'expected' => true),
			//「]」
			array('check' => array('field' => 'aaaa]aaaa'), 'expected' => true),
			//「[」
			array('check' => array('field' => 'aaaa[aaaa'), 'expected' => true),
			//「(」
			array('check' => array('field' => 'aaaa(aaaa'), 'expected' => true),
			//「)」
			array('check' => array('field' => 'aaaa)aaaa'), 'expected' => true),
			//「*」
			array('check' => array('field' => 'aaaa*aaaa'), 'expected' => true),
			//「^」
			array('check' => array('field' => 'aaaa^aaaa'), 'expected' => true),
			//「{」
			array('check' => array('field' => 'aaaa{aaaa'), 'expected' => true),
			//「}」
			array('check' => array('field' => 'aaaa}aaaa'), 'expected' => true),
			//「/」
			array('check' => array('field' => 'aaaa/aaaa'), 'expected' => true),
			//ひらがな
			array('check' => array('field' => 'aaaaあaaaa'), 'expected' => false),
			//半角ｶﾀｶﾅ
			array('check' => array('field' => 'aaaaｱaaaa'), 'expected' => false),
		);
	}

/**
 * alphaNumericSymbols()のテスト
 *
 * @param array $check チェック値
 * @param bool $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testAlphaNumericSymbols($check, $expected) {
		//テスト実施
		$result = $this->TestModel->alphaNumericSymbols($check, false);

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * alphaNumericSymbols()の$errorPattern引数のテスト
 *
 * @param array $check チェック値
 * @param bool $expected 期待値。強制的にfalseにする
 * @dataProvider dataProvider
 * @return void
 */
	public function testErrorPattern($check, $expected) {
		//テスト実施
		$errorPattern = 'aA2_-<>,.$%#@!\\\'"' . '+&?=~:;|][()*^{}/';
		$result = $this->TestModel->alphaNumericSymbols($check, $errorPattern);

		//チェック
		$expected = false;
		$this->assertEquals($result, $expected);
	}

/**
 * バリデーションのテスト
 *
 * @return void
 */
	public function testValidationError() {
		$data = array(
			'field' => 'aaaaｱaaaa'
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertFalse($result);
	}

/**
 * バリデーションの$errorPattern引数のテスト
 *
 * @return void
 */
	public function testValidationErrorWithErrorPattern() {
		$data = array(
			'field' => 'aaaa/aaaa'
		);

		//テスト実施
		$this->TestModel->validate = array(
			'field' => array(
				'alphaNumericSymbols' => array(
					'rule' => array('alphaNumericSymbols', '/'),
					'message' => 'Only alphabets, numbers and symbols are allowed to use for %s.',
					'allowEmpty' => false,
					'required' => true,
				),
			),
		);

		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		$this->assertFalse($result);
	}

}
