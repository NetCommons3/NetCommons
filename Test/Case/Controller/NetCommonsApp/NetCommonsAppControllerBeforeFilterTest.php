<?php
/**
 * NetCommonsAppController::beforeFilter()テスト
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
 * NetCommonsAppController::beforeFilter()テスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsAppControllerBeforeFilterTest extends NetCommonsControllerTestCase {

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
 * NetCommonsAppController::beforeFilter()のテスト
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
			'/test_net_commons/test_net_commons/index',
			array('return' => 'view')
		);

		$this->assertEquals($this->controller->view, 'index');
		$this->assertEquals(trim($this->view), 'TestNetCommonsIndex');
	}

/**
 * NetCommonsAppController::beforeFilter()のAjaxテスト
 *
 * @return void
 */
	public function testIndexAjax() {
		Router::parseExtensions();
		$this->testAction(
			'/test_net_commons/test_net_commons/index_json_with_file.json',
			array('return' => 'contents')
		);
		$view = json_decode($this->view, true);

		$this->assertEquals('OK', $view['name']);
		$this->assertEquals(200, $view['code']);
		$this->assertEquals(200, $this->controller->response->statusCode());
	}

/**
 * NetCommonsAppController::beforeFilter()のAjaxテスト(HTTP_ACCEPT=application/json)
 *
 * @return void
 */
	public function testIndexAjaxByAccept() {
		//Router::parseExtensions();
		$_SERVER['HTTP_ACCEPT'] = 'application/json';
		$this->testAction(
			'/test_net_commons/test_net_commons/index_json_wo_file',
			array('return' => 'contents')
		);

		$this->assertEquals('OK', $this->controller->viewVars['results']['name']);
		$this->assertEquals(200, $this->controller->viewVars['results']['code']);
		$this->assertEquals(200, $this->controller->response->statusCode());
	}

/**
 * リクエストlanguage=enによるConfigure::read('Config.language')のテスト
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuery() {
		$this->testAction('/test_net_commons/test_net_commons/index?language=en', array());
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

/**
 * リクエストlanguage=enによるCakeSession::read('Config.language')のテスト
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuerySession() {
		$this->testAction('/test_net_commons/test_net_commons/index?language=en', array());
		$this->assertEquals(CakeSession::read('Config.language'), 'en');
	}

/**
 * CakeSession::write('Config.language')によるConfigure::read('Config.language')のテスト
 *
 * @return void
 */
	public function testLanguageConfiguredThroughSession() {
		CakeSession::write('Config.language', 'en');
		$this->testAction('/test_net_commons/test_net_commons/index', array());
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

}
