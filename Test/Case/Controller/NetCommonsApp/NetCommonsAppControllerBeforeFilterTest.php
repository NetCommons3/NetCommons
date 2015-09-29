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
 * Expect Configure::read('Config.language') value configured through query string
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuery() {
		$this->testAction('/test_net_commons/test_net_commons/index?language=en', [
		]);
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

/**
 * Expect CakeSession::read('Config.language') value configured through query string
 *
 * @return void
 */
	public function testLanguageConfiguredThroughQuerySession() {
		$this->testAction('/test_net_commons/test_net_commons/index?language=en', [
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
		$this->testAction('/test_net_commons/test_net_commons/index', [
		]);
		$this->assertEquals(Configure::read('Config.language'), 'en');
	}

}
