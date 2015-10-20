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
App::uses('UserRole', 'UserRoles.Model');

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
 * M17n data
 *
 * @var array
 */
	public static $m17n = array();

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
 * 現在のデータ取得
 *
 * @param string|null $key Hashクラスのpath
 * @return array|null Current data.
 */
	public static function read($key = null) {
		if (! isset(self::$current)) {
			return self::$current;
		}

		if (! isset($key)) {
			return self::$current;
		}
		return Hash::get(self::$current, $key);
	}

/**
 * 多言語のデータ取得
 *
 * @param string|null $languageId 言語ID
 * @param string|null $model モデル名
 * @param string|null $field フィールド名
 * @return mixed Current data.
 */
	public static function readM17n($languageId, $model = null, $field = null) {
		if (! isset(self::$m17n)) {
			return self::$m17n;
		}

		if (! isset($model)) {
			return self::$m17n;
		}

		if (! isset(self::$m17n[$model])) {
			return null;
		}
		if (! isset($languageId)) {
			return self::$m17n[$model];
		}

		$result = Hash::extract(self::$m17n, $model . '.{n}.' . $model . '[language_id=' . $languageId . ']');
		if (! $result) {
			return null;
		}

		if (! isset($field)) {
			return array($model => $result[0]);
		} else {
			return $result[0][$field];
		}
	}

/**
 * 権限チェック
 *
 * @param string $key Hashクラスのpath
 * @return bool permission value
 */
	public static function permission($key) {
		if (! isset(self::$current)) {
			return false;
		}
		$path = 'Permission.' . $key . '.value';
		return (bool)Hash::get(self::$current, $path);
	}

/**
 * ログインチェック
 *
 * @return bool
 */
	public static function isLogin() {
		return (bool)AuthComponent::user('id');
	}

/**
 * セッティングモードチェック
 *
 * @param bool|null $settingMode セッティングモードの状態変更
 * @return bool
 */
	public static function isSettingMode($settingMode = null) {
		if (isset($settingMode)) {
			self::$__isSettingMode = $settingMode;
		}

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
 * セッティングモードの有無
 *
 * @return bool
 */
	public static function hasSettingMode() {
		return self::permission('page_editable');
	}

/**
 * コントロールパネルチェック
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
 * コントロールパネルの有無
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

/**
 * 管理系プラグインの許可
 *
 * @param string $pluginKey プラグインkey
 * @return bool
 */
	public static function allowSystemPlugin($pluginKey) {
		if (! isset(self::$current['PluginsRole'])) {
			return false;
		}
		if (self::read('User.role_key') === UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR) {
			return true;
		}

		return Hash::check(Current::$current['PluginsRole'], '{n}[plugin_key=' . $pluginKey . ']');
	}

}
