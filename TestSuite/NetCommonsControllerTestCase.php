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
App::uses('NetCommonsUrl', 'NetCommons.Utility');
App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');
App::uses('Role', 'Roles.Model');

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
		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		self::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		parent::setUp();

		Configure::write('NetCommons.installed', true);
		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = '2';
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

		Current::$current = null;
		parent::tearDown();
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
 * Assert input tag
 *
 * ### $returnについて
 *  - viewFile: viewファイル名を戻す
 *  - json: JSONをでコードした配列を戻す
 *  - 上記以外: $this->testActionのreturnで指定した内容を戻す
 *
 * @param array $url URL配列
 * @param array $paramsOptions リクエストパラメータオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return void
 */
	protected function _testNcAction($url = array(), $paramsOptions = array(), $exception = null, $return = 'view') {
		if ($exception && $return !== 'json') {
			$this->setExpectedException($exception);
		}

		//URL設定
		$params = array();
		if ($return === 'viewFile') {
			$params['return'] = 'view';
		} elseif ($return === 'json') {
			$params['return'] = 'view';
			$params['type'] = 'json';
			if ($exception === 'BadRequestException') {
				$status = 400;
			} elseif ($exception === 'ForbiddenException') {
				$status = 403;
			} else {
				$status = 200;
			}
		} else {
			$params['return'] = $return;
		}
		$params = Hash::merge($params, $paramsOptions);

		//テスト実施
		$view = $this->testAction(NetCommonsUrl::actionUrl($url), $params);
		if ($return === 'viewFile') {
			$result = $this->controller->view;
		} elseif ($return === 'json') {
			$result = json_decode($this->contents, true);
			$this->assertArrayHasKey('code', $result);
			$this->assertEquals($status, $result['code']);
		} else {
			$result = $view;
		}

		return $result;
	}

/**
 * viewアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return array テスト結果
 */
	protected function _testGetAction($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);
		$result = $this->_testNcAction($url, array('method' => 'get'), $exception, $return);

		if (! $exception && $assert) {
			if ($assert['method'] === 'assertActionLink') {
				$assert['url'] = Hash::merge($url, $assert['url']);
			}

			$this->asserts(array($assert), $result);
		}

		return $result;
	}

/**
 * addアクションのPOSTテスト
 *
 * @param array $method リクエストのmethod(post put delete)
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return array テスト結果
 */
	protected function _testPostAction($method, $data, $urlOptions, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);
		$result = $this->_testNcAction($url, array('method' => $method, 'data' => $data), $exception, $return);

		return $result;
	}

/**
 * addアクションのValidateionErrorテスト
 *
 * @param array $method リクエストのmethod(post put delete)
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @return array テスト結果
 */
	protected function _testActionOnValidationError($method, $data, $urlOptions, $validationError = null) {
		$data = Hash::remove($data, $validationError['field']);
		$data = Hash::insert($data, $validationError['field'], $validationError['value']);

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);
		$result = $this->_testNcAction($url, array('method' => $method, 'data' => $data));

		//バリデーションエラー
		$asserts = array(
			array('method' => 'assertNotEmpty', 'value' => $this->controller->validationErrors),
			array('method' => 'assertTextContains', 'expected' => $validationError['message']),
		);

		//チェック
		$this->asserts($asserts, $result);

		return $result;
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

		$this->generate($plugin . '.' . $controller, Hash::merge(array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
			)
		), $mocks));
	}

/**
 * Asserts
 *
 * @param array $asserts テストAssert
 * @param string $result Result data
 * @return void
 */
	public function asserts($asserts, $result) {
		//チェック
		if (isset($asserts)) {
			foreach ($asserts as $assert) {
				$assertMethod = $assert['method'];

				if ($assertMethod === 'assertInput') {
					$this->$assertMethod($assert['type'], $assert['name'], $assert['value'], $result);
					continue;
				}

				if ($assertMethod === 'assertActionLink') {
					$this->$assertMethod($assert['action'], $assert['url'], $assert['linkExist'], $result);
					continue;
				}

				if (! isset($assert['value'])) {
					$assert['value'] = $result;
				}
				if (isset($assert['expected'])) {
					$this->$assertMethod($assert['expected'], $assert['value']);
				} else {
					$this->$assertMethod($assert['value']);
				}
			}
		}
	}

/**
 * Assert input tag
 *
 * @param string $tagType タグタイプ(input or textearea or button)
 * @param string $name inputタグのname属性
 * @param string $value inputタグのvalue値
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertInput($tagType, $name, $value, $result, $message = null) {
		if ($tagType === 'input') {
			if ($value) {
				$this->assertRegExp(
					'/<input.*?name="' . preg_quote($name, '/') . '".*?value="' . $value . '".*?>/', $result, $message
				);
			} else {
				$this->assertRegExp(
					'/<input.*?name="' . preg_quote($name, '/') . '".*?>/', $result, $message
				);
			}
		} elseif ($tagType === 'textarea') {
			$this->assertRegExp(
				'/<textarea.*?name="' . preg_quote($name, '/') . '".*?>.*?<\/textarea>/', $result, $message
			);
		} elseif ($tagType === 'button') {
			$this->assertRegExp(
				'/<button.*?name="' . preg_quote($name, '/') . '".*?>/', $result, $message
			);
		} elseif ($tagType === 'form') {
			$this->assertRegExp(
				'/<form.*?action=".*?' . preg_quote($value, '/') . '.*?">/', $result, $message
			);
		}
	}

/**
 * Assert アクションリンク
 *
 * @param string $action アクション
 * @param array $urlOptions URLオプション
 * @param bool $linkExist リンクの有無
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertActionLink($action, $urlOptions, $linkExist, $result, $message = null) {
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);

		$url['action'] = $action;

		if (isset($url['frame_id']) && ! Current::read('Frame.id')) {
			unset($url['frame_id']);
		}
		if (isset($url['block_id']) && ! Current::read('Block.id')) {
			unset($url['block_id']);
		}

		if ($linkExist) {
			$method = 'assertRegExp';
		} else {
			$method = 'assertNotRegExp';
		}
		$expected = '/' . preg_quote(NetCommonsUrl::actionUrl($url), '/') . '/';

		//チェック
		$this->$method($expected, $result, $message);
	}

}
