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

App::uses('AuthGeneralTestSuite', 'AuthGeneral.TestSuite');
App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * NetCommonsControllerTestCase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsControllerTestCase extends ControllerTestCase {

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
	protected $_controller = null;

/**
 * Action name
 *
 * @var string
 */
	protected $_action = null;

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
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.net_commons.site_setting',
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
		//'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.space',
		'plugin.users.user',
		//'plugin.users.users_language',
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
		if ($this->_isFixtureMerged) {
			$this->fixtures = array_merge($this->fixtures, $this->_fixtures);
		}

		if ($this->plugin) {
			NetCommonsTestSuite::$plugin = $this->plugin;
		}
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		self::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		parent::setUp();

		if ($this->plugin && $this->_controller) {
			$this->generate(Inflector::camelize($this->plugin) . '.' . Inflector::camelize($this->_controller), array(
				'components' => array(
					'Auth' => array('user'),
					'Session',
					'Security',
				)
			));
		}

		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = '2';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);

		Current::$current = null;
		parent::tearDown();
	}

/**
 * Lets you do functional tests of a controller action.
 *
 * ### Options:
 *
 * - `data` Will be used as the request data. If the `method` is GET,
 *   data will be used a GET params. If the `method` is POST, it will be used
 *   as POST data. By setting `$options['data']` to a string, you can simulate XML or JSON
 *   payloads to your controllers allowing you to test REST webservices.
 * - `method` POST or GET. Defaults to POST.
 * - `return` Specify the return type you want. Choose from:
 *     - `vars` Get the set view variables.
 *     - `view` Get the rendered view, without a layout.
 *     - `contents` Get the rendered view including the layout.
 *     - `result` Get the return value of the controller action. Useful
 *       for testing requestAction methods.
 * - `type` json or html, Defaults to html.
 *
 * @param string $url The url to test
 * @param array $options See options
 * @return mixed
 */
	protected function _testAction($url = '', $options = []) {
		$options = array_merge(['type' => 'html'], $options);
		if ($options['type'] === 'json') {
			$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		}
		$ret = parent::_testAction($url, $options);
		return $ret;
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
		CakePlugin::load($testPlugin);
	}

/**
 * testActionのURL取得
 *
 * @param array $options See options
 * @return string url
 */
	protected function _getActionUrl($options = array()) {
		$url = NetCommonsUrl::actionUrl(Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => $this->_action,
		), $options));

		return $url;
	}

/**
 * Functional tests of a controller action.
 *
 * @param array $options See options
 * @param array $params Request params
 * @return mixed
 */
	protected function _testNcAction($options = array(), $params = array()) {
		if (is_string($options)) {
			$url = $options;
			$action = $this->_action;
		} else {
			if (isset($options['action'])) {
				$action = $options['action'];
			} else {
				$action = $this->_action;
			}
			$url = $this->_getActionUrl($options);
		}
		if ($action === 'add') {
			$defaultMethod = 'post';
		} elseif ($action === 'edit') {
			$defaultMethod = 'put';
		} elseif ($action === 'delete') {
			$defaultMethod = 'delete';
		} else {
			$defaultMethod = 'get';
		}

		$params = Hash::merge(array(
			'method' => $defaultMethod,
			'return' => 'view'
		), $params);

		if ($params['method'] !== 'get' && ! isset($params['data'])) {
			$params['data'] = $this->data;
		}

		return $this->testAction($url, $params);
	}

}
