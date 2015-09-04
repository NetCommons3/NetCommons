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

App::uses('CurrentControlPanelUtility', 'NetCommons.Utility');
App::uses('CurrentFrameUtility', 'NetCommons.Utility');

/**
 * Current Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentUtility {

/**
 * Constant setting mode value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

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
	private static $__current = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new CurrentUtility();
		}

		self::$__request = $request;

		self::$__current['User'] = AuthComponent::user();

		self::$__instance->setLanguage();
		self::$__instance->setPlugin();

		self::$__current = CurrentControlPanelUtility::current(self::$__request, self::$__current);
		if (! self::isControlPanel()) {
			self::$__current = CurrentFrameUtility::current(self::$__request, self::$__current);
		}

		//CakeLog::debug('CurrentUtility::initialize() self::$__current ' . print_r(self::$__current, true));
	}

/**
 * Get the current data.
 *
 * @param string $key field to retrieve. Leave null to get entire Current data
 * @return array|null Current data.
 */
	public static function current($key = null) {
		return Hash::get(CurrentUtility::$__current, $key);
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
		return (bool)self::$__current['Permission']['page_editable']['value'];
	}

/**
 * Check control panel
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$__request->params['plugin'] === CurrentControlPanelUtility::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$__current['Plugin'])) {
			return false;
		}

		if (self::$__current['Plugin']['type'] === Plugin::PLUGIN_TYPE_FOR_CONTROL_PANEL) {
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
		return (bool)count(self::$__current['PluginsRole']);
	}

/**
 * Set Language
 *
 * @return void
 */
	public function setLanguage() {
		if (isset(self::$__current['Language'])) {
			return;
		}

		self::$__instance->Language = ClassRegistry::init('M17n.Language');
		$result = self::$__instance->Language->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'code' => Configure::read('Config.language')
			),
		));
		if (! $result) {
			return;
		}
		self::$__current = Hash::merge(self::$__current, $result);
	}

/**
 * Set Plugin
 *
 * @return void
 */
	public function setPlugin() {
		if (isset(self::$__current['Plugin'])) {
			unset(self::$__current['Plugin']);
		}

		if (self::$__request->params['plugin'] === CurrentFrameUtility::PLUGIN_PAGES ||
				self::$__request->params['plugin'] === CurrentControlPanelUtility::PLUGIN_CONTROL_PANEL) {
			return;
		}

		//Pluginデータ取得
		self::$__instance->Plugin = ClassRegistry::init('PluginManager.Plugin');
		$result = self::$__instance->Plugin->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'key' => self::$__request->params['plugin'],
				'language_id' => self::$__current['Language']['id']
			),
		));
		if (! $result) {
			return;
		}
		self::$__current = Hash::merge(self::$__current, $result);
	}
}
