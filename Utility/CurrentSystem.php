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

		$language = $this->Language->getLanguage('first', array(
			'conditions' => array(
				'code' => Configure::read('Config.language'),
			)
		));
		if (! isset($language['Language'])) {
			$language = $this->Language->getLanguage('first', array(
				'order' => 'weight'
			));
		}

		Current::$current['Language'] = $language['Language'];
		if (is_object(Current::$session) && $this->Language->useDbConfig !== 'test' &&
				$language['Language']['code'] !== Configure::write('Config.language')) {
			Configure::write('Config.language', $language['Language']['code']);
			Current::$session->write('Config.language', $language['Language']['code']);
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
		Current::setCurrent($result, true);
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
		if (Hash::get(Current::$current, 'User.role_key')) {
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
