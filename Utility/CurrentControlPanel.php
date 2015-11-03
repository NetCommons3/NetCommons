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
	const PLUGIN_CONTROL_PANEL = 'control_panel',
			PLUGIN_USERS = 'users';

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
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new CurrentControlPanel();
		}

		self::$__request = $request;

		self::$__instance->setLanguage();

		self::$__instance->setPlugin();

		self::$__instance->setPluginRole();
	}

/**
 * 言語データをCurrentにセット
 *
 * @return void
 */
	public static function setLanguage() {
		if (! self::$__instance) {
			self::$__instance = new CurrentControlPanel();
		}

		if (isset(Current::$current['Language'])) {
			return;
		}
		self::$__instance->Language = ClassRegistry::init('M17n.Language');

		Current::$m17n['Language'] = self::$__instance->Language->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'is_active' => true
			),
			'order' => array('weight' => 'asc')
		));
		if (! Current::$m17n['Language']) {
			return;
		}

		foreach (Current::$m17n['Language'] as $language) {
			if ($language['Language']['code'] === Configure::read('Config.language')) {
				Current::$current = Hash::merge(Current::$current, $language);
			}
		}
	}

/**
 * Set Plugin
 *
 * @return void
 */
	public function setPlugin() {
		if (isset(Current::$current['Plugin'])) {
			unset(Current::$current['Plugin']);
		}

		if (self::$__request->params['plugin'] === CurrentPage::PLUGIN_PAGES ||
				self::$__request->params['plugin'] === CurrentControlPanel::PLUGIN_CONTROL_PANEL) {
			return;
		}

		//Pluginデータ取得
		self::$__instance->Plugin = ClassRegistry::init('PluginManager.Plugin');
		$result = self::$__instance->Plugin->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'key' => self::$__request->params['plugin'],
				'language_id' => Current::$current['Language']['id']
			),
		));
		if (! $result) {
			return;
		}
		Current::$current = Hash::merge(Current::$current, $result);
	}

/**
 * Set PluginRole
 *
 * @return void
 */
	public function setPluginRole() {
		if (isset(Current::$current['PluginsRole'])) {
			//unset(Current::$current['PluginsRole']);
			return;
		}

		//PluginsRoleデータ取得
		self::$__instance->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		if (Current::$current['User']['role_key']) {
			$result = self::$__instance->PluginsRole->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'role_key' => Current::$current['User']['role_key'],
				),
			));
		} else {
			$result = false;
		}
		if (! $result) {
			return;
		}
		Current::$current['PluginsRole'] = Hash::combine($result, '{n}.PluginsRole.id', '{n}.PluginsRole');
	}
}
