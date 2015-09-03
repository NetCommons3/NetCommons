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
	public static $current = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		CakeLog::debug('CurrentUtility::initialize()');

		if (! self::$__instance) {
			self::$__instance = new CurrentUtility();
		}

		self::$__request = $request;

		self::$current['User'] = AuthComponent::user();

		self::$__instance->setLanguage();
		self::$__instance->setPlugin();

		if (self::isControlPanel()) {
			self::$current = CurrentControlPanelUtility::current(self::$__request, self::$current);
		} else {
			self::$current = CurrentFrameUtility::current(self::$__request, self::$current);
		}

		//CakeLog::debug('CurrentUtility::initialize() self::$__request ' . print_r(self::$__request, true));
		CakeLog::debug('CurrentUtility::initialize() self::$current ' . print_r(self::$current, true));
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
 * Check Control panel
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$__request->params['plugin'] === CurrentControlPanelUtility::PLUGIN_CONTROL_PANEL) {
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
 * Set Language
 *
 * @return void
 */
	public function setLanguage() {
		if (isset(self::$current['Language'])) {
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
		self::$current = Hash::merge(self::$current, $result);
	}

/**
 * Set Plugin
 *
 * @return void
 */
	public function setPlugin() {
		if (isset(self::$current['Plugin'])) {
			unset(self::$current['Plugin']);
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
				'language_id' => self::$current['Language']['id']
			),
		));
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

}
