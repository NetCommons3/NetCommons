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
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 * ※本来、ここに集約せずに各モデルに書く方が良い。
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetSystem {

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	private $__controller;

/**
 * Languageモデル
 *
 * @var Language
 */
	public $Language;

/**
 * PluginsRoleモデル
 *
 * @var PluginsRole
 */
	public $PluginsRole;

/**
 * 一度取得したプラグインデータを保持
 *
 * @var array|null
 */
	private $__plugins = null;

/**
 * コンストラクター
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function __construct(Controller $controller) {
		$this->__controller = $controller;

		$this->Language = ClassRegistry::init('M17n.Language');
		$this->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
	}

/**
 * 言語データを取得
 *
 * @return array
 */
	public function getLanguage() {
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

//		self::$__memoryCache['Language'][$cacheId] = $language;
//		Current::$current['Language'] = $language['Language'];
//
//		if (is_object(Current::$session) && $this->Language->useDbConfig !== 'test' &&
//				$language['Language']['code'] !== Configure::write('Config.language')) {
//			Configure::write('Config.language', $language['Language']['code']);
//			Current::$session->write('Config.language', $language['Language']['code']);
//		}
		return $language;
	}

/**
 * プラグインデータ取得
 *
 * @param array $pluginKeys プラグインキーリスト
 * @param string $langId 言語ID(intの文字列)
 * @return array
 */
	public function getPlugins($pluginKeys, $langId) {
		$queryOptions = [
			'recursive' => -1,
			'conditions' => [
				'key' => $pluginKeys,
				'language_id' => $langId,
			],
		];
		$cacheKey = md5(json_encode($queryOptions));

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

//		if (isset(Current::$current['Plugin'])) {
//			unset(Current::$current['Plugin']);
//		}
//
//		if (Current::$request->params['plugin'] === Current::PLUGIN_PAGES ||
//				Current::$request->params['plugin'] === CurrentSystem::PLUGIN_CONTROL_PANEL) {
//			return;
//		}
//
//		if (!isset(self::$__memoryCache['Plugin'])) {
//			//Pluginデータ取得
//			$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
//			self::$__memoryCache['Plugin'] = $this->Plugin->find('all', array(
//				'recursive' => -1,
//				'conditions' => array(),
//			));
//		}
//		$results = self::$__memoryCache['Plugin'];
//
//		$plugin = array();
//		foreach ($results as $result) {
//			// プラグインキーと言語で絞り込む
//			if ($result['Plugin']['key'] == Current::$request->params['plugin']
//					&& $result['Plugin']['language_id'] == Current::$current['Language']['id']) {
//				$plugin = $result;
//				break;
//			}
//		}
//
//		Current::setCurrent($plugin, true);

		return $results;
	}

/**
 * プラグインデータ取得
 *
 * @param string $pluginKey プラグインキー
 * @return void
 */
	public function getPlugin($pluginKey) {
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
	public function getPluginRole($userRoleKey) {
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
		$cacheKey = md5(json_encode($queryOptions));

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
