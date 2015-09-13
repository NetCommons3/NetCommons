<?php
/**
 * Current Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CurrentControlPanel', 'NetCommons.Utility');
App::uses('CurrentFrame', 'NetCommons.Utility');
App::uses('CurrentPage', 'NetCommons.Utility');

/**
 * Current Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class Current {

/**
 * Constant setting mode value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * is setting mode true
 *
 * @var bool
 */
	private static $__isSettingMode = null;

/**
 * Request object
 *
 * @var mixed
 */
	private static $__request;

/**
 * Instance object
 *
 * @var mixed
 */
	private static $__instance;

/**
 * Current data
 *
 * @var array
 */
	public static $current = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new Current();
		}

		self::$__request = $request;

		self::$current['User'] = AuthComponent::user();

		CurrentControlPanel::initialize(self::$__request);

		if (! self::isControlPanel()) {
			CurrentFrame::initialize(self::$__request);
		}
	}

/**
 * Get the current data.
 *
 * @param string|null $key field to retrieve. Leave null to get entire Current data
 * @return array|null Current data.
 */
	public static function read($key = null) {
		if (! isset($key)) {
			return self::$current;
		}
		return Hash::get(self::$current, $key);
	}

/**
 * Get the permission value.
 *
 * @param string|array $key field to retrieve. Leave null to get entire Current data
 * @return bool permission value
 */
	public static function permission($key) {
		if (is_array($key)) {
			foreach ($key as $k) {
				if (self::permission($k)) {
					return true;
				}
			}
			return false;
		}
		$path = 'Permission.' . $key . '.value';

		return (bool)Hash::get(self::$current, $path);
	}

/**
 * Is login
 *
 * @return bool
 */
	public static function isLogin() {
		return (bool)AuthComponent::user('id');
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

/**
 * Has setting mode
 *
 * @return bool
 */
	public static function hasSettingMode() {
		return self::permission('page_editable');
	}

/**
 * Check control panel
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$__request->params['plugin'] === CurrentControlPanel::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$current['Plugin'])) {
			return false;
		}

		if (self::$current['Plugin']['type'] === Plugin::PLUGIN_TYPE_FOR_CONTROL_PANEL) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Has Control panel
 *
 * @return bool
 */
	public static function hasControlPanel() {
		if (! isset(self::$current['PluginsRole'])) {
			return false;
		} else {
			return (bool)count(self::$current['PluginsRole']);
		}
	}

}
