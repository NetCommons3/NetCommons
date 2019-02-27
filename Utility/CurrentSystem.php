<?php
/**
 * CurrentSystem Utility
 *
 * TODO: 後で削除
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('NetCommonsSecurity', 'NetCommons.Utility');

/**
 * CurrentSystem Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentSystem {

/**
 * ControlPanelプラグイン名の定数
 */
	const PLUGIN_CONTROL_PANEL = 'control_panel';

/**
 * 同じデータを取得しないようにキャッシュする
 *
 * @var array
 */
	private static $__memoryCache = [];

/**
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		$this->setLanguage();
		$this->setPlugin();
		$this->setPluginRole();
	}

/**
 * 言語データをCurrentにセット
 *
 * @return void
 */
	public function setLanguage() {
		if (isset(Current::$current['Language'])) {
			return;
		}
		$this->Language = ClassRegistry::init('M17n.Language');

		$cacheId = 'language_' . Configure::read('Config.language');
		if (isset(self::$__memoryCache['Language'][$cacheId])) {
			$cache = self::$__memoryCache['Language'][$cacheId];
			Current::setCurrent($cache, true);
		} else {
			$language = $this->Language->getLanguage('first', array(
				'fields' => [
					'id', 'code', 'weight', 'is_active'
				],
				'conditions' => array(
					'code' => Configure::read('Config.language'),
				)
			));
			if (! isset($language['Language'])) {
				$language = $this->Language->getLanguage('first', array(
					'fields' => [
						'id', 'code', 'weight', 'is_active'
					],
					'order' => 'weight'
				));
			}

			self::$__memoryCache['Language'][$cacheId] = $language;
			Current::$current['Language'] = $language['Language'];

			if (is_object(Current::$session) && $this->Language->useDbConfig !== 'test' &&
					$language['Language']['code'] !== Configure::write('Config.language')) {
				Configure::write('Config.language', $language['Language']['code']);
				Current::$session->write('Config.language', $language['Language']['code']);
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

		if (Current::$request->params['plugin'] === Current::PLUGIN_PAGES ||
				Current::$request->params['plugin'] === CurrentSystem::PLUGIN_CONTROL_PANEL) {
			return;
		}

		if (!isset(self::$__memoryCache['Plugin'])) {
			//Pluginデータ取得
			$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
			self::$__memoryCache['Plugin'] = $this->Plugin->find('all', array(
				'recursive' => -1,
				'conditions' => array(),
			));
		}
		$results = self::$__memoryCache['Plugin'];

		$plugin = array();
		foreach ($results as $result) {
			// プラグインキーと言語で絞り込む
			if ($result['Plugin']['key'] == Current::$request->params['plugin']
					&& $result['Plugin']['language_id'] == Current::$current['Language']['id']) {
				$plugin = $result;
				break;
			}
		}

		Current::setCurrent($plugin, true);
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

		//IPアドレスによる制御
		$netCommonsSecurity = new NetCommonsSecurity();
		if (! $netCommonsSecurity->enableAllowSystemPluginIps()) {
			Current::$current['PluginsRole'] = array();
			return;
		}

		//PluginsRoleデータ取得
		if (isset(Current::$current['User']['role_key'])) {
			$userRoleKey = Current::$current['User']['role_key'];
			$cacheId = 'user_role_key_' . $userRoleKey;
			if (isset(self::$__memoryCache[$cacheId])) {
				Current::$current['PluginsRole'] = self::$__memoryCache[$cacheId];
			} else {
				$this->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
				$result = $this->PluginsRole->find('all', array(
					'recursive' => -1,
					'fields' => [
						'id', 'role_key', 'plugin_key'
					],
					'conditions' => array(
						'role_key' => Current::$current['User']['role_key'],
					),
				));
				Current::$current['PluginsRole'] = [];
				foreach ($result as $pluginsRole) {
					$key = $pluginsRole['PluginsRole']['id'];
					Current::$current['PluginsRole'][$key] = $pluginsRole['PluginsRole'];
				}
				self::$__memoryCache[$cacheId] = Current::$current['PluginsRole'];
			}
		} else {
			return;
		}
	}
}
