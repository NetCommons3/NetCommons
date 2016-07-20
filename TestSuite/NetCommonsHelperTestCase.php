<?php
/**
 * NetCommonsHelperTestCase class
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('View', 'View');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('CurrentSystem', 'NetCommons.Utility');

/**
 * NetCommonsHelperTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @codeCoverageIgnore
 */
class NetCommonsHelperTestCase extends NetCommonsCakeTestCase {

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
		'plugin.site_manager.site_setting',
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = null;

/**
 * Helper name
 *
 * @var string
 */
	protected $_helperName = null;

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
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		(new CurrentSystem())->setLanguage();

		if ($this->_helperName) {
			$this->loadHelper($this->_helperName);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = array();
		Current::$request = null;
		unset($this->_Controller);
		parent::tearDown();
	}

/**
 * Helperのロード処理
 *
 * @param string $helper ロードするHelper名(PluginName.HelperName)
 * @param array $viewVars $helper->_View->viewVarsに値をセットする配列
 * @param array $reqestData $helper->_View->request->dataに値をセットする配列
 * @param array $params $helper->_View->paramsに値をセットする配列
 * @param array $helpers ヘルパー配列
 * @return void
 */
	public function loadHelper($helper, $viewVars = [],
								$reqestData = [], $params = [], $helpers = []) {
		list($plugin, $helper) = pluginSplit($helper);
		if (! $plugin) {
			$plugin = $this->plugin;
		}

		$helperClass = $helper . 'Helper';
		App::uses($helperClass, Inflector::camelize($this->plugin) . '.View/Helper');
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$Controller = new AppController($CakeRequest, $CakeResponse);
		$Controller->set($viewVars);
		$Controller->request->data = $reqestData;
		$Controller->request->params = Hash::merge(
			array('plugin' => $this->plugin, 'controller' => '', 'action' => ''), $params
		);
		Current::$request = $Controller->request;

		$View = new View($Controller);
		$View->plugin = Inflector::camelize($this->plugin);
		$View->helpers = $helpers;
		$View->loadHelpers();
		$this->$helper = new $helperClass($View);
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
		(new NetCommonsControllerTestCase())->assertInput($tagType, $name, $value, $result, $message);
	}

}
