<?php
/**
 * NetCommonsApp Controller Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsAppController', 'NetCommons.Controller');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsApp Controller Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NetCommonsAppControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'app.session',
		//'plugin.blocks.block',
		//'plugin.boxes.box',
		//'plugin.boxes.boxes_page',
		//'plugin.containers.container',
		//'plugin.frames.frame',
		//'plugin.m17n.language',
		//'plugin.net_commons.site_setting',
		//'plugin.pages.page',
		//'plugin.plugin_manager.plugin',
		//'plugin.public_space.space',
		//'plugin.roles.default_role_permission',
		//'plugin.rooms.roles_rooms_user',
		//'plugin.rooms.roles_room',
		//'plugin.rooms.room',
		//'plugin.rooms.room_role_permission',
		//'plugin.users.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->generate('NetCommons.NetCommonsApp');
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
 * Expect ping() to return response
 *
 * @return void
 */
	public function testPing() {
		$this->controller->ping();

		$this->assertEquals(
			[
				'message' => 'OK'
			],
			$this->controller->viewVars['result']
		);
	}

/**
 * testRenderJson method
 *
 * @return void
 */
	public function testRenderJson() {
		$this->controller->renderJson(array('test' => 'renderJson test'), 'Error', 400);

		$expected = array(
			'code' => 400,
			'name' => 'Error',
			'test' => 'renderJson test',
		);
		$this->assertEquals($expected, $this->controller->viewVars['results']);
	}

/**
 * testRenderJson method
 *
 * @return void
 */
	public function testRenderJsonWithout1stArg() {
		$this->controller->set('test', 'renderJson test');
		$this->controller->renderJson([], 'Error', 400);

		$expected = array(
			'code' => 400,
			'name' => 'Error',
			'test' => 'renderJson test',
		);
		$this->assertEquals($expected, $this->controller->viewVars['results']);
	}

/**
 * Expect NetCommonsAppController->redirectByFrameId() to redirect to pages.permalink
 *
 * @return void
 */
	public function testRedirectByFrameId() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$permalink = 'test';
		$this->controller->current['page']['permalink'] = $permalink;
		$this->controller->redirectByFrameId();
		unset($_SERVER['HTTP_X_REQUESTED_WITH']);

		$this->assertEquals(Router::url('/' . $permalink, true), $this->controller->response->header()['Location']);
	}

/**
 * Expect NetCommonsAppController->redirectByFrameId() to ignore redirect for ajax request
 *
 * @return void
 */
	public function testRedirectByFrameIdIgnoredIfAjax() {
		$this->controller->redirectByFrameId();
		$this->assertEquals(Router::url('/', true), $this->controller->response->header()['Location']);
	}

/**
 * Expect NetCommonsAppController->handleValidationError() to return false if validation error given
 *
 * @return void
 */
	public function testHandleValidationErrorReturnsFalseOnFailure() {
		$this->assertFalse($this->controller->handleValidationError(['error' => 'message']));
	}

/**
 * Expect NetCommonsAppController->handleValidationError() to set validation errors
 *
 * @return void
 */
	public function testHandleValidationErrorSetsValidationErrors() {
		$this->controller->handleValidationError(['error' => 'message']);
		$this->assertEquals($this->controller->validationErrors, ['error' => 'message']);
	}

/**
 * Expect NetCommonsAppController->handleValidationError() to return true unless validation error given
 *
 * @return void
 */
	public function testHandleValidationErrorReturnsTrueOnSuccess() {
		$this->assertTrue($this->controller->handleValidationError([]));
	}

/**
 * Expect NetCommonsAppController->throwBadRequest() to return true unless validation error given
 *
 * @return void
 */
	public function testThrowBadRequest() {
		$this->setExpectedException('BadRequestException');
		$this->controller->throwBadRequest();
	}

/**
 * Expect HtmlHelper use NetCommons.SingletonViewBlockHtmlHelper class
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
