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
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('Block', 'Blocks.Model');

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
	public $Controller = null;

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
		$this->Controller = new TestNetCommonsBlockController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->NetCommonsBlock = new NetCommonsBlockComponent($Collection);
		$this->NetCommonsBlock->startup($this->Controller);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->NetCommonsBlock);
		unset($this->Controller);

		Configure::write('Config.language', null);
	}

/**
 * initialize test
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsBlock->initialize($this->Controller);
		$expected = array(
			'blockId' => 0,
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->Controller->viewVars);
	}

/**
 * setView test
 *
 * @return void
 */
	public function testSetView() {
		$this->testInitialize();

		$blockId = 1;
		$result = $this->NetCommonsBlock->setView($this->Controller, $blockId);
		$this->assertTrue($result);

		$expected = array(
			'blockId' => 1,
			'blockKey' => 'block_1',
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->Controller->viewVars);
	}

/**
 * setViewKey test
 *
 * @return void
 */
	public function testSetViewKey() {
		$this->testInitialize();

		$blockKey = 'block_1';
		$result = $this->NetCommonsBlock->setViewKey($this->Controller, $blockKey);
		$this->assertTrue($result);

		$expected = array(
			'blockId' => 1,
			'blockKey' => 'block_1',
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->Controller->viewVars);

		Configure::write('Config.language', null);
	}

/**
 * setView test for not exist block id
 *
 * @return void
 */
	public function testSetViewNotExistBlockId() {
		$this->testInitialize();

		$blockId = 999;
		$result = $this->NetCommonsBlock->setView($this->Controller, $blockId);

		$this->assertFalse($result);
	}
}
