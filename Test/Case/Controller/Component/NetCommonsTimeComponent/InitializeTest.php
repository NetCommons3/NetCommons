<?php
/**
 * NetCommonsTimeComponent::initialize()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTimeComponent::initialize()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\Controller\Component\NetCommonsTimeComponent
 */
class NetCommonsTimeComponentInitializeTest extends NetCommonsControllerTestCase {

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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * NetCommonsAppControllerで読みこまれるので個々のコントローラでの読み込み不要
 *
 * @return void
 */
	public function testAlwaysLoad() {
		//テストコントローラ生成
		$this->generateNc('TestNetCommons.TestNetCommonsTimeComponent');

		// 個別のコントローラで読みこまなくてもNetCommonsAppControllerでNetCommonsTimeは有効になっている
		$this->assertInstanceOf('NetCommonsTimeComponent', $this->controller->NetCommonsTime);
	}

/**
 * ModelName.field_nameでのタイムゾーンコンバート
 *
 * @return void
 */
	public function testFieldNameWithModelNameConvert() {
		//テストコントローラ生成
		$this->generateNc('TestNetCommons.TestNetCommonsTimeComponent');

		//ログイン
		TestAuthGeneral::login($this);

		$data = [
			'Block' => [
				'publish_start' => '2001-01-01 09:00:00',
			],
			'_NetCommonsTime' => [
				'user_timezone' => 'Asia/Tokyo',
				'convert_fields' => 'Block.publish_start', // convert_fieldsにモデル名抜きのフィールド名のパターン
			],
		];

		//テスト実行
		$this->_testPostAction('post', $data, '/test_net_commons/test_net_commons_time_component/index');

		$this->assertEquals('2001-01-01 00:00:00', $this->controller->request->data['Block']['publish_start']);
	}

}
