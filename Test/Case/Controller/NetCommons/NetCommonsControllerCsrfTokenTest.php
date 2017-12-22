<?php
/**
 * NetCommonsController::csrfToken()のテスト
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsController', 'NetCommons.Controller');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsController::csrfToken()のテスト
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsControllerCsrfTokenTest extends NetCommonsControllerTestCase {

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
		$this->generate(
			'NetCommons.NetCommons', array(
				'components' => array(
					'Auth' => array(),
				)
			)
		);
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
 * csrfTokenのテスト
 *
 * @return void
 */
	public function testCsrfToken() {
		Router::parseExtensions();

		$reflectionClass = new ReflectionClass('AuthComponent');
		$property = $reflectionClass->getProperty('_user');
		$property->setAccessible(true);
		$property->setValue($this->controller->Components->Auth, []);

		$this->testAction('/net_commons/net_commons/csrfToken.json', array('return' => 'contents'));

		$this->assertArrayHasKey('_Token', $this->controller->viewVars['data']);
		$this->assertArrayHasKey('key', $this->controller->viewVars['data']['_Token']);

		$this->assertNotEmpty(CakeSession::read('_Token.csrfTokens'));
	}

}
