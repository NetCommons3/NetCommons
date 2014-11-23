<?php
/**
 * NetCommonsApp Controller Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('AssetComponent', 'Component');
App::uses('NetCommonsAppController', 'NetCommons.Controller');

/**
 * NetCommonsApp Controller Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Controller
 */
class NetCommonsAppControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.session',
		'app.site_setting',
		'plugin.frames.frame',
		'plugin.frames.language',
		'plugin.frames.plugin',
		'plugin.boxes.box',
		'plugin.blocks.block',
		'plugin.rooms.room',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		//$CakeRequest = new CakeRequest();
		//$CakeResponse = new CakeResponse();
		//$this->NetCommonsApp = new NetCommonsAppController($CakeRequest, $CakeResponse);
		$this->NetCommonsApp = $this->generate('NetCommons.NetCommonsApp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * testRenderJson method
 *
 * @return void
 */
	public function testRenderJson() {
		$this->NetCommonsApp->renderJson(array('test' => 'renderJson test'), 'Error', 400);

		$expected = array(
			'code' => 400,
			'name' => 'Error',
			'results' => array('test' => 'renderJson test')
		);
		$this->assertEquals($expected, $this->NetCommonsApp->viewVars['result']);
	}

}
