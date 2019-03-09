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
class NetCommonsLibCurrentLibControllerWithoutLoginGetTest extends ControllerTestCase {

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
		NetCommonsCurrentLibTestUtility::debugLogTestName('ログインなし', $method);
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
 * ログインなしのGETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataGetRequestToppage
 * @dataProvider dataGetRequestMyRoomOfAdministrator
 * @dataProvider dataGetRequestAnnouncementBlockSettings
 * @dataProvider dataGetRequestPrivatePlanOfAdministorator
 * @dataProvider dataGetRequestBbsArticleOfCommunity
 * @dataProvider dataGetRequestPublicCalendarPage
 *
 * @return void
 */
	public function testGetRequest($controller, $url, $expects, $exception) {
		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testGetRequest($this, $controller, $url, $expects, $exception);
	}

/**
 * トップページテスト表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestToppage() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'トップページ' => [
				'controller' => 'Pages.Pages',
				'url' => '/',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedAnnouncement(['toppage']),
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList(['public'])
					),
					'assertNotContains' => array_merge(
						$ExpectedData->getExpectedMenuList(['private', 'community_1', 'community_2']),
						$ExpectedData->getExpectedSettingMode('on')
					),
					'assertRegExp' => array_merge([],
						$ExpectedData->getExpectedActiveMenu('toppage')
					),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * 管理者のマイルーム表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestMyRoomOfAdministrator() {
		$results = [
			'管理者のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_system_admistrator',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
		];

		return $results;
	}

/**
 * お知らせのブロック設定表示[Community room 1]のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestAnnouncementBlockSettings() {
		$results = [
			'お知らせのブロック設定表示[Community room 1]' => [
				'controller' => 'Announcements.AnnouncementBlocks',
				'/announcements/announcement_blocks/edit/11?frame_id=16',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
		];

		return $results;
	}

/**
 * プライベート(管理者)の予定の表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestPrivatePlanOfAdministorator() {
		$results = [
			'プライベート(管理者)の予定の表示' => [
				'controller' => 'Calendars.CalendarPlans',
				'/calendars/calendar_plans/view/calendar_event_key_472',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
		];

		return $results;
	}

/**
 * コミュニティの記事詳細表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestBbsArticleOfCommunity() {
		$results = [
			'コミュニティの掲示板の記事詳細表示' => [
				'controller' => 'Bbses.BbsArticles',
				'/bbses/bbs_articles/view/15/bbs_article_key_1?frame_id=20',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
		];

		return $results;
	}

/**
 * パブリックのカレンダーページの表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestPublicCalendarPage() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'パブリックのカレンダーページの表示' => [
				'controller' => 'Pages.Pages',
				'/calendars_page',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList(['public'])
					),
					'assertNotContains' => array_merge([],
						$ExpectedData->getExpectedSettingMode('on'),
						$ExpectedData->getExpectedSettingMode('off'),
						$ExpectedData->getExpectedMenuList([
							'private', 'community_1', 'community_2'
						])
					),
					'assertRegExp' => array_merge([],
						$ExpectedData->getExpectedCalendar([
							'public_plan_1'
						]),
						$ExpectedData->getExpectedActiveMenu('public_calendar_page')
					),
					'assertNotRegExp' =>
						$ExpectedData->getExpectedCalendar([
							'community_plan_1', 'private_plan_1', 'private_plan_2'
						]),
				],
				'exception' => false,
			],
		];

		return $results;
	}

}
