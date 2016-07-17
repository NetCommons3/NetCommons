<?php
/**
 * Config/routes.phpのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * Config/routes.phpのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Routing\Route\SlugRoute
 */
class RoutesTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.box4pages',
		'plugin.pages.boxes_page4routes',
		'plugin.pages.container4pages',
		'plugin.pages.containers_page4routes',
		'plugin.pages.frame4pages',
		'plugin.pages.languages_page4pages',
		'plugin.pages.page4routes',
		'plugin.pages.plugin4pages',
		'plugin.pages.plugins_room4pages',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'pages';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Pages', 'TestPages');
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Pages', 'TestErr');
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
	}

/**
 * DataProvider
 *
 * ### 戻り値
 * - url URL
 * - expected 期待値
 * - exception ExceptionError文字列(省略可)
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			//セッティングOFF
			array('url' => '/',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/test4/',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test4'))
			),
			array('url' => '/test_pages/test_page/index',
				'expected' => array('plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/test_pages/test_page',
				'expected' => array('plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/test_err/test_error',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test_err', 'test_error'))
			),
			array('url' => '/test_err/test_error/index',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test_err', 'test_error', 'index'))
			),
			array('url' => '/aaaaa/',
				'expected' => false, 'exception' => 'MissingControllerException'
			),
			//セッティングON
			array('url' => '/setting/',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/setting/test4/',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test4'))
			),
			array('url' => '/setting/test_pages/test_page/index',
				'expected' => array('plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/setting/test_pages/test_page',
				'expected' => array('plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index', 'pass' => array())
			),
			array('url' => '/setting/test_err/test_error',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test_err', 'test_error'))
			),
			array('url' => '/setting/test_err/test_error/index',
				'expected' => array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index', 'pass' => array('test_err', 'test_error', 'index'))
			),
			array('/setting/aaaaa/',
				'expected' => false, 'exception' => 'MissingControllerException'
			),
		);
	}

/**
 * parse()のテスト
 *
 * @param string $url URL
 * @param bool|array $expected 期待値
 * @param null|string $exception ExceptionError文字列(省略可)
 * @dataProvider dataProvider
 * @return void
 */
	public function testRoutes($url, $expected, $exception = null) {
		//テスト実施
		$this->_testGetAction($url, null, $exception, 'view');

		//チェック
		if ($expected) {
			$this->assertEquals($expected['plugin'], $this->controller->request->params['plugin']);
			$this->assertEquals($expected['controller'], $this->controller->request->params['controller']);
			$this->assertEquals($expected['action'], $this->controller->request->params['action']);
			$this->assertEquals($expected['pass'], $this->controller->request->params['pass']);
		}
	}

/**
 * parse()のテスト
 *
 * @return void
 */
	public function testRoutesByBlockId() {
		$url = '/test_net_commons/test_net_commons/index/1/content_key';
		$expected = array(
			'plugin' => 'test_net_commons', 'controller' => 'test_net_commons', 'action' => 'index', 'block_id' => '1', 'key' => 'content_key'
		);

		//テスト実施
		$this->_testGetAction($url, null, null, 'view');

		//チェック
		$this->assertEquals($expected['plugin'], $this->controller->request->params['plugin']);
		$this->assertEquals($expected['controller'], $this->controller->request->params['controller']);
		$this->assertEquals($expected['action'], $this->controller->request->params['action']);
		$this->assertEquals($expected['block_id'], $this->controller->request->params['block_id']);
		$this->assertEquals($expected['key'], $this->controller->request->params['key']);
	}

}
