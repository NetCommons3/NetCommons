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
abstract class NetCommonsHelperTestCase extends NetCommonsControllerTestCase {

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
 * @param array $validationErrors バリデーションエラー
 * @return void
 */
	public function loadHelper($helper, $viewVars = [],
						$reqestData = [], $params = [], $helpers = [], $validationErrors = null) {
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
		if ($validationErrors) {
			$View->validationErrors = $validationErrors;
		}
		$View->loadHelpers();
		$this->$helper = new $helperClass($View);
	}

}
