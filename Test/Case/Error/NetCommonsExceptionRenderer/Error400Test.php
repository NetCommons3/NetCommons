<?php
/**
 * NetCommonsExceptionRenderer::error400()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsExceptionRenderer', 'NetCommons.Error');
App::uses('Current', 'NetCommons.Utiltiy');

/**
 * NetCommonsExceptionRenderer::error400()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Error\NetCommonsExceptionRenderer
 */
class ErrorNetCommonsExceptionRendererError400Test extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting4test',
	);

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
		Current::$current['Language']['id'] = '2';
		Configure::write('debug', 0);
	}

/**
 * Mocks out the response on the ExceptionRenderer object so headers aren't modified.
 *
 * @param NetCommonsExceptionRenderer $error NetCommonsExceptionRenderer
 * @return void
 */
	protected function _mockResponse($error) {
		$error->controller->response = $this->getMock('CakeResponse', array('_sendHeader'));
		return $error;
	}

/**
 * Session Mockの生成
 *
 * @param NetCommonsExceptionRenderer $error NetCommonsExceptionRenderer
 * @return NetCommonsExceptionRenderer
 */
	protected function _mockSession($error) {
		//$error->controller->Session = $this->getMock('Session', array('destroy'));
		//$error->controller->Session
		//	->expects($this->once())->method('destroy');
		return $error;
	}

/**
 * AuthComponent Mockの生成
 *
 * @param NetCommonsExceptionRenderer $error NetCommonsExceptionRenderer
 * @return NetCommonsExceptionRenderer
 */
	protected function _mockAuth($error) {
		$error->controller->Auth = $this->getMock('Auth', array('user', 'redirectUrl'));
		$error->controller->Auth
			->expects($this->any())->method('user')
			->will($this->returnValue(true));
		return $error;
	}

/**
 * CakeRequest Mockの生成
 *
 * @param NetCommonsExceptionRenderer $error NetCommonsExceptionRenderer
 * @param array $methods メソッド
 * @return NetCommonsExceptionRenderer
 */
	protected function _mockRequest($error, $methods) {
		if ($error->controller->Components->loaded('DebugKit.Toolbar')) {
			$error->controller->Components->unload('DebugKit.Toolbar');
		}

		unset($error->controller->helpers['Toolbar']);

		$error->controller->request = $this->getMock('CakeRequest', array_keys($methods));
		if (array_key_exists('is', $methods)) {
			$error->controller->request
				->expects($this->any())->method('is')
				->with($methods['is']['arg'])
				->will($this->returnValue($methods['is']['ret']));
		}
		if (array_key_exists('here', $methods)) {
			$error->controller->request
				->expects($this->any())->method('here')
				->will($this->returnValue($methods['here']));
		}
		if (array_key_exists('referer', $methods)) {
			$error->controller->request
				->expects($this->any())->method('referer')
				->will($this->returnValue($methods['referer']));
		}
		return $error;
	}

/**
 * MissingControllerExceptionのログインなしテスト
 *
 * @return void
 */
	public function testMissingControllerExceptionWOLogin() {
		$exception = new NetCommonsExceptionRenderer(
			new MissingControllerException('TestMissingController')
		);
		$exception = $this->_mockSession($exception);

		$this->__assert($exception, array(
			'code' => 404,
			'name' => 'Not Found',
			'message' => __d('net_commons', 'Permission denied. You must be logged.'),
			'redirect' => '/auth/login',
		), false);
	}

/**
 * MissingControllerExceptionのログインありテスト
 *
 * @return void
 */
	public function testMissingControllerExceptionWithLogin() {
		$exception = new NetCommonsExceptionRenderer(
			new MissingControllerException('TestMissingController')
		);

		$exception = $this->_mockAuth($exception);
		$exception->controller->Auth
			->expects($this->once())->method('redirectUrl');

		$exception = $this->_mockRequest($exception, array(
			'here' => '/test_netcommons/test_netcommons/index',
			'referer' => '/test_netcommons/test_netcommons/edit',
		));

		$this->__assert($exception, array(
			'code' => 404,
			'name' => 'Not Found',
			'message' => __d('net_commons', 'Permission denied. Bad account.'),
			'redirect' => '/',
		), false);
	}

