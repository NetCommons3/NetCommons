<?php
/**
 * CurrentFrame::setFrame()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCurrentUtilityBase', 'NetCommons.TestSuite');
App::uses('CurrentFrame', 'NetCommons.Utility');

/**
 * CurrentFrame::setFrame()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentFrame
 */
class NetCommonsUtilityCurrentFrameSetFrameTest extends NetCommonsCurrentUtilityBase {

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

		$this->CurrentFrame = new CurrentFrame();
		Current::$current['Language']['id'] = '2';
	}

/**
 * データなし、リクエストなしのテスト
 *
 * @return void
 */
	public function testNoData() {
		//データ生成
		Current::$current = array();

		//テスト実施
		$this->CurrentFrame->setFrame();

		$expected = array();
		$this->assertEquals(Current::$current, $expected);
	}

/**
 * POSTリクエストのテスト
 *
 * @return void
 */
	public function testPost() {
		//データ生成
		Current::$request->data['Frame']['id'] = '2';

		//テスト実施
		$this->CurrentFrame->setFrame();

		//チェック
		$this->__assertFrameHeader();
	}

/**
 * GETリクエスト(params['?']['frame_id'])のテスト
 * ※query['frame_id']になるため、基本的にないが念のため
 *
 * @return void
 */
	public function testGetParams() {
		//データ生成
		Current::$request->params['?']['frame_id'] = '2';

		//テスト実施
		$this->CurrentFrame->setFrame();

		//チェック
		$this->__assertFrameHeader();
	}

/**
 * GETリクエスト(query['frame_id'])のテスト
 *
 * @return void
 */
	public function testGetQuery() {
		//データ生成
		Current::$request->query['frame_id'] = '2';

		//テスト実施
		$this->CurrentFrame->setFrame();

		//チェック
		$this->__assertFrameHeader();
	}

/**
 * ブロック追加のテスト
 *
 * @return void
 */
	public function testBlockAdd() {
		//データ生成
		Current::$request->data['Frame']['id'] = '2';
		Current::$layout = 'NetCommons.setting';
		Current::$request->params['controller'] = 'test_frame_blocks';
		Current::$request->params['action'] = 'add';

		//テスト実施
		$this->CurrentFrame->setFrame();

		//チェック
		$this->__assertFrameHeader(array(
			'Block' => array(
				'public_type' => '1',
				'content_count' => '0',
				'room_id' => '1',
				'plugin_key' => 'blocks',
				'key' => '',
				'publish_start' => null,
				'publish_end' => null,
				'id' => null,
			)
		));
	}

/**
 * フレーム追加のテスト
 *
 * @return void
 */
	public function testFrameAdd() {
		//データ生成
		Current::$request->data['Frame']['box_id'] = '1';
		Current::$layout = 'NetCommons.setting';
		Current::$request->params['controller'] = 'frames';
		Current::$request->params['action'] = 'add';

		//テスト実施
		$this->CurrentFrame->setFrame();

		//チェック
		$this->__assertFrameHeader(array(), array('Frame', 'Block', 'BlocksLanguage', 'FramePublicLanguage', 'FramesLanguage', 'Plugin'));
	}

/**
 * setBox()で取得したRoomがおかしい場合のテスト
 *
 * @return void
 */
	public function testSetBoxOnRoomFailure() {
		//データ生成
		$frameId = '2';

		$query = array(
			'recursive' => 0,
			'conditions' => array(
				'Box.id' => '1',
			),
		);
		$result = array(
			'Room' => array(
				'id' => '999',
				'space_id' => '999',
				'page_id_top' => null,
				'root_id' => null,
				'parent_id' => null,
				'lft' => null,
				'rght' => null,
				'active' => null,
				'in_draft' => null,
				'default_role_key' => null,
				'need_approval' => null,
				'default_participation' => null,
				'page_layout_permitted' => null,
				'theme' => null,
			),
			'Space' => array(
				'id' => '1',
				'parent_id' => null,
				'lft' => '1',
				'rght' => '8',
				'type' => '1',
				'plugin_key' => null,
				'default_setting_action' => null,
				'room_disk_size' => null,
				'room_id_root' => '2',
				'permalink' => '',
				'is_m17n' => false,
				'after_user_save_model' => null,
			),
		);
		$this->CurrentFrame->Box = $this->getMock('Box', array('find'));
		$this->CurrentFrame->Box
			->expects($this->once())->method('find')
			->with('first', $query)
			->will($this->returnValue($result));

		//テスト実施
		$this->CurrentFrame->setFrame($frameId);

		//チェック
		$this->__assertFrameHeader();
	}

