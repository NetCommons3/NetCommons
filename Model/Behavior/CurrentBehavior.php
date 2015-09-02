<?php
/**
 * Current Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Current Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class CurrentBehavior extends ModelBehavior {

/**
 * constant value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * is setting mode true
 *
 * @var bool
 */
	private static $__isSettingMode = null;

/**
 * Current data
 *
 * @var array
 */
	private $__current = array();

/**
 * Request object
 *
 * @var mixed
 */
	public $request;

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$models = array(
			'Box' => 'Boxes.Box',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'Frame' => 'Frames.Frame',
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
			'Plugin' => 'PluginManager.Plugin',
		);
		foreach ($models as $key => $class) {
			$this->$key = ClassRegistry::init($class);
		}
	}

/**
 * setup current data
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function prepareCurrent(Model $model, $request) {
		$this->request = $request;

		//$this->settings = Hash::merge($this->settings, $config);

CakeLog::debug('CurrentBehavior::prepareCurrent');

		$this->__current = array('aaaa');

//CakeLog::debug('CurrentBehavior::setup $model->table = ' . $model->table);
CakeLog::debug(print_r($request, true));
	}

/**
 * Check setting mode
 *
 * @return bool
 */
	public static function isSettingMode() {
		if (isset(self::$__isSettingMode)) {
			return self::$__isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			self::$__isSettingMode = true;
		} else {
			self::$__isSettingMode = false;
		}

		return self::$__isSettingMode;
	}

}
