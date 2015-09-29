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
