<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('NetCommonsPluginComponent', 'NetCommons.Controller/Component');

/**
 * components test controller
 */
class TestNetCommonsPluginTestController extends Controller {

/**
 * components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsPluginComponent'
	);

/**
 * models
 *
 * @var array
 */
	public $uses = array(
		'NetCommons.NetCommonsPartsRoomsUser',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomPart',
		'NetCommons.NetCommonsRoom',
		'NetCommons.NetCommonsBlock',
	);

	public $Auth = null;

/**
 * 準備
 *
 * @return void
 */
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
	}

/**
 * set auth class
 *
 * @param int $type login status
 * @return void
 */
	public function setAuth($type = "") {
		$this->Auth = new TestNetCommonsPluginMockAuth();
		$this->Auth->login = $type;
	}

}


/**
 * テスト本体
 * Class AssetComponentTest
 */
class TestNetCommonsPluginMockAuth {

/**
 * login flag
 *
 * @var int
 */
	public $login = "";

/**
 * user mock
 *
 * @param string $type
 * @return array|null
 */
	public function user($type = "") {
		if (! $this->login) {
			return null;
		}
		$user = array(
			'id' => 1,
			'username' => 'admin'
		);
		if ($type && isset($user[$type])) {
			return $user[$type];
		}
		if (! $type) {
			return $user;
		}
	}

/**
 * loggedIn
 *
 * @return bool
 */
	public function loggedIn() {
		return true;
	}

}


/**
 * Class NetCommonsPluginComponentTest
 */
class NetCommonsPluginComponentTest extends CakeTestCase {

	public $Controller = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.session',
		'app.site_setting',
		'app.site_setting_value',
		'app.room_part',
		'app.languages_part',
		'plugin.net_commons.net_commons_room',
		'plugin.net_commons.net_commons_parts_rooms_user',
		'plugin.net_commons.net_commons_frame',
		'plugin.net_commons.net_commons_block',
	);

/**
 *  isThemeBootstrapMinCss
 *
 * @return void
 */
	public function testSetFrameId() {
		$App = new TestNetCommonsPluginTestController;
		$App->setAuth();
		$Collection = new ComponentCollection();
		$Component = new NetCommonsPluginComponent($Collection);
		$rtn = $Component->setFrameId($App, 1);
		$this->assertEquals(1, $Component->frameId);
		$this->assertEquals(1, $Component->blockId);
		$this->assertEquals(1, $Component->roomId);
		$this->assertEquals(false, $Component->isRoomAdmin);
		$this->assertEquals(true, is_array($rtn));
	}

	public function testSetFrameIdLogin() {
		$App = new TestNetCommonsPluginTestController;
		$App->setAuth(true);

		$Collection = new ComponentCollection();
		$Component = new NetCommonsPluginComponent($Collection);
		$rtn = $Component->setFrameId($App, 1);
		$this->assertEquals(1, $Component->frameId);
		$this->assertEquals(1, $Component->blockId);
		$this->assertEquals(1, $Component->roomId);
		$this->assertEquals(true, $Component->isRoomAdmin);
		$this->assertEquals(true, $Component->isBlockEdit);
		$this->assertEquals(true, $Component->isBlockCreate);
		$this->assertEquals(true, is_array($rtn));
	}

/**
 * checkApproval
 *
 * @return void
 */
	public function testCheckApproval() {
		$App = new TestNetCommonsPluginTestController;
		$App->setAuth(true);

		$Collection = new ComponentCollection();
		$Component = new NetCommonsPluginComponent($Collection);

		$Component->setFrameId($App, 1);
		$columnName = 'create_block';
		$approval = 'isBlockCreate';
		$roomPart['RoomPart'] = array(
			'create_block' => 1
		);
		$rtn = $Component->checkApproval($App, $roomPart, $columnName, $approval);
		$this->assertEquals(true, $rtn);

		$columnName = 'create_block';
		$approval = 'isBlockCreate';
		$roomPart['RoomPart'] = array(
			'create_block' => 0
		);
		$rtn = $Component->checkApproval($App, $roomPart, $columnName, $approval);
		$this->assertEquals(false, $rtn);

		$approval = "";
		$roomPart['RoomPart'] = array(
			'create_block' => 1
		);
		$rtn = $Component->checkApproval($App, $roomPart, $columnName, $approval);
		$this->assertEquals(false, $rtn);

		$approval = "test";
		$roomPart['RoomPart'] = array(
			'create_block' => 1
		);
		$rtn = $Component->checkApproval($App, $roomPart, $columnName, $approval);
		$this->assertEquals(false, $rtn);
	}

/**
 * checkPartSetting
 *
 * @return void
 */
	public function testCheckPartSetting() {
		$App = new TestNetCommonsPluginTestController;
		$App->setAuth(true);

		$Collection = new ComponentCollection();
		$Component = new NetCommonsPluginComponent($Collection);

		$Component->setFrameId($App, 1);
		$roomPart['RoomPart'] = array(
			'block_id' => 1,
			'publish_content' => 1
		);
		$roomPart[$App->NetCommonsPartsRoomsUser->name] = array(
			'part_id' => 1,
			'id' => 1,
			'user_id' => 1,
			'room_id' => 1,
		);
		//権限有り
		$columnName = 'publish_content';
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);
		$this->assertTrue($rtn);

		//権限なし
		$roomPart['RoomPart'] = array(
			'block_id' => 1,
			'publish_content' => 0
		);
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);

		//blockIdなし
		$roomPart['RoomPart'] = array(
			'block_id' => 1,
			'publish_content' => 1
		);
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);
		$this->assertTrue($rtn);

		$roomPart['RoomPart'] = array(
			'block_id' => 1,
			'publish_content' => 0
		);
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);
		$this->assertFalse($rtn);

		//RoomPartなし
		$columnName = 'publish_content';
		unset($roomPart['RoomPart']);
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);
		$this->assertFalse($rtn);

		//RoomPartなし
		$columnName = 'publish_content';
		$roomPart = array();
		$rtn = $Component->checkPartSetting($App, $roomPart, $columnName);
		$this->assertFalse($rtn);
	}
}
