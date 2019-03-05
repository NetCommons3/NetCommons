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
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		NetCommonsCurrentLibTestUtility::resetCurrentLib();
		parent::tearDown();
	}

/**
 * 管理者ログインのGETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @dataProvider caseAdministratorByGet
 * @return void
 */
	public function testAdministratorByGet($controller, $url, $expects, $exception) {
		NetCommonsCurrentLibTestUtility::login('1');

		$this->generate($controller);
		NetCommonsCurrentLibTestUtility::testControllerGetMethod(
			$this, $url, $expects, $exception
		);

		NetCommonsCurrentLibTestUtility::logout();
	}

/**
 * 管理者ログインのPOSTテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @dataProvider caseAdministratorByPost
 * @return void
 */
	public function testAdministratorByPost($controller, $url, $post, $expects, $exception) {
		NetCommonsCurrentLibTestUtility::login('1');

		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostMethod(
			$this, $url, $post, $expects, $exception
		);

		NetCommonsCurrentLibTestUtility::logout();
	}

/**
 * 管理者ログインのGETテストのデータ
 *
 * @return array テストデータ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function caseAdministratorByGet() {
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
			'プライベート(一般ユーザ1)の予定の表示' => [
				'controller' => 'Calendars.CalendarPlans',
				'/calendars/calendar_plans/view/calendar_event_key_786?frame_id=11',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
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
 * 管理者ログインのPOSTテストのデータ
 *
 * @return array テストデータ
 */
	public function caseAdministratorByPost() {
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

}
