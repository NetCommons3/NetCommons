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
class CurrentControlPanelUtility {

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
	public static function current(CakeRequest $request, $current) {
		CakeLog::debug('CurrentControlPanelUtility::current()');

		if (! self::$__instance) {
			self::$__instance = new CurrentControlPanelUtility();
		}

		self::$__request = $request;

		self::$__current = $current;

		self::$__instance->setPluginRole();

		return self::$__current;
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

		if (self::$__request->params['plugin'] === self::PLUGIN_CONTROL_PANEL) {
			return;
		}
		if (! isset(self::$__current['Plugin'])) {
			return;
		}

		//PluginsRoleデータ取得
		self::$__instance->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		$result = self::$__instance->PluginsRole->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'role_key' => self::$__current['User']['role_key'],
				'plugin_key' => self::$__current['Plugin']['key']
			),
		));
		if (! $result) {
			return;
		}
		self::$__current = Hash::merge(self::$__current, $result);
	}
}
