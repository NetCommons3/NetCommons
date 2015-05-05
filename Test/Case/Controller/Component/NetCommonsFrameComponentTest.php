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
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');

/**
 * Controller for NetCommonsFrame component test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class TestNetCommonsFrameController extends Controller {

}

/**
 * NetCommonsFrame Component test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsFrameComponentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.users.user',
	);

/**
 * NetCommonsFrame component
 *
 * @var Component NetCommonsFrame component
 */
	public $NetCommonsFrame = null;

/**
 * Controller for NetCommonsFrame component test
 *
 * @var Controller Controller for NetCommonsFrame component test
 */
	public $FrameController = null;

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
		$this->FrameController = new TestNetCommonsFrameController($CakeRequest, $CakeResponse);
		//コンポーネント読み込み
		$Collection = new ComponentCollection();
		$this->NetCommonsFrame = new NetCommonsFrameComponent($Collection);
		$this->NetCommonsFrame->viewSetting = false;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->NetCommonsFrame);
		unset($this->FrameController);

		Configure::write('Config.language', null);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->NetCommonsFrame->initialize($this->FrameController);
		$expected = array(
			'frameId' => 0,
			'frameKey' => '',
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->FrameController->viewVars);
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testStartup() {
		$this->NetCommonsFrame->initialize($this->FrameController);
		$this->NetCommonsFrame->startup($this->FrameController);
		$expected = array(
			'frameId' => 0,
			'frameKey' => '',
			'roomId' => 0,
			'languageId' => 0
		);
		$this->assertEquals($expected, $this->FrameController->viewVars);
	}

/**
 * testSetView method
 *
 * @return void
 */
	public function testSetView() {
		$frameId = 1;

		$this->NetCommonsFrame->initialize($this->FrameController);
		$this->NetCommonsFrame->startup($this->FrameController);
		$this->NetCommonsFrame->viewSetting = true;
		$this->NetCommonsFrame->frameId = $frameId;
		$this->NetCommonsFrame->setView();

		$expected = array(
			'frameId' => 1,
			'frameKey' => 'frame_1',
			'blockId' => 5,
			'blockKey' => 'block_5',
			'roomId' => 1,
			'languageId' => 2
		);
		$this->assertEquals($expected, $this->FrameController->viewVars);
	}

/**
 * testSetViewNotExistFrameId method
 *
 * @return void
 */
	public function testSetViewNotExistFrameId() {
		$this->setExpectedException('InternalErrorException');

		$frameId = 999;

		$this->NetCommonsFrame->initialize($this->FrameController);
		$this->NetCommonsFrame->startup($this->FrameController);
		$this->NetCommonsFrame->viewSetting = true;
		$this->NetCommonsFrame->frameId = $frameId;
		$this->NetCommonsFrame->setView();
	}

}
