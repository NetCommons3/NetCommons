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
App::uses('CurrentSystem', 'NetCommons.Utility');
App::uses('NetCommonsUrl', 'NetCommons.Utility');
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('Role', 'Roles.Model');
App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('OriginalKeyBehavior', 'NetCommons.Model/Behavior');
App::uses('AuthComponent', 'Controller/Component');

/**
 * NetCommonsControllerTestCase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class NetCommonsControllerBaseTestCase extends ControllerTestCase {

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
		'plugin.blocks.block_setting',
		'plugin.blocks.blocks_language',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page_container',
		'plugin.categories.category',
		'plugin.data_types.data_type',
		'plugin.data_types.data_type_choice',
		'plugin.files.upload_file',
		'plugin.files.upload_files_content',
		'plugin.frames.frame',
		'plugin.frames.frame_public_language',
		'plugin.frames.frames_language',
		'plugin.m17n.language',
		'plugin.mails.mail_queue',
		'plugin.mails.mail_queue_user',
		'plugin.mails.mail_setting',
		'plugin.pages.pages_language',
		'plugin.pages.page',
		'plugin.pages.page_container',
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
		'plugin.site_manager.site_setting',
		'plugin.topics.topic',
		'plugin.topics.topic_readable',
		'plugin.topics.topic_user_status',
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

		$this->_clear();

		parent::setUp();

		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');
		Current::$current['Language'] = [
			'id' => '2',
			'code' => 'ja',
		];

		AuthComponent::$sessionKey = false;

		if ($this->_controller) {
			$this->generateNc(Inflector::camelize($this->_controller));
		}
	}

/**
 * 初期化
 *
 * @return void
 */
	protected function _clear() {
		Configure::write('NetCommons.installed', false);
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		AuthComponent::$sessionKey = 'Auth.User';

		Current::$current = array();
		Current::$permission = array();

		OriginalKeyBehavior::$isUnitRandomKey = false;

		SiteSettingUtil::reset();
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
 * Generates a mocked controller and mocks any classes passed to `$mocks`. By
 * default, `_stop()` is stubbed as is sending the response headers, so to not
 * interfere with testing.
 *
 * ### Mocks:
 *
 * - `methods` Methods to mock on the controller. `_stop()` is mocked by default
 * - `models` Models to mock. Models are added to the ClassRegistry so any
 *   time they are instantiated the mock will be created. Pass as key value pairs
 *   with the value being specific methods on the model to mock. If `true` or
 *   no value is passed, the entire model will be mocked.
 * - `components` Components to mock. Components are only mocked on this controller
 *   and not within each other (i.e., components on components)
 *
 * @param string $controller Controller name
 * @param array $mocks List of classes and methods to mock
 * @return Controller Mocked controller
 */
	public function generateNc($controller, $mocks = array()) {
		list($plugin, $controller) = pluginSplit($controller);
		if (! $plugin) {
			$plugin = Inflector::camelize($this->plugin);
		}

		if (Hash::check($mocks, 'components.Session')) {
			$default = array('components' => array(
				//'Auth' => array('user'),
				'Security',
			));
		} else {
			$default = array('components' => array(
				//'Auth' => array('user'),
				'Session',
				'Security',
			));
		}

		$this->generate($plugin . '.' . $controller, Hash::merge($default, $mocks));

		//throwが実行されるとログイン情報が残っているため、初期化する
		TestAuthGeneral::logout($this);
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

/**
 * Viewの結果をスペース等のパースを行う
 *
 * @param string $view Viewの結果
 * @return string
 */
	protected function _parseView($view) {
		$view = preg_replace('/[>][\s\t]+([^a-z])/u', '>$1', $view);
		$view = preg_replace('/[\s\t]+</u', '<', $view);
		$view = preg_replace('/[\s\t]+/u', ' ', $view);
		$view = str_replace("\n", '', $view);
		$view = trim($view);
		return $view;
	}

/**
 * Assert Date time
 *
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertDatetime($result, $message = null) {
		$pattern = '/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/';
		$this->assertRegExp($pattern, $result, $message);
	}

/**
 * リダイレクトの評価
 *
 * @param string $result 期待値
 * @param string $message メッセージ
 * @return void
 */
	public function assertRedirect($result, $message = null) {
		$this->assertNull($this->contents, $message);

		$header = $this->controller->response->header();
		$this->assertTextContains($result, $header['Location'], $message);
	}

}
