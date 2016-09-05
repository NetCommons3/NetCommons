<?php
/**
 * NetCommonsConsoleTestCase class
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Shell', 'Console');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsConsoleTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsConsoleTestCase extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = null;

/**
 * Shell name
 *
 * @var string
 */
	protected $_shellName = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
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
 * Shellのロード処理
 *
 * @param string $shell ロードするShell名(PluginName.ShellName)
 * @param string $stdinValue 標準入力値
 * @param array $methods メソッド
 * @return Mock Mockオブジェクト
 */
	public function loadShell($shell, $stdinValue = '', $methods = array()) {
		list($plugin, $shell) = pluginSplit($shell);
		if (! $plugin) {
			$plugin = $this->plugin;
		}
		App::uses($shell, Inflector::camelize($plugin) . '.Console/Command');

		return $this->_loadMock($shell, $stdinValue, $methods, true);
	}

/**
 * Taskのロード処理
 *
 * @param string $task ロードするTask名(PluginName.TaskName)
 * @param string $stdinValue 標準入力値
 * @param array $methods メソッド
 * @return Mock Mockオブジェクト
 */
	public function loadTask($task, $stdinValue = '', $methods = array()) {
		list($plugin, $task) = pluginSplit($task);
		if (! $plugin) {
			$plugin = $this->plugin;
		}
		App::uses($task, Inflector::camelize($plugin) . '.Console/Command/Task');

		return $this->_loadMock($task, $stdinValue, $methods, false);
	}

/**
 * Mockのロード処理
 *
 * @param string $shell ロードするShell名(PluginName.ShellName)
 * @param string $stdinValue 標準入力値
 * @param array $methods メソッド
 * @param bool $construct コンストラクタの有無
 * @return Mock Mockオブジェクト
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	protected function _loadMock($shell, $stdinValue = '', $methods = array(), $construct = true) {
		$stdout = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$stderr = $this->getMock('ConsoleOutput', array(), array(), '', false);
		if ($stdinValue) {
			$file = fopen(TMP . 'tests' . DS . 'test_stdin', 'w');
			fwrite($file, $stdinValue);
			fclose($file);
			$stdin = new ConsoleInput(TMP . 'tests' . DS . 'test_stdin');
		} else {
			$stdin = $this->getMock('ConsoleInput', array(), array(), '', false);
			$methods += array('in');
		}

		return $this->getMock($shell,
			Hash::merge(array('out', 'hr', 'err', 'error', 'createFile', '_stop'), $methods),
			array($stdout, $stderr, $stdin), '', $construct
		);
	}

}
