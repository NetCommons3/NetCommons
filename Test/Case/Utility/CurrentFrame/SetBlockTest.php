<?php
/**
 * CurrentFrame::setBlock()のテスト
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
 * CurrentFrame::setBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentFrame
 */
class NetCommonsUtilityCurrentFrameSetBlockTest extends NetCommonsCurrentUtilityBase {

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
 * POSTリクエストのテスト
 *
 * @return void
 */
	public function testPost() {
		//データ生成
		Current::$request->data['Block']['id'] = '2';

		//テスト実施
		$this->CurrentFrame->setBlock();

		//チェック
		$this->__assertBlockHeader();
	}

/**
 * 引数$blockIdがある場合のテスト
 *
 * @return void
 */
	public function testWithFrameId() {
		//データ生成
		$blockId = '2';

		//テスト実施
		$this->CurrentFrame->setBlock($blockId);

		//チェック
		$this->__assertBlockHeader();
	}

/**
 * Current::$current['Frame']がある場合のテスト
 *
 * @return void
 */
	public function testWithFrame() {
		//データ生成
		$blockId = '2';
		Current::$current['Frame'] = array(
			'id' => '9999',
			'key' => 'frame_9999',
		);

		//テスト実施
		$this->CurrentFrame->setBlock($blockId);

		//チェック
		$expected = array(
			'Frame' => array(
				'id' => '9999',
				'key' => 'frame_9999',
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
		);
		$this->__assertBlockHeader($expected, array('Frame', 'Box', 'Space', 'FramePublicLanguage', 'FramesLanguage'));
	}

/**
 * block_id=2の評価
 *
 * @param array $mergeExpected $expectedにマージするデータ
 * @param array $removeKeys $expectedから削除するデータ
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __assertBlockHeader($mergeExpected = array(), $removeKeys = array()) {
		Current::$current = Hash::remove(Current::$current, '{s}.created_user');
		Current::$current = Hash::remove(Current::$current, '{s}.created');
		Current::$current = Hash::remove(Current::$current, '{s}.modified_user');
		Current::$current = Hash::remove(Current::$current, '{s}.modified');

		$default = array(
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
			'Language' => array(
				'id' => '2',
			//	'code' => 'ja',
			//	'weight' => '2',
			//	'is_active' => true,
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
			'BlocksLanguage' => array(
				//'id' => '2',
				'language_id' => '2',
				'block_id' => '2',
				'name' => 'Block name 1',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
			),
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
			'FramePublicLanguage' => array(
				'id' => '1',
				'language_id' => '0',
				'frame_id' => '2',
				'is_public' => true,
			),
			'FramesLanguage' => array(
				'id' => '2',
				'language_id' => '2',
				'is_original_copy' => false,
				'frame_id' => '2',
				'name' => 'Test frame header',
				'is_origin' => true,
				'is_translation' => false,
				'is_original_copy' => false,
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

}
