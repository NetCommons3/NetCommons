<?php
/**
 * NetCommonsControllerTestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

CakeLog::drop('stdout');
CakeLog::drop('stderr');

App::uses('TestAuthGeneral', 'AuthGeneral.TestSuite');
App::uses('Current', 'NetCommons.Utility');
App::uses('CurrentControlPanel', 'NetCommons.Utility');
App::uses('NetCommonsUrl', 'NetCommons.Utility');
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('Role', 'Roles.Model');

/**
 * NetCommonsControllerTestCase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsControllerBaseTestCase extends ControllerTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = null;

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller;

/**
 * Post data
 *
 * @var array
 */
	public $data = null;

/**
 * Fixture merge
 *
 * @var bool
 */
	protected $_isFixtureMerged = true;

/**
 * Fixtures
 *
 * @var array
 */
	protected $_fixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.data_types.data_type',
		'plugin.data_types.data_type_choice',
		'plugin.files.upload_file',
		'plugin.files.upload_files_content',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.site_manager.site_setting',
		'plugin.pages.languages_page',
		'plugin.pages.page',
		'plugin.plugin_manager.plugin',
		'plugin.plugin_manager.plugins_role',
		'plugin.plugin_manager.plugins_room',
		'plugin.roles.default_role_permission',
		'plugin.roles.role',
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.rooms_language',
		'plugin.rooms.space',
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_choice',
		'plugin.user_attributes.user_attribute_setting',
		'plugin.user_roles.user_attributes_role',
		'plugin.user_roles.user_role_setting',
		'plugin.users.user',
		'plugin.users.users_language',
	);

/**
 * Fixtures load
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The date parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		if ($this->_isFixtureMerged && isset($this->fixtures)) {
			$this->fixtures = array_merge($this->_fixtures, $this->fixtures);
		}

		if ($this->plugin) {
			NetCommonsTestSuite::$plugin = $this->plugin;
		}
		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		parent::setUp();

		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');
		(new CurrentControlPanel())->setLanguage();

		if ($this->_controller) {
			$this->generateNc(Inflector::camelize($this->_controller));
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('NetCommons.installed', false);
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);

		Current::$current = array();
		parent::tearDown();
	}

/**
 * privateおよびprotectedメソッドのテスト
 *
 * @param Instance $instance インスタンス
 * @param string $mockMethod Mockのメソッド
 * @param array $params Mockのメソッドのパラメータ
 * @return void
 */
	protected function _testReflectionMethod($instance, $mockMethod, $params = array()) {
		$method = new ReflectionMethod($instance, $mockMethod);
		$method->setAccessible(true);
		$result = $method->invokeArgs($instance, $params);
		return $result;
	}

}
