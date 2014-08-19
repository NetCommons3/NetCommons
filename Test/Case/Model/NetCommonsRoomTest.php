<?php
/**
 * Announcement Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsFrame', 'NetCommons.Model');


/**
 * Summary for Announcement Test Case
 */
class NetCommonsRoomTest extends CakeTestCase {

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

	public $Room;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Room = ClassRegistry::init('NetCommons.NetCommonsRoom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Room);
		parent::tearDown();
	}

/**
 * testCheckApprovalTrue
 *
 * @return void
 */
	public function testCheckApprovalTrue() {
		$roomId = 1;
		$rtn = $this->Room->checkApproval($roomId);
		$this->assertTrue($rtn);
	}

/**
 * testCheckApprovalFalse
 *
 * @return void
 */
	public function testCheckApprovalFalse() {
		$roomId = 2;
		$rtn = $this->Room->checkApproval($roomId);
		$this->assertFalse($rtn);
	}

/**
 * testCheckApprovalFalse
 *
 * @return void
 */
	public function testCheckApprovalNotice() {
		$roomId = 1000;
		$rtn = $this->Room->checkApproval($roomId);
		$this->assertFalse($rtn);
	}
}
