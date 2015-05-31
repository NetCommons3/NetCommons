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
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('Block', 'Blocks.Model');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');

/**
 * Controller for NetCommonsBlock component test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestNetCommonsBlockController extends Controller {

}

/**
 * NetCommonsBlock Component test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsBlockComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.plugin_manager.plugin',
		'plugin.rooms.room',
		'plugin.users.user',
	);

/**
 * NetCommonsBlock component
 *
 * @var Component NetCommonsBlock component
 */
	public $NetCommonsBlock = null;

/**
 * Controller for NetCommonsBlock component test
 *
 * @var Controller Controller for NetCommonsBlock component test
 */
	public $BlockController = null;

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
		$this->BlockController = new TestNetCommonsBlockController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->NetCommonsBlock = new NetCommonsBlockComponent($Collection);
		$this->NetCommonsBlock->viewSetting = false;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->NetCommonsBlock);
		unset($this->BlockController);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsBlock->initialize($this->BlockController);
		$this->assertEquals($this->BlockController, $this->NetCommonsBlock->controller);
	}
}
