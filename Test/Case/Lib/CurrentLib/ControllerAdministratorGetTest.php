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
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NetCommonsLibCurrentLibControllerAdministratorGetTest extends ControllerTestCase {

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
		NetCommonsCurrentLibTestUtility::debugLogTestName('管理者でログイン', $method);
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsCurrentLibTestUtility::login('1');
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
 * 管理者でのGETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataGetRequestToppage
 * @dataProvider dataGetRequestMyRoomOfAdministrator
 * @dataProvider dataGetRequestMyRoomOfGeneralUser1
 * @dataProvider dataGetRequestAnnouncementBlockSettings
 * @dataProvider dataGetRequestPrivatePlanOfAdministorator
 * @dataProvider dataGetRequestPrivatePlanOfGeneralUser1
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
 * パブリックのお知らせページのセッティングモード表示のテスト
 *
 * @return void
 */
	public function testGetRequestAnnouncementPageWithSettingMode() {
		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testGetRequestAnnouncementPageWithSettingMode($this);
	}

/**
 * ファイルダウンロードテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataGetRequestWysiwygDownload
 *
 * @return void
 */
	public function testGetRequestDownload(
			$controller, $url, $expects, $exception) {
		//@var NetCommonsCurrentLibTestRun
		$TestRun = new NetCommonsCurrentLibTestRun();
		$TestRun->testGetRequestDownload($this, $controller, $url, $expects, $exception);
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
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('on')
					),
					'assertNotContains' => [],
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
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'管理者のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_system_admistrator',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedAnnouncement(['private']),
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('on')
					),
					'assertNotContains' => [],
					'assertRegExp' => array_merge([],
						$ExpectedData->getExpectedActiveMenu('private_administrator')
					),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * 一般ユーザ1のマイルーム表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestMyRoomOfGeneralUser1() {
		$results = [
			'一般ユーザ1のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_general_user_1',
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
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'お知らせのブロック設定表示[Community room 1]' => [
				'controller' => 'Announcements.AnnouncementBlocks',
				'/announcements/announcement_blocks/edit/11?frame_id=16',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu', 'community_1_announcement_edit_1']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('off'),
						$ExpectedData->getExpectedAnnouncement(['community_1_edit'])
					),
					'assertNotContains' => [],
					'assertRegExp' =>
						$ExpectedData->getExpectedBlockSettingTabs('announcement', 'block_setting')
				],
				'exception' => false,
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
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'プライベート(管理者)の予定の表示' => [
				'controller' => 'Calendars.CalendarPlans',
				'/calendars/calendar_plans/view/calendar_event_key_472',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('on'),
						$ExpectedData->getExpectedCalendarPlanView('private_plan_1')
					),
					'assertNotContains' => [],
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * プライベート(一般ユーザ1)の予定の表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestPrivatePlanOfGeneralUser1() {
		$results = [
			'プライベート(一般ユーザ1)の予定の表示' => [
				'controller' => 'Calendars.CalendarPlans',
				'/calendars/calendar_plans/view/calendar_event_key_786?frame_id=11',
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
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'コミュニティの掲示板の記事詳細表示' => [
				'controller' => 'Bbses.BbsArticles',
				'/bbses/bbs_articles/view/15/bbs_article_key_1?frame_id=20',
				'expects' => [
					'assertContains' => array_merge(
						$ExpectedData->getExpectedFrame(['menu']),
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_1_bbs_page', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('on'),
						$ExpectedData->getExpectedBbsArticleView('community_1_bbs_article_1')
					),
					'assertNotContains' => [],
					'assertRegExp' => $ExpectedData->getExpectedToBackLink('community_1_bbs_article_1'),
				],
				'exception' => false,
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
						$ExpectedData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$ExpectedData->getExpectedSettingMode('on')
					),
					'assertNotContains' => [],
					'assertRegExp' => array_merge(
						$ExpectedData->getExpectedCalendar([
							'public_plan_1', 'community_plan_1', 'private_plan_1'
						]),
						$ExpectedData->getExpectedActiveMenu('public_calendar_page')
					),
					'assertNotRegExp' => array_merge([],
						$ExpectedData->getExpectedCalendar([
							'private_plan_2'
						])
					),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * Wysiwygのダウンロード
 *
 * @return array テストデータ
 */
	public function dataGetRequestWysiwygDownload() {
		$results = [
			'画像ダウンロード' => [
				'controller' => 'Wysiwyg.WysiwygImageDownload',
				'/wysiwyg/image/download/1/1/big',
				'expects' => [
					'headers.Content-Disposition' => '#45e1da4f4a632c256d8e980afa7f4991\.png$#',
					'headers.Content-Length' => '#^6483$#',
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * 管理者のグループ選択のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestGroupSelect() {
//		//@var CurrentLibControllerTestExpectedData
//		$ExpectedData = new CurrentLibControllerTestExpectedData();
//
//		$results = [
//			'グループ選択画面表示' => [
//				'controller' => 'Groups.Groups',
//				'url' => '/groups/groups/select/1',
//				'expects' => [
////					'assertContains' => array_merge(
////						$ExpectedData->getExpectedAnnouncement(['private']),
////						$ExpectedData->getExpectedFrame(['menu']),
////						$ExpectedData->getExpectedMenuList([
////							'public', 'private', 'community_1', 'community_2'
////						]),
////						$ExpectedData->getExpectedSettingMode('on')
////					),
////					'assertNotContains' => [],
////					'assertRegExp' => array_merge([],
////						$ExpectedData->getExpectedActiveMenu('private_administrator')
////					),
//				],
//				'exception' => false,
//			],
//		];

		return $results;
	}

}
