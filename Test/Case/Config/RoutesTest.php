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

App::uses('NetCommonsRoutesTestCase', 'NetCommons.TestSuite');

/**
 * Config/routes.phpのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Routing\Route\SlugRoute
 */
class RoutesTest extends NetCommonsRoutesTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.box4routes',
		'plugin.pages.boxes_page_container4routes',
		'plugin.pages.page_container4routes',
		'plugin.pages.frame4pages',
		'plugin.pages.pages_language4pages',
		'plugin.pages.page4routes',
		'plugin.pages.plugin4pages',
		'plugin.pages.plugins_room4pages',
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
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'
				)
			),
			array('url' => '/test4/',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test4')
				)
			),
			array('url' => '/test_pages/test_page/index',
				'expected' => array(
					'plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index'
				)
			),
			array('url' => '/test_pages/test_page',
				'expected' => array(
					'plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index'
				)
			),
			array('url' => '/test_err/test_error',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test_err', 'test_error')
				)
			),
			array('url' => '/test_err/test_error/index',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test_err', 'test_error', 'index')
				)
			),
			array('url' => '/aaaaa/',
				'expected' => array(
					'plugin' => null, 'controller' => 'aaaaa', 'action' => 'index',
				),
			),
			//セッティングON
			array('url' => '/setting/',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'
				),
				'settingMode' => true
			),
			array('url' => '/setting/test4/',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test4')
				),
				'settingMode' => true
			),
			array('url' => '/setting/test_pages/test_page/index',
				'expected' => array(
					'plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index'
				),
				'settingMode' => true
			),
			array('url' => '/setting/test_pages/test_page',
				'expected' => array(
					'plugin' => 'test_pages', 'controller' => 'test_page', 'action' => 'index',
				),
				'settingMode' => true
			),
			array('url' => '/setting/test_err/test_error',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test_err', 'test_error')
				),
				'settingMode' => true
			),
			array('url' => '/setting/test_err/test_error/index',
				'expected' => array(
					'plugin' => 'pages', 'controller' => 'pages', 'action' => 'index',
					'pass' => array('test_err', 'test_error', 'index')
				),
				'settingMode' => true
			),
			array('url' => '/setting/aaaaa/',
				'expected' => array(
					'plugin' => null, 'controller' => 'aaaaa', 'action' => 'index',
				),
				'settingMode' => true
			),
		);
	}

}
