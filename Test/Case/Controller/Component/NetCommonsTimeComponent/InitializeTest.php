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
 * initialize()のテスト
 *
 * @return void
 */
	public function testInitialize() {
		//テストコントローラ生成
		$this->generateNc('TestNetCommons.TestNetCommonsTimeComponent');

		// 個別のコントローラで読みこまなくてもNetCommonsAppControllerでNetCommonsTimeは有効になっている
		$this->assertInstanceOf('NetCommonsTimeComponent', $this->controller->NetCommonsTime);

		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_net_commons/test_net_commons_time_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');





		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestNetCommonsTimeComponent/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);



		//TODO:必要に応じてassert追加する
		debug($this->view);

	}

}