/**
 * MissingControllerExceptionのログイン直後でリダイレクト先のページがないテスト
 *
 * @return void
 */
	public function testMissingControllerExceptionWithLoginWOPage1() {
		$exception = new NetCommonsExceptionRenderer(
			new MissingControllerException('TestMissingController')
		);
		$exception->SiteSetting = $this->getMock('SiteSetting', array('getDefaultStartPage'));
		$exception->SiteSetting
			->expects($this->any())->method('getDefaultStartPage')
			->will($this->returnValue('/mypage1'));

		$exception = $this->_mockAuth($exception);
		$exception->controller->Auth
			->expects($this->once())->method('redirectUrl');

		$exception = $this->_mockRequest($exception, array(
			'here' => '/test_netcommons/test_netcommons/index',
			'referer' => '/auth/auth/login',
		));

		$this->__assert($exception, array(
			'code' => 404,
			'name' => 'Not Found',
			'message' => __d('net_commons', 'Permission denied. Bad account.'),
			'redirect' => '/mypage1',
		), false);
	}

/**
 * MissingControllerExceptionのログイン直後でリダイレクト先のページがないテスト
 *
 * @return void
 */
	public function testMissingControllerExceptionWithLoginWOPage2() {
		$exception = new NetCommonsExceptionRenderer(
			new MissingControllerException('TestMissingController')
		);
		$exception->SiteSetting = $this->getMock('SiteSetting', array('getDefaultStartPage'));
		$exception->SiteSetting
			->expects($this->any())->method('getDefaultStartPage')
			->will($this->returnValue('/mypage2'));

		$exception = $this->_mockAuth($exception);
		$exception->controller->Auth
			->expects($this->once())->method('redirectUrl');

		$exception = $this->_mockRequest($exception, array(
			'here' => '/auth/auth/login',
			'referer' => null,
		));

		$this->__assert($exception, array(
			'code' => 404,
			'name' => 'Not Found',
			'message' => __d('net_commons', 'Permission denied. Bad account.'),
			'redirect' => '/mypage2',
		), false);
	}

/**
 * SecurityComponentエラー(BlackHole)のテスト
 *
 * @return void
 */
	public function testBlackHoleException() {
		$exception = new NetCommonsExceptionRenderer(
			new BadRequestException('The request has been black-holed')
		);
		$exception = $this->_mockRequest($exception, array(
			'here' => '/test_netcommons/test_netcommons/index',
			'referer' => '/test_netcommons/test_netcommons/edit',
			'is' => ['arg' => 'ajax', 'ret' => false]
		));

		$this->__assert($exception, array(
			'message' => __d('net_commons', 'The request has been black-holed'),
			'redirect' => '/test_netcommons/test_netcommons/edit',
		), false);
	}

/**
 * SecurityComponentエラー(BlackHole)のテスト
 *
 * @return void
 */
	public function testBlackHoleExceptionAjax() {
		$exception = new NetCommonsExceptionRenderer(
			new BadRequestException('The request has been black-holed')
		);
		$exception = $this->_mockRequest($exception, array(
			'here' => '/test_netcommons/test_netcommons/index',
			'referer' => '/test_netcommons/test_netcommons/edit',
			'is' => ['arg' => 'ajax', 'ret' => true]
		));

		$this->__assert($exception, array(
			'message' => __d('net_commons', 'The request has been black-holed'),
			'redirect' => '/test_netcommons/test_netcommons/edit',
		), true);
	}

/**
 * チェック
 *
 * @param NetCommonsExceptionRenderer $exception NetCommonsExceptionRenderer
 * @param array $expected 期待値
 * @param bool $ajax AJAXかどうか
 * @return void
 */
	private function __assert($exception, $expected, $ajax) {
		ob_start();
		$exception->render();
		$result = $this->_parseView(ob_get_clean());

		$this->assertEquals('error400', $exception->method);
		if ($ajax) {
			$this->assertFalse($exception->controller->layout);
			$this->assertEquals('Json', $exception->controller->viewClass);

			$viewVars = $exception->controller->viewVars;
			$interval = 6000;
		} else {
			$this->assertEquals('NetCommons.error', $exception->controller->layout);

			$viewVars = $exception->controller->viewVars;
			$needle =
				'<script type="text/javascript"> ' .
					'setTimeout( function() { ' .
						'location.href=\'' . $viewVars['redirect'] . '\'.replace(/&amp;/ig,"&"); ' .
					'}, ' . $viewVars['interval'] . ' );' .
				'</script>';
			$interval = 4000;
			$this->assertTextContains($needle, $result);
		}

		$actual = array(
			'code' => $viewVars['code'],
			'name' => $viewVars['name'],
			'url' => $viewVars['url'],
			'message' => $viewVars['message'],
			'redirect' => $viewVars['redirect'],
			'interval' => $viewVars['interval'],
		);
		$expected = Hash::merge(array(
			'code' => 400,
			'name' => 'Bad Request',
			'url' => $exception->controller->request->here(),
			'message' => '',
			'redirect' => '',
			'interval' => $interval,
		), $expected);

		$this->assertEquals($expected, $actual);
	}

}
