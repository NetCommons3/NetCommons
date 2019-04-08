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

App::uses('LibAppObject', 'NetCommons.Lib');
App::uses('NetCommonsSecurity', 'NetCommons.Utility');

/**
 * NetCommonsの機能に必要な情報(プラグイン関連)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property PluginsRole $PluginsRole PluginsRoleモデル
 * @property Plugin $Plugin Pluginモデル
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibUser $CurrentLibUser CurrentLibUserライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibPlugin extends LibAppObject {

/**
 * ControlPanelプラグイン名の定数
 */
	const PLUGIN_CONTROL_PANEL = 'control_panel';

/**
 * Usersプラグイン名の定数
 */
	const PLUGIN_USERS = 'users';

/**
 * Groupsプラグイン名の定数
 */
	const PLUGIN_GROUPS = 'groups';

/**
 * Wysiwygプラグイン名の定数
 */
	const PLUGIN_WYSIWYG = 'wysiwyg';

/**
 * Pagesプラグイン名の定数
 */
	const PLUGIN_PAGES = 'pages';

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'PluginsRole' => 'PluginManager.PluginsRole',
		'Plugin' => 'PluginManager.Plugin',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibUser' => 'NetCommons.Lib/Current',
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
	];

/**
 * セキュリティに関するユーティリティ
 *
 * @var NetCommonsSecurity
 */
	private $__NetCommonsSecurity = null;

/**
 * 言語IDを保持
 *
 * @var string 数値の文字列
 */
	private $__langId = null;

/**
 * インスタンスの取得
 *
 * @return CurrentLibPlugin
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
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		parent::initialize($controller);

		if (! $this->__NetCommonsSecurity) {
			$this->__NetCommonsSecurity = new NetCommonsSecurity();
		}
		$this->__langId = $this->CurrentLibLanguage->getLangId();
	}

/**
 * プラグインデータ取得
 *
 * @param array $pluginKeys プラグインキーリスト
 * @param string|int $langId 言語ID
 * @return array
 */
	public function findPlugins($pluginKeys, $langId) {
		$queryOptions = [
			'recursive' => -1,
			'fields' => [
				'id',
				'language_id',
				//'is_origin',
				//'is_translation',
				//'is_original_copy',
				'key',
				//'is_m17n',
				'name',
				'namespace',
				'weight',
				'type',
				'version',
				'commit_version',
				'commited',
				'default_action',
				'default_setting_action',
				'frame_add_action',
				'display_topics',
				'display_search',
				'serialize_data',
			],
			'conditions' => [
				//'key' => $pluginKeys,
				'language_id' => $langId,
			],
		];
		$cacheKey = $this->Plugin->createCacheQueryKey($queryOptions);

		$plugins = $this->Plugin->cacheRead('current', $cacheKey);
		if (! $plugins) {
			$plugins = $this->Plugin->cacheFindQuery('all', $queryOptions);
			$this->Plugin->cacheWrite($plugins, 'current', $cacheKey);
		}

		$results = [];
		foreach ($plugins as $plugin) {
			$pluginKey = $plugin['Plugin']['key'];
			if (in_array($pluginKey, $pluginKeys, true)) {
				$results[$pluginKey] = $plugin;
			}
		}
		return $results;
	}

/**
 * プラグインデータ取得
 *
 * @param string $pluginKey プラグインキー
 * @return array
 */
	public function findPlugin($pluginKey) {
		$plugins = $this->findPlugins([$pluginKey], $this->__langId);
		if (isset($plugins[$pluginKey])) {
			return $plugins[$pluginKey];
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
		//ログインしていない、IPアドレスによる制御
		if (! $userRoleKey ||
				! $this->__NetCommonsSecurity->enableAllowSystemPluginIps()) {
			return [];
		}

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

/**
 * 管理系プラグインの許可
 *
 * @param string $pluginKey プラグインkey
 * @return bool
 */
	public function allowSystemPlugin($pluginKey) {
		$user = $this->CurrentLibUser->getLoginUser();
		$pluginRoles = $this->findPluginRole($user['role_key']);
		if (! isset($pluginRoles['PluginsRole'])) {
			return false;
		}

		foreach ($pluginRoles['PluginsRole'] as $pluginRole) {
			if ($pluginRole['plugin_key'] === $pluginKey) {
				return true;
			}
		}
		return false;
	}

}
