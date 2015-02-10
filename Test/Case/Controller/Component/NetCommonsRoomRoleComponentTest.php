<?php
/**
 * RoomsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Controller', 'Controller');
App::uses('Component', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AuthComponent for NetCommonsRoomRole component test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestAuthComponent {

/**
 * allowedActions
 *
 * @var array
 */
	public $allowedActions = array('index', 'view');

/**
 * login method
 *
 * @return bool
 */
	public function login() {
		$array = array(
			'id' => 1,
			'username' => 'admin',
			'role_key' => 'system_administrator',
		);
		CakeSession::write('Auth.User', $array);
		return true;
	}

/**
 * user method
 *
 * @param string $key column name
 * @return mixed
 */
	public function user($key = '') {
		$array = CakeSession::read('Auth.User');
		if (! $key) {
			return $array;
		} else {
			return $array[$key];
		}
	}

}

/**
 * Controller for NetCommonsRoomRole component test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestNetCommonsRoomRoleController extends Controller {

/**
 * Auth
 *
 * @var AuthComponent
 */
	public $Auth = null;

/**
 * request
 *
 * @var request
 */
}

/**
 * NetCommonsRoomRole Component test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsRoomRoleComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.frames.frame',
		'plugin.frames.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		/* 'plugin.net_commons.user', */
	);

/**
 * NetCommonsRoomRole component
 *
 * @var Component NetCommonsRoomRole component
 */
	public $NetCommonsRoomRole = null;

/**
 * Controller for NetCommonsRoomRole component test
 *
 * @var Controller Controller for NetCommonsRoomRole component test
 */
	public $RoomRoleController = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストコントローラ読み込み
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->RoomRoleController = new TestNetCommonsRoomRoleController($CakeRequest, $CakeResponse);
		$this->RoomRoleController->Auth = new TestAuthComponent();
		$this->RoomRoleController->request->params['action'] = 'index';

		//コンポーネント読み込み
		$Collection = new ComponentCollection();

		$this->NetCommonsRoomRole = new NetCommonsRoomRoleComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->NetCommonsRoomRole);
		unset($this->RoomRoleController);
		CakeSession::delete('Auth.User');
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);

		$expected = array(
			'rolesRoomId' => 0,
			'roomRoleKey' => 'visitor',
		);
		$this->assertEquals($expected, $this->RoomRoleController->viewVars);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testStartup() {
		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);

		$expected = array(
			'rolesRoomId' => 0,
			'roomRoleKey' => 'visitor',
			'pageEditable' => false,
			'blockEditable' => false,
			'contentReadable' => true,
			'contentCreatable' => false,
			'contentEditable' => false,
			'contentPublishable' => false,
		);
		$this->assertEquals($expected, $this->RoomRoleController->viewVars);
	}

/**
 * testSetView method
 *
 * @return void
 */
	public function testSetView() {
		CakeSession::write('Auth.User.id', 1);

		$this->RoomRoleController->viewVars['blockKey'] = 'block_1';
		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);
		$this->NetCommonsRoomRole->setView($this->RoomRoleController);

		$expected = array(
			'pageEditable' => true,
			'blockEditable' => true,
			'contentReadable' => true,
			'contentCreatable' => true,
			'contentEditable' => true,
			'contentPublishable' => true,
			'rolesRoomId' => '1',
			'roomRoleKey' => 'room_administrator',
			'blockKey' => 'block_1'
		);
		$this->assertEquals($expected, $this->RoomRoleController->viewVars);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testSetViewNoLogin method
 *
 * @return void
 */
	public function testSetViewNoLogin() {
		CakeSession::write('Auth.User.id', null);

		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);
		$this->NetCommonsRoomRole->setView($this->RoomRoleController);

		$expected = array(
			'pageEditable' => false,
			'blockEditable' => false,
			'contentReadable' => true,
			'contentCreatable' => false,
			'contentEditable' => false,
			'contentPublishable' => false,
			'rolesRoomId' => 0,
			'roomRoleKey' => 'visitor',
		);
		$this->assertEquals($expected, $this->RoomRoleController->viewVars);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testSetViewNotExistUser method
 *
 * @return void
 */
	public function testSetViewNotExistUser() {
		$this->setExpectedException('InternalErrorException');

		CakeSession::write('Auth.User.id', 999);

		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);
		$this->NetCommonsRoomRole->setView($this->RoomRoleController);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testSetViewRoomRolePermisionDataError method
 *
 * @return void
 */
	public function testSetViewRoomRolePermisionDataError() {
		$this->setExpectedException('InternalErrorException');

		//テストデータ生成
		$this->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');
		$this->RoomRolePermission->updateAll(
			array('RoomRolePermission.roles_room_id' => "'2'"),
			array('RoomRolePermission.roles_room_id' => '1')
		);

		CakeSession::write('Auth.User.id', 1);

		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);
		$this->NetCommonsRoomRole->setView($this->RoomRoleController);

		CakeSession::write('Auth.User.id', null);
	}

/**
 * testSetViewDefaultRolePermissionDataError method
 *
 * @return void
 */
	public function testSetViewDefaultRolePermissionDataError() {
		$this->setExpectedException('InternalErrorException');

		//テストデータ生成
		$this->DefaultRolePermission = ClassRegistry::init('Roles.DefaultRolePermission');
		$this->DefaultRolePermission->updateAll(
			array('DefaultRolePermission.role_key' => "''"),
			array('DefaultRolePermission.role_key' => 'room_administrator')
		);

		CakeSession::write('Auth.User.id', 1);

		$this->NetCommonsRoomRole->initialize($this->RoomRoleController);
		$this->NetCommonsRoomRole->startup($this->RoomRoleController);
		$this->NetCommonsRoomRole->setView($this->RoomRoleController);

		CakeSession::write('Auth.User.id', null);
	}

}
