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
App::uses('CurrentLibControllerTestExpectedData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLibControllerTestPostData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLib', 'NetCommons.Lib');
App::uses('Current', 'NetCommons.Utility');

/**
 * Current::initialize()のControllerテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\CurrentLib
 */
class NetCommonsLibCurrentLibControllerGeneralUser1Test extends ControllerTestCase {

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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		NetCommonsCurrentLibTestUtility::resetCurrentLib();
		parent::tearDown();
	}

/**
 *  一般ユーザ1ログインのGETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @dataProvider caseGeneralUser1ByGet
 * @return void
 */
	public function testGeneralUser1ByGet($controller, $url, $expects, $exception) {
		NetCommonsCurrentLibTestUtility::login('2');

		$this->generate($controller);
		NetCommonsCurrentLibTestUtility::testControllerGetMethod(
			$this, $url, $expects, $exception
		);

		NetCommonsCurrentLibTestUtility::logout();
	}

/**
 * 一般ユーザ1ログインのGETテストのデータ
 *
 * @return array テストデータ
 */
	public function caseGeneralUser1ByGet() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'管理者のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_system_admistrator',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
			'一般ユーザ1のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_general_user_1',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1'
						]),
						$ExpectedData->getExpectedSettingMode('on')
					),
					'assertNotContains' => array_merge([],
						$ExpectedData->getExpectedMenuList([
							'community_2'
						])
					),
					'assertRegExp' => array_merge([],
						$ExpectedData->getExpectedActiveMenu('private_general_user_1')
					),
				],
				'exception' => false,
			],
			'プライベート(一般ユーザ1)の予定の表示' => [
				'controller' => 'Calendars.CalendarPlans',
				'/calendars/calendar_plans/view/calendar_event_key_786?frame_id=11',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1'
						]),
						$ExpectedData->getExpectedCalendarPlanView('private_plan_2')
					),
					'assertNotContains' => array_merge([],
						$ExpectedData->getExpectedSettingMode('on'),
						$ExpectedData->getExpectedSettingMode('off'),
						$ExpectedData->getExpectedMenuList([
							'community_2'
						])
					),
				],
				'exception' => false,
			],
			'パブリックのカレンダーページの表示' => [
				'controller' => 'Pages.Pages',
				'/calendars_page',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1'
						])
					),
					'assertNotContains' => array_merge([],
						$ExpectedData->getExpectedSettingMode('on'),
						$ExpectedData->getExpectedSettingMode('off'),
						$ExpectedData->getExpectedMenuList([
							'community_2'
						])
					),
					'assertRegExp' => array_merge(
						$ExpectedData->getExpectedCalendar([
							'public_plan_1', 'community_plan_1', 'private_plan_2'
						]),
						$ExpectedData->getExpectedActiveMenu('public_calendar_page')
					),
					'assertNotRegExp' => array_merge([],
						$ExpectedData->getExpectedCalendar([
							'private_plan_1'
						])
					),
				],
				'exception' => false,
			],
		];

		return $results;
	}

}
