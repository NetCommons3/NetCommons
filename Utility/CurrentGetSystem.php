<?php
/**
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSecurity', 'NetCommons.Utility');

/**
 * NetCommonsの機能に必要な情報(システム系)を取得する内容をまとめたUtility
 *
 * @property Plugin $Plugin Pluginモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetSystem extends CurrentGetAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'Language' => 'M17n.Language',
		'PluginsRole' => 'PluginManager.PluginsRole',
		'Plugin' => 'PluginManager.Plugin',
	];

/**
 * 一度取得したプラグインデータを保持
 *
 * @var array|null
 */
	private $__plugins = null;

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetSystem
 */
	public static function getInstance(Controller $controller) {
		return parent::_getInstance($controller, __CLASS__);
	}

/**
 * 言語データを取得
 *
 * @return array
 */
	public function findLanguage() {
		$langCode = Configure::read('Config.language');

		$rseult = $this->Language->cacheRead('current', $langCode);
		if ($rseult) {
			return $rseult;
		}

		$language = $this->Language->getLanguage('first', array(
			'fields' => [
				'id', 'code', 'weight', 'is_active'
			],
			'conditions' => array(
				'code' => $langCode,
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

		$this->Language->cacheWrite($language, 'current', $langCode);
		return $language;
	}

/**
 * プラグインデータ取得
 *
 * @param array $pluginKeys プラグインキーリスト
 * @param string $langId 言語ID(intの文字列)
 * @return array
 */
	public function findPlugins($pluginKeys, $langId) {
		$queryOptions = [
			'recursive' => -1,
			'conditions' => [
				'key' => $pluginKeys,
				'language_id' => $langId,
			],
		];
		$cacheKey = $this->Plugin->createCacheQueryKey($queryOptions);

		$this->__plugins = $this->Plugin->cacheRead('current', $cacheKey);
		if ($this->__plugins) {
			return $this->__plugins;
		}

		$plugins = $this->Plugin->cacheFindQuery('all', $queryOptions);

		$results = [];
		foreach ($plugins as $plugin) {
			$pluginKey = $plugin['Plugin']['key'];
			$results[$pluginKey] = $plugin;
		}

		$this->__plugins = $results;
		$this->Plugin->cacheWrite($results, 'current', $cacheKey);

		return $results;
	}

/**
 * プラグインデータ取得
 *
 * @param string $pluginKey プラグインキー
 * @return void
 */
	public function findPlugin($pluginKey) {
		if (isset($this->__plugins[$pluginKey])) {
			return $this->__plugins[$pluginKey];
		} else {
			return false;
		}
	}

/**
 * プラグイン権限データ取得
 *
 * @param string $userRoleKey ユーザ権限
 * @return array
 */
	public function findPluginRole($userRoleKey) {
		//IPアドレスによる制御
		$netCommonsSecurity = new NetCommonsSecurity();
		if (! $netCommonsSecurity->enableAllowSystemPluginIps()) {
			unset($netCommonsSecurity);
			return [];
		}
		unset($netCommonsSecurity);

		$queryOptions = [
			'recursive' => -1,
			'fields' => [
				'id', 'role_key', 'plugin_key'
			],
			'conditions' => array(
				'role_key' => $userRoleKey,
			),
		];
		$cacheKey = $this->PluginsRole->createCacheQueryKey($queryOptions);

		$pluginsRoles = $this->PluginsRole->cacheRead('current', $cacheKey);
		if ($pluginsRoles) {
			return $pluginsRoles;
		}

		$results = [];
		$pluginsRoles = $this->PluginsRole->cacheFindQuery('all', $queryOptions);
		foreach ($pluginsRoles as $pluginsRole) {
			$key = $pluginsRole['PluginsRole']['id'];
			$results['PluginsRole'][$key] = $pluginsRole['PluginsRole'];
		}
		$this->Plugin->cacheWrite($results, 'current', $cacheKey);
		return $results;
	}

}
