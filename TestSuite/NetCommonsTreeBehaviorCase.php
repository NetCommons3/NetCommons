<?php
/**
 * NetCommonsTreeBehaviorCase Class
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//@codeCoverageIgnoreStart;
App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
//@codeCoverageIgnoreEnd;

/**
 * NetCommonsTreeBehaviorCase Class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
abstract class NetCommonsTreeBehaviorCase extends NetCommonsModelTestCase {

/**
 * 繰り返しテスト回数(測定のため)
 *
 * @var array
 */
	const MEASUREMENT_NUMBER = 1;

/**
 * 開始時間
 *
 * @var string
 */
	protected $_startTime = null;

/**
 * 終了時間
 *
 * @var string
 */
	protected $_endTime = null;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.net_commons_tree_model',
		'plugin.net_commons.cake_tree_model',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * Fixtures load
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The data parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		if (version_compare(PHP_VERSION, '7.0.0') < 0) {
			$this->autoFixtures = false;
			$this->fixtures = null;
			$this->markTestSkipped('php 7.x以上でテストができます。');
		}
		parent::__construct($name, $data, $dataName);
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsTreeModel');
	}

/**
 * 不要なカラムの削除
 *
 * CakePHPとNCのTreeBehaviorでカラムが違うため
 *
 * @param mixed $data データ
 * @return mixed
 */
	protected function _removeUnnecessaryFields($data) {
		if ($this->TestModel->Behaviors->loaded('NetCommons.NetCommonsTree')) {
			$removeFields = ['lft', 'rght'];
		} else {
			$removeFields = ['sort_key', 'weight', 'child_count'];
		}

		$results = $data;
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$results[$key] = $this->_removeUnnecessaryFields($value);
				} elseif (in_array($key, $removeFields, true)) {
					unset($results[$key]);
				}
			}
		}
		return $results;
	}

/**
 * デバッグの開始
 *
 * @return void
 */
	protected function _debugStart() {
		$this->TestModel->getDataSource()->getLog();
		$this->_startTime = microtime(true);
	}

/**
 * デバッグの終了
 *
 * @param mixed $arguments 引数
 * @return void
 */
	protected function _debugEnd($arguments) {
		$this->_endTime = microtime(true);
		//debug(json_encode($arguments));
		//debug($this->_endTime - $this->_startTime);
		//debug($this->TestModel->getDataSource()->getLog()['log']);
		//debug('--EOF--');
	}

/**
 * childCount()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProvider() {
		for ($number = 0; $number < self::MEASUREMENT_NUMBER; $number++) {
			$result[$number] = ['number' => $number];
		}
		return $result;
	}

}
