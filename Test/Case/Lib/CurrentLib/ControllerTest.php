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
App::uses('CurrentLibControllerTestData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLib', 'NetCommons.Lib');
App::uses('Current', 'NetCommons.Utility');

/**
 * Current::initialize()のControllerテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\CurrentLib
 */
class NetCommonsLibCurrentLibControllerTest extends ControllerTestCase {

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
 * GETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @return void
 */
	private function __testByGet($controller, $url, $expects, $exception) {
		if ($expects === false) {
			$this->setExpectedException($exception);
		}

		$this->testAction($url, ['method' => 'GET', 'return' => 'view']);

		if ($expects !== false) {
			foreach ($expects as $assert => $expect) {
				foreach ($expect as $ex) {
					$this->$assert($ex, $this->contents);
				}
			}
		}
	}

/**
 * ログインなしのGETテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @dataProvider caseWithoutLoginByGet
 * @return void
 */
	public function testWithoutLoginByGet($controller, $url, $expects, $exception) {
		$this->generate($controller);
		$this->__testByGet($controller, $url, $expects, $exception);
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
		$this->__testByGet($controller, $url, $expects, $exception);

		NetCommonsCurrentLibTestUtility::logout();
	}

/**
 * ログインなしのGETテストのデータ
 *
 * @return array テストデータ
 */
	public function caseWithoutLoginByGet() {
		//@var CurrentLibControllerTestData
		$TestData = new CurrentLibControllerTestData();

		$results = [
			'トップページ' => [
				'controller' => 'Pages.Pages',
				'url' => '/',
				'expects' => [
					'assertContains' => array_merge(
						$TestData->getExpectedAnnouncement(['toppage']),
						$TestData->getExpectedFrame(['menu']),
						$TestData->getExpectedMenuList(['public'])
					),
					'assertNotContains' => array_merge(
						$TestData->getExpectedMenuList(['private', 'community_1', 'community_2']),
						$TestData->getExpectedSettingMode('on')
					),
				],
				'exception' => false,
			],
			'管理者のマイルーム' => [
				'controller' => 'Pages.Pages',
				'url' => '/private/private_room_system_admistrator',
				'expects' => false,
				'exception' => 'ForbiddenException',
			],
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
 * 管理者ログインのGETテストのデータ
 *
 * @return array テストデータ
 */
	public function caseAdministratorByGet() {
		//@var CurrentLibControllerTestData
		$TestData = new CurrentLibControllerTestData();

		$results = [
			'トップページ' => [
				'controller' => 'Pages.Pages',
				'url' => '/',
				'expects' => [
					'assertContains' => array_merge(
						$TestData->getExpectedAnnouncement(['toppage']),
						$TestData->getExpectedFrame(['menu']),
						$TestData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$TestData->getExpectedSettingMode('on')
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
						$TestData->getExpectedAnnouncement(['private']),
						$TestData->getExpectedFrame(['menu']),
						$TestData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$TestData->getExpectedSettingMode('on')
					),
					'assertNotContains' => [],
				],
				'exception' => false,
			],
			'お知らせのブロック設定表示[Community room 1]' => [
				'controller' => 'Announcements.AnnouncementBlocks',
				'/announcements/announcement_blocks/edit/11?frame_id=16',
				'expects' => [
					'assertContains' => array_merge(
						$TestData->getExpectedFrame(['menu', 'community_1_announcement_edit_1']),
						$TestData->getExpectedMenuList([
							'public', 'private', 'community_1', 'community_2'
						]),
						$TestData->getExpectedSettingMode('off'),
						$TestData->getExpectedAnnouncement(['community_1_edit'])
					),
					'assertNotContains' => [],
					'assertRegExp' =>
						$TestData->getExpectedBlockSettingTabs('announcement', 'block_setting')
				],
				'exception' => false,
			]
		];

		return $results;
	}

}
