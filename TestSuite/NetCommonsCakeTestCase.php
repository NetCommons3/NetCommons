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
		'plugin.boxes.box',
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.pages.page',
		'plugin.plugin_manager.plugin',
		//'plugin.plugin_manager.plugins_role',
		//'plugin.roles.default_role_permission',
		//'plugin.roles.role',
		'plugin.rooms.roles_room',
		//'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		//'plugin.rooms.room_role',
		//'plugin.rooms.room_role_permission',
		'plugin.users.user',
		//'plugin.users.users_language',
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
		if ($this->_isFixtureMerged) {
			$this->fixtures = array_merge($this->fixtures, $this->_defaultFixtures);
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
		parent::setUp();

		foreach ($this->fixtures as $fixture) {
			$split = pluginSplit($fixture);
			if (! isset($split[0]) || ! isset($split[1]) || isset($split[0]) && strtolower($split[0]) !== 'plugin') {
				continue;
			}
			list($plugin, $model) = pluginSplit($split[1]);
			$plugin = Inflector::camelize($plugin);
			$model = Inflector::camelize($model);

			$classModel = ClassRegistry::init($plugin . '.' . $model, true);
			if ($classModel) {
				$model = $classModel->name;
				$this->models[$model] = $plugin . '.' . $model;
			}
		}

		foreach ($this->models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		foreach ($this->models as $model) {
			unset($this->$model);
		}

		parent::tearDown();
	}

}
