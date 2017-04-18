<?php
/**
 * PermissionComponentInisializeTest test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('PermissionComponent', 'NetCommons.Controller/Component');


/**
 * PermissionComponentInisializeTest Class
 */
class PermissionComponentInisializeTest extends CakeTestCase {

/**
 * @var PermissionComponent
 */
	public $PermissionComponent = null;

/**
 * @var Controller
 */
	public $Controller = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		// コンポーネントと偽のテストコントローラをセットアップする
		$Collection = new ComponentCollection();
		$this->PermissionComponent = new PermissionComponent($Collection);
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new Controller($CakeRequest, $CakeResponse);
		//$this->Permission->startup($this->Controller); // inisializeメソッドのテストでは関係なし
	}

/**
 * teatDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		// 終了した後のお掃除
		unset($this->PermissionComponent);
		unset($this->Controller);
	}

/**
 * Test default
 *
 * @return void
 */
	public function testDefault() {
		$this->PermissionComponent->initialize($this->Controller);

		$expected = array(
			'index' => 'content_readable',
			'view' => 'content_readable',
		);
		$this->assertEquals($expected, $this->PermissionComponent->allow);
	}

}