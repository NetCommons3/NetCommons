<?php
/**
 * NetCommonsAppControllerテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsAppController', 'NetCommons.Controller');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsAppControllerテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsAppControllerTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
	}

/**
 * NetCommonsAppController::ping()のテスト
 *
 * @return void
 */
	public function testPing() {
		$this->testAction(
			'/test_net_commons/test_net_commons/ping',
			array('return' => 'view')
		);
		$this->assertEquals(array('message' => 'OK'),
			$this->vars['result']
		);
	}

/**
 * NetCommonsAppController::throwBadRequest()のテスト
 *
 * @return void
 */
	public function testThrowBadRequest() {
		$this->setExpectedException('BadRequestException');
		$this->testAction(
			'/test_net_commons/test_net_commons/throwBadRequest',
			array('return' => 'view')
		);
	}

/**
 * NetCommonsAppController::throwBadRequest()のAjaxテスト
 *
 * @return void
 */
	public function testThrowBadRequestAjax() {
		$_SERVER['HTTP_ACCEPT'] = 'application/json';

		$this->testAction(
			'/test_net_commons/test_net_commons/throwBadRequestAjax',
			array('return' => 'view')
		);

		$this->assertEquals(__d('net_commons', 'Bad Request'), $this->controller->viewVars['results']['name']);
		$this->assertEquals(400, $this->controller->viewVars['results']['code']);
		$this->assertEquals(400, $this->controller->response->statusCode());
	}

/**
 * NetCommonsAppController->emptyRender()のテスト
 *
 * @return void
 */
	public function testEmptyRender() {
		$this->testAction(
			'/test_net_commons/test_net_commons/emptyRender',
			array('return' => 'view')
		);

		$this->assertFalse($this->controller->autoRender);
	}

/**
 * HtmlHelperの代わりにNetCommons.SingletonViewBlockHtmlHelperを利用するためのテスト
 *
 * @return void
 */
	public function testSingletonViewBlockHtmlHelper() {
		App::build(array(
			'Controller' => array(CakePlugin::path('NetCommons') . 'Test' . DS . 'test_app' . DS . 'Controller' . DS)
		));
		App::uses('TestHelperController', 'Controller');

		$helperController = new TestHelperController();
		$this->assertEquals('NetCommons.SingletonViewBlockHtml', $helperController->helpers['Html']['className']);
	}

}