/**
 * setBox()で取得したRoomがおかしい場合のテスト
 *
 * @return void
 */
	public function testMainContainre() {
		//データ生成
		$frameId = '6';

		//テスト実施
		$this->CurrentFrame->setFrame($frameId);

		//チェック
		$this->__assertFrameMain();
	}

/**
 * frame_id=2の評価
 *
 * @param array $mergeExpected $expectedにマージするデータ
 * @param array $removeKeys $expectedから削除するデータ
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __assertFrameHeader($mergeExpected = array(), $removeKeys = array()) {
		Current::$current = Hash::remove(Current::$current, '{s}.created_user');
		Current::$current = Hash::remove(Current::$current, '{s}.created');
		Current::$current = Hash::remove(Current::$current, '{s}.modified_user');
		Current::$current = Hash::remove(Current::$current, '{s}.modified');

		$default = array(
			'Frame' => array(
				'id' => '2',
				'room_id' => '1',
				'box_id' => '1',
				'plugin_key' => 'test_frames',
				'block_id' => '2',
				'key' => 'frame_header',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			),
			'Box' => array(
				'id' => '1',
				'container_id' => null,
				'type' => '1',
				'space_id' => '1',
				'room_id' => '1',
				'page_id' => null,
				'container_type' => '1',
				'weight' => null,
			),
			'Language' => array(
				'id' => '2',
				//'code' => 'ja',
				//'weight' => '2',
				//'is_active' => true,
			),
			'Block' => array(
				'id' => '2',
				//Frameのroom_idとBlockのroom_idが異なることは、基本あり得ないが。テストで使っているFixtureの関係上、当データの結果となる
				'room_id' => '2',
				'plugin_key' => 'test_frames',
				'key' => 'block_1',
				'public_type' => '1',
				'publish_start' => null,
				'publish_end' => null,
				'content_count' => '0',
			),
			'Room' => array(
				'id' => '1',
				'space_id' => '1',
				'page_id_top' => null,
				'root_id' => null,
				'parent_id' => null,
				'lft' => '1',
				'rght' => '12',
				'active' => true,
				'in_draft' => false,
				'default_role_key' => 'visitor',
				'need_approval' => true,
				'default_participation' => true,
				'page_layout_permitted' => false,
				'theme' => null,
			),
			'Plugin' => array(
				'id' => '2',
				'language_id' => '2',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
				'key' => 'test_frames',
				'is_m17n' => true,
				'name' => 'Lorem ipsum dolor sit amet',
				'namespace' => 'Lorem ipsum dolor sit amet',
				'weight' => '1',
				'type' => '1',
				'version' => null,
				'commit_version' => null,
				'commited' => null,
				'default_action' => '',
				'default_setting_action' => '',
				'frame_add_action' => null,
				'display_topics' => false,
				'display_search' => false,
				'serialize_data' => null,
			),
			'FramePublicLanguage' => array(
				'id' => '1',
				'language_id' => '0',
				'frame_id' => '2',
				'is_public' => true,
			),
			'FramesLanguage' => array(
				'id' => '2',
				'language_id' => '2',
				'frame_id' => '2',
				'name' => 'Test frame header',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
				'is_original_copy' => false,
			),
			'BlocksLanguage' => array(
				//'id' => '2',
				'language_id' => '2',
				'block_id' => '2',
				'name' => 'Block name 1',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
				'is_original_copy' => false,
			),
			'Space' => array(
				'id' => '1',
				'parent_id' => null,
				'lft' => '1',
				'rght' => '8',
				'type' => '1',
				'plugin_key' => null,
				'default_setting_action' => null,
				'room_disk_size' => null,
				'room_id_root' => '2',
				'permalink' => '',
				'is_m17n' => false,
				'after_user_save_model' => null,
			),
		);

		foreach ($removeKeys as $keyPath) {
			$default = Hash::remove($default, $keyPath);
		}

		$expected = Hash::merge($default, $mergeExpected);

		$this->assertEquals(Current::$current, $expected);
	}

/**
 * frame_id=6の評価
 *
 * @param array $mergeExpected $expectedにマージするデータ
 * @param array $removeKeys $expectedから削除するデータ
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __assertFrameMain($mergeExpected = array(), $removeKeys = array()) {
		Current::$current = Hash::remove(Current::$current, '{s}.created_user');
		Current::$current = Hash::remove(Current::$current, '{s}.created');
		Current::$current = Hash::remove(Current::$current, '{s}.modified_user');
		Current::$current = Hash::remove(Current::$current, '{s}.modified');

		$default = array(
			'Frame' => array(
				'id' => '6',
				'room_id' => '2',
				'box_id' => '28',
				'plugin_key' => 'test_frames',
				'block_id' => '2',
				'key' => 'frame_3',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			),
			'Plugin' => array(
				'id' => '2',
				'language_id' => '2',
				'is_m17n' => true,
				'key' => 'test_frames',
				'name' => 'Lorem ipsum dolor sit amet',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
				'namespace' => 'Lorem ipsum dolor sit amet',
				'weight' => '1',
				'type' => '1',
				'version' => null,
				'commit_version' => null,
				'commited' => null,
				'default_action' => '',
				'default_setting_action' => '',
				'frame_add_action' => null,
				'display_topics' => false,
				'display_search' => false,
				'serialize_data' => null,
			),
			'FramePublicLanguage' => array(
				'id' => '5',
				'language_id' => '0',
				'frame_id' => '6',
				'is_public' => true,
			),
			'FramesLanguage' => array(
				'id' => '6',
				'language_id' => '2',
				'frame_id' => '6',
				'name' => 'Test frame main',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
			),
			'Box' => array(
				'id' => '28',
				'container_id' => null,
				'type' => '4',
				'space_id' => '2',
				'room_id' => '2',
				'page_id' => '2',
				'container_type' => '3',
				'weight' => null,
			),
			'Language' => array(
				'id' => '2',
				//'code' => 'ja',
				//'weight' => '2',
				//'is_active' => true,
			),
			'Block' => array(
				'id' => '2',
				'room_id' => '2',
				'plugin_key' => 'test_frames',
				'key' => 'block_1',
				'public_type' => '1',
				'publish_start' => null,
				'publish_end' => null,
				'content_count' => '0',
			),
			'BlocksLanguage' => array(
				//'id' => '2',
				'language_id' => '2',
				'block_id' => '2',
				'name' => 'Block name 1',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
			),
			'Room' => array(
				'id' => '2',
				'space_id' => '2',
				'page_id_top' => '1',
				'root_id' => null,
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '7',
				'active' => true,
				'in_draft' => false,
				'default_role_key' => 'visitor',
				'need_approval' => true,
				'default_participation' => true,
				'page_layout_permitted' => true,
				'theme' => null,
			),
			'Space' => array(
				'id' => '2',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '3',
				'type' => '2',
				'plugin_key' => 'public_space',
				'default_setting_action' => 'rooms/index/2',
				'room_disk_size' => null,
				'room_id_root' => '2',
				'permalink' => '',
				'is_m17n' => true,
				'after_user_save_model' => null,
			),
			'BoxesPageContainer' => array(
				'id' => '58',
				'page_container_id' => '8',
				'page_id' => '2',
				'container_type' => '3',
				'box_id' => '28',
				'is_published' => true,
				'weight' => '1',
			),
			'PageContainer' => array(
				'id' => '8',
				'page_id' => '2',
				'container_type' => '3',
				'is_published' => true,
				'is_configured' => false,
			),
			'Page' => array(
				'id' => '2',
				'room_id' => '2',
				'root_id' => '1',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '3',
				'permalink' => 'home',
				'slug' => 'home',
				'is_container_fluid' => true,
				'theme' => null,
			),
		);

		foreach ($removeKeys as $keyPath) {
			$default = Hash::remove($default, $keyPath);
		}

		$expected = Hash::merge($default, $mergeExpected);

		$this->assertEquals(Current::$current, $expected);
	}

}
