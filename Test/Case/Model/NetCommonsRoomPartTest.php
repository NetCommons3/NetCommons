<?php
/**
 * NetCommons RoomPart Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsPart', 'NetCommons.Model');
App::uses('NetCommonsRoom', 'NetCommons.Model');
App::uses('LanguagesPart', 'NetCommons.Model');


/**
 * Summary for Announcement Test Case
 */
class AnnouncementRoomPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.room_part',
		'app.part',
		'app.language',
		'app.languages_part'
	);

/**
 * RoomPart class object
 *
 * @var object
 */
	public $RoomPart;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoomPart = ClassRegistry::init('NetCommons.NetCommonsRoomPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoomPart);
		parent::tearDown();
	}

/**
 * getList
 *
 * @return void
 */
	public function testGetList() {
		$rtn = $this->RoomPart->getList();
		$this->assertTrue(isset($rtn));
	}

/**
 * blockの設定を作成するテスト
 * 配列名を変換し、blockidを追加した値を返す
 *
 * @return void
 */
	public function testGetBlockPartConfig() {
		$ans = array (
			1 => array (
				'part_id' => '2',
				'read_content' => '1',
				'edit_content' => '1',
				'create_content' => '1',
				'publish_content' => 0, //DB上は2だが可変なので0に変換されている
				'block_id' => 10,
				'create_user_id' => 1,
				'modified_user_id' => 1
			),
		);
		//block_id:10でinsert用配列が戻る
		$rtn = $this->RoomPart->getBlockPartConfig(10, 1);
		$this->assertEquals($ans[1], $rtn[1]);
		//block_id :100 配列名test
		$ans = array (
			0 =>
				array (
					'part_id' => '1',
					'read_content' => '1',
					'edit_content' => '1',
					'create_content' => '1',
					'publish_content' => '1',
					'block_id' => 100,
					'create_user_id' => 1,
					'modified_user_id' => 1
				),
		);
		$rtn = $this->RoomPart->getBlockPartConfig(100, 1);
		$this->assertEquals($ans[0], $rtn[0]);
	}

/**
 * 可変可能なレコードを返す
 *
 * @return void
 */
	public function testGetVariableListPublishContent() {
		$abilityName = 'publish_content';
		$rtn = $this->RoomPart->getVariableList($abilityName);
		$this->assertEquals(2, count($rtn));
	}

/**
 * 可変可能なレコードを返す
 *
 * @return void
 */
	public function testGetVariableListCreateContent() {
		$abilityName = 'create_content';
		$rtn = $this->RoomPart->getVariableList($abilityName);
		$this->assertEquals(0, count($rtn));

		$abilityName = '';
		$rtn = $this->RoomPart->getVariableList($abilityName);
		$this->assertEquals(0, count($rtn));
	}

/**
 * 可変可能なレコードを返す : 公開の場合 edit_contentが必要
 *
 * @return void
 */
	public function testGetVariableListPartIds() {
		$abilityName = 'publish_content';
		$rtn = $this->RoomPart->getVariableListPartIds($abilityName);
		$this->assertEquals(2, count($rtn));
	}
}
