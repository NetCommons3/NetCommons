<?php
/**
 * NetCommonsFrameApp Controller Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('AssetComponent', 'Component');
App::uses('NetCommonsFrameAppController', 'NetCommons.Controller');

/**
 * NetCommonsFrameApp Controller Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsFrameAppControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.session',
		'app.site_setting',
		'plugin.frames.frame',
		'plugin.frames.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.rooms.room',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->NetCommonsFrameApp = new NetCommonsFrameAppController($CakeRequest, $CakeResponse);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * _itializeFrame protected method test
 *
 * @return void
 */
	public function testInitializeFrame() {
		$frameId = 1;
		$method = new ReflectionMethod($this->NetCommonsFrameApp, '_initializeFrame');
		$method->setAccessible(true);
		$result = $method->invoke($this->NetCommonsFrameApp, $frameId);
		$this->assertTrue($result);
	}

/**
 * _itializeFrame protected method test for no frame id
 *
 * @return void
 */
	public function testInitializeFrameByNoFrameId() {
		$frameId = 999;
		$method = new ReflectionMethod($this->NetCommonsFrameApp, '_initializeFrame');
		$method->setAccessible(true);
		$result = $method->invoke($this->NetCommonsFrameApp, $frameId);
		$this->assertFalse($result);
	}

/**
 * _itializeFrame protected method test for login user
 *
 * @return void
 */
	public function testInitializeFrameByLoginUser() {
		CakeSession::write('Auth.User.id', 1);

		$frameId = 1;
		$method = new ReflectionMethod($this->NetCommonsFrameApp, '_initializeFrame');
		$method->setAccessible(true);
		$result = $method->invoke($this->NetCommonsFrameApp, $frameId);
		$this->assertTrue($result);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * beforeFilter method test
 *
 * @return void
 */
	public function testBeforeFilter() {
		$result = $this->NetCommonsFrameApp->beforeFilter();
		$this->assertNull($result);
	}

/**
 * _renderJson protected method test
 *
 * @return void
 */
	public function testRenderJson() {
		$this->NetCommonsFrameApp = $this->generate('NetCommons.NetCommonsFrameApp', array(
			'components' => array(
				'Asset',
			),
		));
		$this->NetCommonsFrameApp->Asset
			->staticExpects($this->any())
			->method('isThemeBootstrapMinCss')
			->will($this->returnValue(true));

		$method = new ReflectionMethod($this->NetCommonsFrameApp, '_renderJson');
		$method->setAccessible(true);
		$result = $method->invoke($this->NetCommonsFrameApp, 200, '_renderJson protected method test');
		$this->assertTrue(!empty($result));
	}

}
