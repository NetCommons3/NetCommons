<?php
/**
 * NetCommonsPartsRoomsUser Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsPartsRoomsUser', 'NetCommons.Model');


/**
 * Summary for Announcement Test Case
 */
class NetCommonsPartsRoomsUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.net_commons_room',
		'app.room_part',
		'app.part',
		'app.language',
		'app.languages_part',
		'app.parts_rooms_user'
	);

	public $PartsRoomsUser;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PartsRoomsUser = ClassRegistry::init('NetCommons.NetCommonsPartsRoomsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PartsRoomsUser);
		parent::tearDown();
	}

/**
 * ユーザのルーム内のパートを取得する
 *
 * @return void
 */
	public function testGetRoomPart() {
		$roomId = 1;
		$userId = 1;
		$rtn = $this->PartsRoomsUser->getRoomPart($roomId, $userId);
		$this->assertTextEquals($userId, $rtn["NetCommonsPartsRoomsUser"]['user_id']);
		$this->assertTextEquals($roomId, $rtn["NetCommonsPartsRoomsUser"]['room_id']);
	}

/**
 * ユーザのルーム内のパートを取得する
 * パラメータが足りない場合
 *
 * @return void
 */
	public function testGetRoomPartIdNull() {
		$roomId = 1;
		$userId = null;
		$rtn = $this->PartsRoomsUser->getRoomPart($roomId, $userId);
		$this->assertEquals(array(), $rtn);

		$roomId = null;
		$userId = 1;
		$rtn = $this->PartsRoomsUser->getRoomPart($roomId, $userId);
		$this->assertEquals(array(), $rtn);

		$roomId = null;
		$userId = null;
		$rtn = $this->PartsRoomsUser->getRoomPart($roomId, $userId);
		$this->assertEquals(array(), $rtn);
	}

/**
 * ユーザのルーム内のパートを取得する
 * 該当するルームがない場合
 *
 * @return void
 */
	public function testGetRoomPartIdNoticeRool() {
		$roomId = 100000000;
		$userId = 1;
		$rtn = $this->PartsRoomsUser->getRoomPart($roomId, $userId);
		$this->assertEquals(array(), $rtn);
	}
}
