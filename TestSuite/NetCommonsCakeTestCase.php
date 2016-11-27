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

CakeLog::drop('stdout');
CakeLog::drop('stderr');

App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');
App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('OriginalKeyBehavior', 'NetCommons.Model/Behavior');

/**
 * NetCommonsCakeTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsCakeTestCase extends CakeTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin;

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName;

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName;

/**
 * Fixture merge
 *
 * @var array
 */
	protected $_isFixtureMerged = true;

/**
 * Fixtures
 *
 * @var array
 */
	protected $_defaultFixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.blocks.block_setting',
		'plugin.blocks.blocks_language',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page_container',
		'plugin.data_types.data_type',
		'plugin.data_types.data_type_choice',
		'plugin.files.upload_file',
		'plugin.files.upload_files_content',
		'plugin.frames.frame',
		'plugin.frames.frames_language',
		'plugin.m17n.language',
		'plugin.mails.mail_queue',
		'plugin.mails.mail_queue_user',
		'plugin.mails.mail_setting',
		'plugin.pages.page',
		'plugin.pages.page_container',
		'plugin.plugin_manager.plugin',
		//'plugin.plugin_manager.plugins_role',
		//'plugin.roles.default_role_permission',
		'plugin.roles.role',
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.rooms_language',
		//'plugin.rooms.room_role',
		//'plugin.rooms.room_role_permission',
		'plugin.rooms.space',
		'plugin.site_manager.site_setting',
		'plugin.topics.topic',
		'plugin.topics.topic_readable',
		'plugin.topics.topic_user_status',
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_choice',
		'plugin.user_attributes.user_attribute_setting',
		'plugin.user_roles.user_attributes_role',
		'plugin.users.user',
		'plugin.users.users_language',
	);

/**
 * Fixtures load
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The data parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		if ($this->_isFixtureMerged && isset($this->fixtures)) {
			$this->fixtures = array_merge($this->_defaultFixtures, $this->fixtures);
		}
		if ($this->plugin) {
			NetCommonsTestSuite::$plugin = $this->plugin;
		}
		Configure::write('Config.language', 'ja');
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');

		if ($this->_modelName) {
			$model = $this->_modelName;
			$this->$model = ClassRegistry::init(Inflector::camelize($this->plugin) . '.' . $model);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		if ($this->_modelName) {
			$model = $this->_modelName;
			unset($this->$model);
		}

		Configure::write('NetCommons.installed', false);
		Configure::write('Config.language', null);
		SiteSettingUtil::reset();

		Current::$current = array();
		Current::$permission = array();

		OriginalKeyBehavior::$isUnitRandomKey = false;

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

/**
 * Load TestPlugin
 *
 * @param CakeTestCase $test CakeTestCase
 * @param string $plugin Plugin name
 * @param string $testPlugin Test plugin name
 * @return void
 */
	public static function loadTestPlugin(CakeTestCase $test, $plugin, $testPlugin) {
		$pluginPath = CakePlugin::path(Inflector::camelize($plugin));
		if (empty($pluginPath) || ! file_exists($pluginPath)) {
			$test->markTestAsSkipped(sprintf('Could not find %s in plugin paths', $pluginPath));
			return;
		}

		App::build(array(
			'Plugin' => array($pluginPath . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS)
		));
		App::uses('CakePlugin', 'Core');
		CakePlugin::load($testPlugin, ['routes' => true, 'ignoreMissing' => true]);
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

}
