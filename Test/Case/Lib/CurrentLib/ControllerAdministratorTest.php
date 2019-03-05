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
class NetCommonsLibCurrentLibControllerAdministratorTest extends ControllerTestCase {

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
 * @dataProvider dataGetRequestToppageByAdministrator
 * @dataProvider dataGetRequestMyRoomOfAdministratorByAdministrator
 * @dataProvider dataGetRequestMyRoomOfGeneralUser1ByAdministrator
 * @dataProvider dataGetRequestAnnouncementBlockSettingsByAdministrator
 * @dataProvider dataGetRequestPrivatePlanOfAdministoratorByAdministrator
 * @dataProvider dataGetRequestPrivatePlanOfGeneralUser1ByAdministrator
 * @dataProvider dataGetRequestBbsArticleOfCommunityByAdministrator
 * @dataProvider dataGetRequestPublicCalendarPageByAdministrator
 *
 * @return void
 */
	public function testGetRequestByAdministrator($controller, $url, $expects, $exception) {
		$this->generate($controller);
		NetCommonsCurrentLibTestUtility::testControllerGetRequest(
			$this, $url, $expects, $exception
		);
	}

/**
 * 管理者でのPOSTテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataPostRequestAnnouncementOfToppageByAdministrator
 * @dataProvider dataPostRequestAnnouncementOfPublicPageByAdministrator
 *
 * @return void
 */
	public function testPostRequestByAdministrator($controller, $url, $post, $expects, $exception) {
		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * 管理者でのFrame追加テスト
 *
 * @param array $post POSTの内容
 * @dataProvider dataPostRequestFrameAdd
 * @return void
 */
	public function testPostRequestFrameAddByAdministrator($post, $expects) {
		$controller = 'Frames.Frames';
		$url = '/frames/frames/add';
		$exception = false;

		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * 管理者でのFrame編集テスト
 *
 * @return void
 */
	public function testPostRequestFrameEditByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$controller = 'Frames.Frames';
		$url = '/frames/frames/edit';
		$post = $PostData->getPostDataByFrameEdit();
		$expects = [
			'Location' => $ExpectedData->getExpectedRedirectAfterPost('public_announcement_page')
		];
		$exception = false;

		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * トップページテスト表示のテストデータ
 *
 * @return array テストデータ
 */
	public function dataGetRequestToppageByAdministrator() {
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
	public function dataGetRequestMyRoomOfAdministratorByAdministrator() {
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
	public function dataGetRequestMyRoomOfGeneralUser1ByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

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
	public function dataGetRequestAnnouncementBlockSettingsByAdministrator() {
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
	public function dataGetRequestPrivatePlanOfAdministoratorByAdministrator() {
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
	public function dataGetRequestPrivatePlanOfGeneralUser1ByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

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
	public function dataGetRequestBbsArticleOfCommunityByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$results = [
			'コミュニティの記事詳細表示' => [
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
	public function dataGetRequestPublicCalendarPageByAdministrator() {
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
 * トップページのお知らせ登録のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestAnnouncementOfToppageByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$results = [
			'トップページのお知らせ' => [
				'controller' => 'Announcements.Announcements',
				'url' => '/announcements/announcements/edit/12',
				'post' => $PostData->getPostDataAnnouncement('toppage_announcement'),
				'expects' => [
					'Location' => $ExpectedData->getExpectedRedirectAfterPost('toppage_announcement'),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * パブリックスペースのお知らせ1(Announcements Page)登録のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestAnnouncementOfPublicPageByAdministrator() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$results = [
			'パブリックスペースのお知らせ1(Announcements Page)' => [
				'controller' => 'Announcements.Announcements',
				'url' => '/announcements/announcements/edit/8?frame_id=12',
				'post' => $PostData->getPostDataAnnouncement('public_announcement_2'),
				'expects' => [
					'Location' => $ExpectedData->getExpectedRedirectAfterPost('public_announcement_page'),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * フレーム追加のテストデータ
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
