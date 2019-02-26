<?php
/**
 * ControlPanelを操作するライブラリ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');
App::uses('Plugin', 'PluginManager.Model');

/**
 * ControlPanelを操作するライブラリ
 *
 * @property CurrentLibPlugin $CurrentLibPlugin CurrentLibPluginライブラリ
 * @property CurrentLibUser $CurrentLibUser CurrentLibUserライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class ControlPanel extends LibAppObject {

/**
 * コントロールパネルのプラグインタイプキー
 *
 * @var array
 */
	private static $__controlPanelKeys = [
		Plugin::PLUGIN_TYPE_FOR_SITE_MANAGER,
		Plugin::PLUGIN_TYPE_FOR_SYSTEM_MANGER
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibPlugin' => 'NetCommons.Lib/Current',
		'CurrentLibUser' => 'NetCommons.Lib/Current',
	];

/**
 * インスタンスの取得
 *
 * @return ControlPanel
 */
	public static function getInstance() {
		return parent::_getInstance(__CLASS__);
	}

/**
 * インスタンスのクリア
 *
 * @return void
 */
	public static function resetInstance() {
		parent::_resetInstance(__CLASS__);
	}

/**
 * コントロールパネルチェック
 *
 * @return bool
 */
	public function isControlPanel() {
		$CurrentLibPlugin = $this->CurrentLibPlugin;
		if ($this->_controller->request->params['plugin'] === $CurrentLibPlugin::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		$plugin = $this->CurrentLibPlugin->findPlugin($this->_controller->request->params['plugin']);
		if (! $plugin) {
			return false;
		}

		if (! $this->hasControlPanel()) {
			return false;
		}

		return in_array($plugin['Plugin']['type'], self::$__controlPanelKeys, true);
	}

/**
 * コントロールパネルとするプラグインキーのセット
 *
 * @param array $controlPanelKeys セットするプラグインタイプキー
 * @return bool
 */
	public static function setControlPanelKeys($controlPanelKeys) {
		self::$__controlPanelKeys = $controlPanelKeys;
	}

/**
 * コントロールパネルの有無
 *
 * @return bool
 */
	public function hasControlPanel() {
		$user = $this->CurrentLibUser->getLoginUser();
		if (! isset($user['role_key'])) {
			return false;
		}

		$pluginRoles = $this->CurrentLibPlugin->findPluginRole($user['role_key']);
		if (! isset($pluginRoles['PluginsRole'])) {
			return false;
		} else {
			return (bool)count($pluginRoles['PluginsRole']);
		}
	}

/**
 * 管理系プラグインの許可
 *
 * @param string $pluginKey プラグインkey
 * @return bool
 */
	public function allowSystemPlugin($pluginKey) {
		if (! $this->hasControlPanel()) {
			return false;
		}

		$user = $this->CurrentLibUser->getLoginUser();
		$pluginRoles = $this->CurrentLibPlugin->findPluginRole($user['role_key']);
		foreach ($pluginRoles['PluginsRole'] as $pluginRole) {
			if ($pluginRole['plugin_key'] === $pluginKey) {
				return true;
			}
		}
		return false;
	}

}
