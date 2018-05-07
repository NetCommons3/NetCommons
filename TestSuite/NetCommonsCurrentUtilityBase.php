<?php
/**
 * NetCommonsCakeTestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//@codeCoverageIgnoreStart;
App::uses('AppController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('Current', 'NetCommons.Utility');
//@codeCoverageIgnoreEnd;

/**
 * NetCommonsCakeTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
abstract class NetCommonsCurrentUtilityBase extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	private $__fixtures = array(
		'plugin.frames.frame4frames',
		'plugin.frames.frame_public_language4frames',
		'plugin.frames.frames_language4frames',
		'plugin.frames.block4frames',
		'plugin.frames.plugin4frames',
		'plugin.pages.box4pages',
		'plugin.pages.boxes_page_container4pages',
		'plugin.pages.page4pages',
		'plugin.pages.page_container4pages',
		'plugin.pages.roles_rooms_user4pages',
		'plugin.pages.room4pages',
	);

/**
 * Fixtures
 *
 * @var array
 */
	protected $_Controller = null;

/**
 * Fixtures load
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The data parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		if (! isset($this->fixtures)) {
			$this->fixtures = array();
		}
		$this->fixtures = array_merge($this->__fixtures, $this->fixtures);
		parent::__construct($name, $data, $dataName);
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::$current = array();

		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->_Controller = new AppController($CakeRequest, $CakeResponse);
		Current::$request = $this->_Controller->request;
		Current::$request->params['params'] = 'test_frames';
		Current::$request->params['controller'] = 'test_frames';
		Current::$request->params['action'] = 'index';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = array();
		Current::$request = null;
		Current::$layout = null;
		unset($this->_Controller);
		parent::tearDown();
	}

}
