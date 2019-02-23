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
//App::uses('NcPermission', 'NetCommons.Lib');
App::uses('CurrentLibSystem', 'NetCommons.Lib');
App::uses('CurrentLibUser', 'NetCommons.Lib');
//App::uses('Current2', 'NetCommons.Lib');

/**
 * ControlPanelを操作するライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class ControlPanel extends LibAppObject {

/**
 * ControlPanelプラグイン名の定数
 */
	const PLUGIN_CONTROL_PANEL = 'control_panel';

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
 * クラス内で処理するCurrentLibSystemインスタンス
 *
 * @var CurrentLibSystem
 */
	protected $_CurrentLibSystem;

/**
 * クラス内で処理するCurrentLibUserインスタンス
 *
 * @var CurrentLibUser
 */
	protected $_CurrentLibUser;

/**
 * インスタンスの取得
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentLibSystem
 */
	public static function getInstance($controller = null) {
		$instance = parent::_getInstance(__CLASS__);
		$instance->setController($controller);
		return $instance;
	}

/**
 * インスタンスのクリア
 *
 * @return void
 */
	public static function resetInstance() {
		parent::_resetInstance();
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function setController($controller) {
		parent::setController($controller);

		$this->_CurrentLibSystem = CurrentLibSystem::getInstance($controller);
		$this->_CurrentLibUser = CurrentLibUser::getInstance($controller);
	}

/**
 * コントロールパネルチェック
 *
 * @return bool
 */
	public function isControlPanel() {
		if ($this->_controller->request->params['plugin'] === self::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		$plugin = $this->_CurrentLibSystem->findPlugin($this->_controller->request->params['plugin']);
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
		$user = $this->_CurrentLibUser->getLoginUser();
		if (! isset($user['role_key'])) {
			return false;
		}

		$pluginRoles = $this->_CurrentLibSystem->findPluginRole($user['role_key']);
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

		$user = $this->_CurrentLibUser->getLoginUser();
		$pluginRoles = $this->_CurrentLibSystem->findPluginRole($user['role_key']);
		foreach ($pluginRoles['PluginsRole'] as $pluginRole) {
			if ($pluginRole['plugin_key'] === $pluginKey) {
				return true;
			}
		}
		return false;
	}

}
