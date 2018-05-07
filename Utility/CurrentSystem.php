<?php
/**
 * CurrentSystem Utility
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
		$cache = Current::getCacheCurrent($cacheId);
		if ($cache) {
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

			Current::$current['Language'] = $language['Language'];
			Current::setCacheCurrent(['Language'], $cacheId);

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

		$cacheId = 'plugin_key_' . Current::$request->params['plugin'];
		$cache = Current::getCacheCurrent($cacheId);
		if ($cache) {
			Current::setCurrent($cache, true);
		} else {
			//Pluginデータ取得
			$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
			$result = $this->Plugin->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'key' => Current::$request->params['plugin'],
					'language_id' => Current::$current['Language']['id']
				),
			));
			Current::setCurrent($result, true);
			Current::setCacheCurrent(['Plugin'], $cacheId);
		}
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
		$userRoleKey = Hash::get(Current::$current, 'User.role_key');
		if ($userRoleKey) {
			$cacheId = 'user_role_key_' . $userRoleKey;
			$cache = Current::getCacheCurrent($cacheId);
			if ($cache) {
				Current::setCurrent($cache, true);
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
			}
			Current::$current['PluginsRole'] = Hash::combine(
				$result, '{n}.PluginsRole.id', '{n}.PluginsRole'
			);
			Current::setCacheCurrent(['PluginsRole'], $cacheId);
		} else {
			return;
		}
	}
}
