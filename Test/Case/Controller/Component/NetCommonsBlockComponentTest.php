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
		'plugin.frames.frame',
		'plugin.frames.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.rooms.room',
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
		Configure::write('Config.language', 'ja');

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

		Configure::write('Config.language', null);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsBlock->initialize($this->BlockController);
		$expected = array(
			'blockId' => 0,
			'blockKey' => '',
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->BlockController->viewVars);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testStartup() {
		$this->testInitialize();
		$this->NetCommonsBlock->startup($this->BlockController);
		$expected = array(
			'blockId' => 0,
			'blockKey' => '',
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->BlockController->viewVars);
	}

/**
 * testSetView method
 *
 * @return void
 */
	public function testSetView() {
		$this->testStartup();

		$blockId = 1;
		$this->NetCommonsBlock->viewSetting = true;
		$this->NetCommonsBlock->setView($this->BlockController, $blockId);

		$expected = array(
			'blockId' => 1,
			'blockKey' => 'block_1',
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->BlockController->viewVars);
	}

/**
 * testSetViewKey method
 *
 * @return void
 */
	public function testSetViewKey() {
		$this->testStartup();

		$blockKey = 'block_1';
		$this->NetCommonsBlock->viewSetting = true;
		$this->NetCommonsBlock->setViewKey($this->BlockController, $blockKey);

		$expected = array(
			'blockId' => 1,
			'blockKey' => 'block_1',
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->BlockController->viewVars);

		Configure::write('Config.language', null);
	}

/**
 * testSetViewNotExistBlockId method
 *
 * @return void
 */
	public function testSetViewNotExistBlockId() {
		$this->setExpectedException('InternalErrorException');

		$this->testStartup();

		$blockId = 999;
		$this->NetCommonsBlock->viewSetting = true;
		$this->NetCommonsBlock->setView($this->BlockController, $blockId);
	}
}
