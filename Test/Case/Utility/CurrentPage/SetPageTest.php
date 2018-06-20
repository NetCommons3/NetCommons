<?php
/**
 * CurrentPage::setPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsCurrentUtilityBase', 'NetCommons.TestSuite');
App::uses('CurrentPage', 'NetCommons.Utility');

/**
 * CurrentPage::setPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentPage
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NetCommonsUtilityCurrentPageSetPageTest extends NetCommonsCurrentUtilityBase {

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

		$this->CurrentPage = new CurrentPage();
		Current::$current['Language']['id'] = '2';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CurrentPage);
		parent::tearDown();
	}

/**
 * page_idの指定なし
 *
 * @return void
 */
	public function testNoPageIdWOPlugin() {
		//データ生成

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$expected = array(
			'Language' => array(
				'id' => '2',
			),
		);
		$this->assertEquals(Current::$current, $expected);
	}

/**
 * page_idの指定なしでプラグイン指定
 *
 * @return void
 */
	public function testNoPageIdWithPlugin() {
		//データ生成
		Current::$request->params['plugin'] = 'blogs';

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * Current::$request->dataにPage.idがある
 *
 * @return void
 */
	public function testRequestData() {
		//データ生成
		Current::$request->data['Page']['id'] = '4';

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * pagesプラグインのpagesコントローラで、ホームの場合
 *
 * @return void
 */
	public function testPagesRoot() {
		//データ生成
		Current::$request->params['plugin'] = 'pages';
		Current::$request->params['controller'] = 'pages';
		Current::$request->params['pass'] = [];
		Current::$request->params['pageView'] = true;

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * pagesプラグインのpagesコントローラで、permalinkあり
 *
 * @return void
 */
	public function testPagesWithPermalink() {
		//データ生成
		Current::$request->params['plugin'] = 'pages';
		Current::$request->params['controller'] = 'pages';
		Current::$request->params['pass'] = ['test4'];
		Current::$request->params['pageView'] = true;

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$expected = [
			'Page' => [
				'id' => '7',
				'room_id' => '2',
				'root_id' => '1',
				'parent_id' => '4',
				//'lft' => '3',
				//'rght' => '4',
				'permalink' => 'test4',
				'slug' => 'test4',
				'full_permalink' => 'test4',
			],
		];
		$this->__assertCurrent($expected);
	}

/**
 * pagesプラグインのpages_editコントローラで、page_idあり
 *
 * @return void
 */
	public function testPagesEditWithPageId() {
		//データ生成
		Current::$request->params['plugin'] = 'pages';
		Current::$request->params['controller'] = 'pages_edit';
		Current::$request->params['pass'] = ['2', '4'];
		Current::$request->params['pageEdit'] = true;

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * pagesプラグインのpages_editコントローラで、page_idなし
 *
 * @return void
 */
	public function testPagesEditWOPageId() {
		//データ生成
		Current::$request->params['plugin'] = 'pages';
		Current::$request->params['controller'] = 'pages_edit';
		Current::$request->params['pass'] = ['2'];
		Current::$request->params['pageEdit'] = true;

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * Current::$request->queryにpage_idがある
 *
 * @return void
 */
	public function testQueryWithPageId() {
		//データ生成
		Current::$request->query['page_id'] = '4';

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$this->__assertCurrent();
	}

/**
 * usersプラグイン
 *
 * @return void
 */
	public function testUsersPlugin() {
		//データ生成
		Current::$request->params['plugin'] = 'users';
		Current::$current['User']['id'] = '1';

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$expected = [
			'User' => [
				'id' => '1',
			],
			'Room' => [
				'id' => '7',
				'space_id' => '3',
				'page_id_top' => '10',
				'parent_id' => '3',
				//'lft' => '10',
				//'rght' => '11',
				'active' => true,
				//'in_draft' => false,
				'default_role_key' => 'room_administrator',
				'need_approval' => false,
				'default_participation' => false,
				'page_layout_permitted' => false,
				'theme' => null,
			],
			'RolesRoomsUser' => [
				'id' => '12',
				'roles_room_id' => '16',
				'user_id' => '1',
				'room_id' => '7',
				'access_count' => '0',
				'last_accessed' => null,
				'previous_accessed' => null,
			],
			'Page' => [
				'id' => '10',
				'room_id' => '7',
				'root_id' => '2',
				'parent_id' => '2',
				//'lft' => '10',
				//'rght' => '11',
				'permalink' => 'user_administrator',
				'slug' => 'user_administrator',
				'is_container_fluid' => false,
				'theme' => null,
				'full_permalink' => 'private/user_administrator',
			],
			'Space' => [
				'id' => '3',
				'parent_id' => '1',
				//'lft' => '4',
				//'rght' => '5',
				'type' => '3',
				'plugin_key' => 'private_space',
				'default_setting_action' => '',
				'room_disk_size' => null,
				'room_id_root' => '3',
				'page_id_top' => '2',
				'permalink' => 'private',
				'is_m17n' => false,
				'after_user_save_model' => null,
			],
		];
		$this->__assertCurrent($expected);
	}

/**
 * groupsプラグイン
 *
 * @return void
 */
	public function testGroupsPlugin() {
		//データ生成
		Current::$request->params['plugin'] = 'groups';
		Current::$current['User']['id'] = '1';

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$expected = [
			'User' => [
				'id' => '1',
			],
			'Room' => [
				'id' => '7',
				'space_id' => '3',
				'page_id_top' => '10',
				'parent_id' => '3',
				//'lft' => '10',
				//'rght' => '11',
				'active' => true,
				//'in_draft' => false,
				'default_role_key' => 'room_administrator',
				'need_approval' => false,
				'default_participation' => false,
				'page_layout_permitted' => false,
				'theme' => null,
			],
			'RolesRoomsUser' => [
				'id' => '12',
				'roles_room_id' => '16',
				'user_id' => '1',
				'room_id' => '7',
				'access_count' => '0',
				'last_accessed' => null,
				'previous_accessed' => null,
			],
			'Page' => [
				'id' => '10',
				'room_id' => '7',
				'root_id' => '2',
				'parent_id' => '2',
				//'lft' => '10',
				//'rght' => '11',
				'permalink' => 'user_administrator',
				'slug' => 'user_administrator',
				'is_container_fluid' => false,
				'theme' => null,
				'full_permalink' => 'private/user_administrator',
			],
			'Space' => [
				'id' => '3',
				'parent_id' => '1',
				//'lft' => '4',
				//'rght' => '5',
				'type' => '3',
				'plugin_key' => 'private_space',
				'default_setting_action' => '',
				'room_disk_size' => null,
				'room_id_root' => '3',
				'page_id_top' => '2',
				'permalink' => 'private',
				'is_m17n' => false,
				'after_user_save_model' => null,
			],
		];
		$this->__assertCurrent($expected);
	}

/**
 * Current::$current['Room']がある
 *
 * @return void
 */
	public function testWithRoom() {
		//データ生成
		Current::$current['Room'] = [
			'id' => '7',
			'space_id' => '3',
			'page_id_top' => '10',
			'parent_id' => '3',
			//'lft' => '10',
			//'rght' => '11',
			'active' => true,
			//'in_draft' => false,
			'default_role_key' => 'room_administrator',
			'need_approval' => false,
			'default_participation' => false,
			'page_layout_permitted' => false,
			'theme' => null,
		];

		//テスト実施
		$this->CurrentPage->setPage();

		//チェック
		$expected = [
			'Room' => [
				'id' => '7',
				'space_id' => '3',
				'page_id_top' => '10',
				'parent_id' => '3',
				//'lft' => '10',
				//'rght' => '11',
				'active' => true,
				//'in_draft' => false,
				'default_role_key' => 'room_administrator',
				'need_approval' => false,
				'default_participation' => false,
				'page_layout_permitted' => false,
				'theme' => null,
			],
			'Page' => [
				'id' => '10',
				'room_id' => '7',
				'root_id' => '2',
				'parent_id' => '2',
				//'lft' => '10',
				//'rght' => '11',
				'permalink' => 'user_administrator',
				'slug' => 'user_administrator',
				'is_container_fluid' => false,
				'theme' => null,
				'full_permalink' => 'private/user_administrator',
			],
			'Space' => [
				'id' => '3',
				'parent_id' => '1',
				//'lft' => '4',
				//'rght' => '5',
				'type' => '3',
				'plugin_key' => 'private_space',
				'default_setting_action' => '',
				'room_disk_size' => null,
				'room_id_root' => '3',
				'page_id_top' => '2',
				'permalink' => 'private',
				'is_m17n' => false,
				'after_user_save_model' => null,
			],
		];
		$this->__assertCurrent($expected);
	}

/**
 * Current::$currenの評価
 *
 * @param array $mergeExpected $expectedにマージするデータ
 * @param array $removeKeys $expectedから削除するデータ
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __assertCurrent($mergeExpected = array(), $removeKeys = array()) {
		$default = array(
			'Language' => array(
				'id' => '2',
			),
			'Page' => array(
				'id' => '4',
				'room_id' => '2',
				'root_id' => '1',
				'parent_id' => '1',
				//'lft' => '2',
				//'rght' => '5',
				'permalink' => 'home',
				'slug' => 'home',
				'is_container_fluid' => false,
				'theme' => null,
				'full_permalink' => 'home',
			),
			'Room' => array(
				'id' => '2',
				'space_id' => '2',
				'page_id_top' => '4',
				'parent_id' => '1',
				//'lft' => '2',
				//'rght' => '7',
				'active' => true,
				//'in_draft' => false,
				'default_role_key' => 'visitor',
				'need_approval' => true,
				'default_participation' => true,
				'page_layout_permitted' => true,
				'theme' => null,
			),
			'Space' => array(
				'id' => '2',
				'parent_id' => '1',
				//'lft' => '2',
				//'rght' => '3',
				'type' => '2',
				'plugin_key' => 'public_space',
				'default_setting_action' => 'rooms/index/2',
				'room_disk_size' => null,
				'room_id_root' => '2',
				'page_id_top' => '1',
				'permalink' => '',
				'is_m17n' => true,
				'after_user_save_model' => null,
			),
		);

		foreach ($removeKeys as $keyPath) {
			$default = Hash::remove($default, $keyPath);
		}

		$expected = Hash::merge($default, $mergeExpected);

		$this->assertEquals(Current::$current, $expected);
	}

}
