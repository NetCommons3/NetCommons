<?php
/**
 * Frame Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsFrame', 'NetCommons.Model');


/**
 * Summary for Announcement Test Case
 */
class NetCommonsFrameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.net_commons_frame',
		'plugin.net_commons.net_commons_block',
		'app.room_part',
		'app.part',
		'app.language',
		'app.languages_part',
		'app.parts_rooms_user'
	);

	public $Frame;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Frame = ClassRegistry::init('NetCommons.NetCommonsFrame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Frame);
		parent::tearDown();
	}

/**
 * getBlockId
 *
 * @return void
 */
	public function testGetBlockId() {
		//frame 自体が無い
		$frameId = 1000000;
		$rtn = $this->Frame->getBlockId($frameId);
		$this->assertNull($rtn);

		$frameId = 1;
		$rtn = $this->Frame->getBlockId($frameId);
		$this->assertTextEquals(1, $rtn);
	}

/**
 * create Block
 *
 * @return void
 */
	public function testCreateBlock() {
		$frameId = 1;
		$userId = 1;
		$rtn = $this->Frame->createBlock($frameId, $userId);
		$this->assertTrue(is_array($rtn));

		$frameId = 100000000;
		$userId = 1;
		$rtn = $this->Frame->createBlock($frameId, $userId);
		$this->assertNull($rtn);
	}

/**
 * update block id
 *
 * @return void
 */
	public function testUpdateBlockId() {
		$frameId = 1;
		$blockId = 2;
		$userId = 1;
		$rtn = $this->Frame->updateBlockId($frameId, $blockId, $userId);
		$this->assertEquals(true, is_array($rtn));

		$frameId = 0;
		$blockId = 'A';
		$userId = 1;
		$rtn = $this->Frame->updateBlockId($frameId, $blockId, $userId);
		$this->assertEquals(false, $rtn);
	}
}
