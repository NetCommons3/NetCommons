<?php
/**
 * NetCommonsExceptionRenderer::error500()のテスト
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
 * NetCommonsExceptionRenderer::error500()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Error\NetCommonsExceptionRenderer
 */
class NetCommonsErrorNetCommonsExceptionRendererError500Test extends NetCommonsControllerTestCase {

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
 * InternalErrorExceptionのテスト
 *
 * @return void
 */
	public function testInternalErrorException() {
		$exception = new NetCommonsExceptionRenderer(
			new InternalErrorException(__d('net_commons', 'Internal Server Error'))
		);

		$this->__assert($exception, array(
			'message' => __d('net_commons', 'An Internal Error Has Occurred.'),
		));
	}

/**
 * InternalErrorExceptionのステータス502のテスト
 *
 * @return void
 */
	public function testInternalErrorExceptionOnStatus502() {
		$exception = new NetCommonsExceptionRenderer(
			new InternalErrorException(__d('net_commons', 'Internal Server Error'), 502)
		);

		$this->__assert($exception, array(
			'message' => __d('net_commons', 'An Internal Error Has Occurred.'),
		));
	}

/**
 * InternalErrorExceptionのステータス502のテスト(debug)
 *
 * @return void
 */
	public function testInternalErrorExceptionOnStatus502WithDebug() {
		Configure::write('debug', 2);

		$exception = new NetCommonsExceptionRenderer(
			new InternalErrorException('Custom Error', 502)
		);

		$this->__assert($exception, array(
			'code' => 502,
			'message' => 'Custom Error',
		));
	}

/**
 * チェック
 *
 * @param NetCommonsExceptionRenderer $exception NetCommonsExceptionRenderer
 * @param array $expected 期待値
 * @return void
 */
	private function __assert($exception, $expected) {
		ob_start();
		$exception->render();
		ob_get_clean();
		//$result = $this->_parseView(ob_get_clean());

		$this->assertEquals('error500', $exception->method);
		$this->assertEquals('NetCommons.error', $exception->controller->layout);

		$viewVars = $exception->controller->viewVars;
		$actual = array(
			'code' => $viewVars['code'],
			'name' => $viewVars['name'],
			'url' => $viewVars['url'],
			'message' => $viewVars['message'],
		);
		$expected = Hash::merge(array(
			'code' => 500,
			'name' => 'Internal Error',
			'url' => $exception->controller->request->here(),
			'message' => '',
		), $expected);

		$this->assertEquals($expected, $actual);
	}

}
