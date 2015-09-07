<?php
/**
 * CurrentControlPanel Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CurrentControlPanel Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentControlPanel {

/**
 * Constant Plugin value
 */
	const PLUGIN_CONTROL_PANEL = 'control_panel';

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
	public static function initialize(CakeRequest $request, $current) {
		if (! self::$__instance) {
			self::$__instance = new CurrentControlPanel();
		}

		self::$__request = $request;

		self::$__current = $current;

		self::$__instance->setLanguage();

		self::$__instance->setPlugin();

		self::$__instance->setPluginRole();

		return self::$__current;
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

		if (self::$__request->params['plugin'] === CurrentFrame::PLUGIN_PAGES ||
				self::$__request->params['plugin'] === CurrentControlPanel::PLUGIN_CONTROL_PANEL) {
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

/**
 * Set PluginRole
 *
 * @return void
 */
	public function setPluginRole() {
		if (isset(self::$__current['PluginsRole'])) {
			unset(self::$__current['PluginsRole']);
		}

		//PluginsRoleデータ取得
		self::$__instance->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		$result = self::$__instance->PluginsRole->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'role_key' => self::$__current['User']['role_key'],
				'plugin_key' => array('user_manager', 'rooms')
			),
		));
		if (! $result) {
			return;
		}
		self::$__current['PluginsRole'] = Hash::combine($result, '{n}.PluginsRole.id', '{n}.PluginsRole');
	}
}
