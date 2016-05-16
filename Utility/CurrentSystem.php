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

		Current::$m17n['Language'] = $this->Language->find('all', array(
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

		if (Current::$request->params['plugin'] === Current::PLUGIN_PAGES ||
				Current::$request->params['plugin'] === CurrentSystem::PLUGIN_CONTROL_PANEL) {
			return;
		}

		//Pluginデータ取得
		$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
		$result = $this->Plugin->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'key' => Current::$request->params['plugin'],
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

		//IPアドレスによる制御
		$netCommonsSecurity = new NetCommonsSecurity();
		if (! $netCommonsSecurity->enableAllowSystemPluginIps()) {
			Current::$current['PluginsRole'] = array();
			return;
		}

		//PluginsRoleデータ取得
		$this->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		if (Current::$current['User']['role_key']) {
			$result = $this->PluginsRole->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'role_key' => Current::$current['User']['role_key'],
				),
			));
		} else {
			return;
		}
		Current::$current['PluginsRole'] = Hash::combine(
			$result, '{n}.PluginsRole.id', '{n}.PluginsRole'
		);
	}
}
