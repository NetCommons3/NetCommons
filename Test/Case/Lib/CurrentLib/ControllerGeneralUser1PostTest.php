<?php
/**
 * Current::initialize()のControllerテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCurrentLibTestUtility', 'NetCommons.TestSuite');
App::uses('NetCommonsCurrentLibTestRun', 'NetCommons.TestSuite');
App::uses('CurrentLibControllerTestExpectedData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLibControllerTestPostData', 'NetCommons.Test/Fixture/CurrentLib');

/**
 * Current::initialize()のControllerテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\CurrentLib
 */
class NetCommonsLibCurrentLibControllerGeneralUser1PostTest extends ControllerTestCase {

/**
 * By default, all fixtures attached to this class will be truncated and reloaded after each test.
 * Set this to false to handle manually
 *
 * @var array
 */
	public $autoFixtures = false;

/**
 * Called when a test case method is about to start (to be overridden when needed.)
 *
 * @param string $method Test method about to get executed.
 * @return void
 */
	public function startTest($method) {
		if (! NetCommonsCurrentLibTestUtility::canLoadTables()) {
			$this->markTestSkipped('開発環境でのみテストができます。');
			return;
		}
		NetCommonsCurrentLibTestUtility::loadTables();

		//ログ出力
		NetCommonsCurrentLibTestUtility::debugLogTestName('一般ユーザ1でログイン', $method);
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsCurrentLibTestUtility::login('2');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		NetCommonsCurrentLibTestUtility::logout();
		NetCommonsCurrentLibTestUtility::resetCurrentLib();
		parent::tearDown();
	}

/**
 * Frame追加テスト
 *
 * @param array $post POSTの内容
 * @dataProvider dataPostRequestFrameAdd
 * @return void
 */
	public function testPostRequestFrameAdd($post, $expects) {
		$expects = false;
		$exception = 'ForbiddenException';

		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testPostRequestFrameAdd($this, $post, $expects, $exception);
	}

/**
 * Frame編集テスト
 *
 * @return void
 */
	public function testPostRequestFrameEdit() {
		$expects = false;
		$exception = 'ForbiddenException';

		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testPostRequestFrameEdit($this, $expects, $exception);
	}

/**
 * Frame削除テスト
 *
 * @return void
 */
	public function testPostRequestFrameDelete() {
		$expects = false;
		$exception = 'ForbiddenException';

		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testPostRequestFrameDelete($this, $expects, $exception);
	}

/**
 * フレーム追加のデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestFrameAdd() {
		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();
		$results = $PostData->getDataProviderByFrameAdd();
		return $results;
	}

}
