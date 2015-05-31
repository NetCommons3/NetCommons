<?php
/**
 * NetCommonsController Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsController', 'NetCommons.Controller');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');

/**
 * Summary for NetCommonsController Test Case
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NetCommonsControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.containers.container',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.net_commons.site_setting',
		'plugin.pages.boxes_page',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.plugin_manager.plugin',
		'plugin.roles.default_role_permission',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.users.user',
	];

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->generate(
			'NetCommons.NetCommons', [
				'components' => [
					'Auth' => ['user'],
				],
			]
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
 * testCsrfToken method
 *
 * @return void
 */
	public function testCsrfToken() {
		CakeSession::write('Auth.User.id', '1');
		Router::parseExtensions();
		$this->testAction('/net_commons/net_commons/csrfToken.json', ['return' => 'contents']);

		$this->assertArrayHasKey('_Token', $this->controller->viewVars['data']);
		$this->assertArrayHasKey('key', $this->controller->viewVars['data']['_Token']);

		$this->assertNotEmpty(CakeSession::read('_Token.csrfTokens'));
		CakeSession::delete('Auth.User.id');
	}

/**
 * Expect NetCommonsAppController->beforeFilter() to handle request w/ valid content status which necessary for workflow
 *
 * @return void
 */
	public function testPageDataExistsWhenFrameIdSpecified() {
		$this->testAction('/net_commons/net_commons/edit/1', ['return' => 'contents']);
		$this->assertNotNull($this->controller->current['page']);
	}

/**
 * Expect NetCommonsAppController->parseStatus() to handle request w/ valid content status which necessary for workflow
 *
 * @return void
 */
	public function testParseStatus() {
		$this->testAction('/net_commons/net_commons/edit/1', [
			'method' => 'post',
			'data' => [
				'save_' . NetCommonsBlockComponent::STATUS_PUBLISHED => '',
			],
			'return' => 'contents'
		]);
		$this->assertEqual(NetCommonsBlockComponent::STATUS_PUBLISHED, $this->controller->NetCommonsWorkflow->parseStatus());
	}

/**
 * Expect NetCommonsAppController->parseStatus() to handle ajax request w/o valid content status which necessary for workflow
 *
 * @return void
 */
	public function testParseStatusAjax() {
		RolesControllerTest::login($this);
		$this->testAction('/net_commons/net_commons/edit/1.json', [
			'method' => 'post',
			'type' => 'json',
			'data' => [
			],
			'return' => 'contents'
		]);
		$this->assertFalse($this->controller->NetCommonsWorkflow->parseStatus());
	}

/**
 * Expect NetCommonsAppController->parseStatus() to handle request w/o valid content status which necessary for workflow
 *
 * @return void
 */
	public function testParseStatusInvalid() {
		$this->setExpectedException('BadRequestException');
		$this->testAction('/net_commons/net_commons/edit/1', [
			'method' => 'post',
			'data' => [
			],
			'return' => 'contents'
		]);
		$this->assertFalse($this->controller->NetCommonsWorkflow->parseStatus());
	}

/**
 * Expect NetCommonsAppController->handleValidationError() to handle ajax request correctly
 *
 * @return void
 */
	public function testHandleValidationErrorAjax() {
		$this->testAction('/net_commons/net_commons/index', [
			'type' => 'json',
			'return' => 'contents'
		]);
		$this->assertFalse($this->controller->handleValidationError(['error' => 'message']));
		$this->assertEquals($this->controller->validationErrors, ['error' => 'message']);
	}

/**
 * Expect Configure::read('Config.language') value configured through query string
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuery() {
		$this->testAction('/net_commons/net_commons/index?language=en', [
		]);
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

/**
 * Expect CakeSession::read('Config.language') value configured through query string
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuerySession() {
		$this->testAction('/net_commons/net_commons/index?language=en', [
		]);
		$this->assertEquals(CakeSession::read('Config.language'), 'en');
	}

/**
 * Expect Configure::read('Config.language') value configured through session
 *
 * @return void
 */
	public function testLanguageConfiguredThroughSession() {
		CakeSession::write('Config.language', 'en');
		$this->testAction('/net_commons/net_commons/index', [
		]);
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

/**
 * Expect NetCommonsAppController->throwBadRequest() to handle ajax request correctly
 *
 * @return void
 */
	public function testThrowBadRequestAjax() {
		$this->testAction('/net_commons/net_commons/index', [
			'type' => 'json',
			'return' => 'contents'
		]);
		$this->controller->throwBadRequest();
	}

}
