<?php
/**
 * NetCommonsAppController::ThrowBadRequest()テスト
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
 * NetCommonsAppController::ThrowBadRequest()テスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsAppControllerThrowBadRequestTest extends NetCommonsControllerTestCase {

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

}
