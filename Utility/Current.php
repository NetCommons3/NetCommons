<?php
/**
 * Current Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CurrentSystem', 'NetCommons.Utility');
App::uses('CurrentFrame', 'NetCommons.Utility');
App::uses('CurrentPage', 'NetCommons.Utility');
App::uses('UserRole', 'UserRoles.Model');
App::uses('Plugin', 'PluginManager.Model');

/**
 * Current Utility
 *
 * NetCommonsの機能として必要な情報を保持します。<br>
 * [NetCommonsAppController::beforeFilter](https://github.com/NetCommons3/NetCommons3Docs/blob/master/phpdocMd/NetCommons/NetCommonsAppController.md#beforefilter)
 * で初期処理が呼び出され、値が設定されます。<br>
 * 値を取得する時は、[readメソッド](#read)を使用します。<br>
 * 権限を取得する時は、[permissionメソッド](#permission)を使用します。<br>
 *
 * #### 保持データ
 * ```
 * Array(
 * 	[User] => Array(
 * 		[id] => 1
 * 		[username] => admin
 * 		[key] => 640f981d6104fd21463d674f18477348
 * 		[avatar] =>
 * 		[avatar_file_id] =>
 * 		[is_avatar_public] =>
 * 		[handlename] => admin
 * 		[is_handlename_public] =>
 * 		[is_name_public] =>
 * 		[email] =>
 * 		[is_email_public] =>
 *
 * 		・・・
 *
 * 		[Role] => Array(
 * 			[id] => 1
 * 			[language_id] => 2
 * 			[key] => system_administrator
 * 			[type] => 1
 * 			[name] => システム管理者
 * 			[is_system] => 1
 * 		)
 * 	)
 *
 * 	[Language] => Array(
 * 		[id] => 2
 * 		[code] => ja
 * 		[weight] => 2
 * 		[is_active] => 1
 * 	)
 *
 * 	[PluginsRole] => Array(
 * 		[13] => Array(
 * 			[id] => 13
 * 			[role_key] => system_administrator
 * 			[plugin_key] => rooms
 * 		)
 *
 * 		[20] => Array(
 * 			[id] => 20
 * 			[role_key] => system_administrator
 * 			[plugin_key] => user_manager
 * 		)
 *
 * 	)
 *
 * 	[Page] => Array(
 * 		[id] => 1
 * 		[room_id] => 1
 * 		[parent_id] =>
 * 		[lft] => 1
 * 		[rght] => 2
 * 		[permalink] =>
 * 		[slug] =>
 * 		[is_published] => 1
 * 		[from] =>
 * 		[to] =>
 * 		[is_container_fluid] =>
 * 	)
 *
 * 	[Room] => Array(
 * 		[id] => 1
 * 		[space_id] => 2
 * 		[page_id_top] => 1
 * 		[root_id] =>
 * 		[parent_id] =>
 * 		[lft] => 1
 * 		[rght] => 2
 * 		[active] => 1
 * 		[default_role_key] => visitor
 * 		[need_approval] => 1
 * 		[default_participation] => 1
 * 		[page_layout_permitted] => 1
 * 	)
 *
 * 	[ParentPage] => Array(
 * 		・・・
 * 	)
 *
 * 	[RolesRoomsUser] => Array(
 * 		・・・
 * 	)
 *
 * 	[RolesRoom] => Array(
 * 		・・・
 * 	)
 *
 * ・・・
 *
 * 	[Permission] => Array(
 * 		[page_editable] => Array(
 * 			[id] => 9
 * 			[role_key] => room_administrator
 * 			[type] => room_role
 * 			[permission] => page_editable
 * 			[value] => 1
 * 			[fixed] => 1
 * 			[roles_room_id] => 1
 * 		)
 *
 * 		[block_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_readable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_creatable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_publishable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_creatable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_publishable] => Array(
 * 			・・・
 * 		)
 *
 * 		[block_permission_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[html_not_limited] => Array(
 * 			・・・
 * 		)
 *
 * 	)
 *
 * 	[Plugin] => Array(
 * 		[id] => 5
 * 		[language_id] => 2
 * 		[key] => announcements
 * 		[name] => お知らせ
 * 		[namespace] => netcommons/announcements
 * 		[weight] =>
 * 		[type] => 1
 * 		[default_action] => announcements/view
 * 		[default_setting_action] => announcement_blocks/index
 * 	)
 *
 * 	[Frame] => Array(
 * 		[id] => 1
 * 		[language_id] => 2
 * 		[room_id] => 1
 * 		[box_id] => 3
 * 		[plugin_key] => announcements
 * 		[block_id] => 1
 * 		[key] => frame_1
 * 		[name] => お知らせ
 * 		[header_type] => default
 * 		[translation_engine] =>
 * 		[is_first_auto_translation] =>
 * 		[is_auto_translated] =>
 * 		[weight] => 1
 * 		[is_deleted] =>
 * 	)
 *
 * 	[Box] => Array(
 * 		[id] => 3
 * 		[container_id] => 3
 * 		[type] => 4
 * 		[space_id] =>
 * 		[room_id] => 1
 * 		[page_id] => 1
 * 		[weight] => 1
 * 	)
 *
 * 	[Block] => Array(
 * 		[id] => 1
 * 		[language_id] => 2
 * 		[room_id] => 1
 * 		[plugin_key] => announcements
 * 		[key] => block_1
 * 		[name] => NetCommons 3! セッティングモードで編集しよう.
 * 		[public_type] => 1
 * 		[from] =>
 * 		[to] =>
 * 		[translation_engine] =>
 * 		[is_auto_translated] =>
 * 		[is_first_auto_translation] =>
 * 	)
 * )
 * ```
 *
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentBase {

/**
 * Current data
 *
 * @var array
 */
	public static $current = array();

/**
 * 指定された$keyの値を返します。
 *
 * 現在のBlockKeyを取得したい場合
 * ```
 * Cuurent::read('Block.key')
 * ```
 *
 * @param string|null $key Hashクラスのpath
 * @param mixed $default デフォルト値
 * @return array|null Current data.
 */
	public static function read($key = null, $default = null) {
		if (! isset(self::$current)) {
			return self::$current;
		}

		if (! isset($key)) {
			return self::$current;
		}
		return Hash::get(self::$current, $key, $default);
	}

/**
 * 指定された$keyの値をセットします
 *
 * 現在のBlockKeyをセットしたい場合
 * ```
 * Cuurent::write('Block.key', 'block_key)
 * ```
 *
 * @param string|null $key Hashクラスのpath、nullの場合、Hash::mergeする
 * @param mixted $value セットする値
 * @return void
 */
	public static function write($key, $value) {
		if (! isset(self::$current)) {
			self::$current = array();
		}
		if (! isset($key)) {
			self::$current = Hash::merge(self::$current, $value);
		} else {
			self::$current = Hash::insert(self::$current, $key, $value);
		}
	}

/**
 * 指定された$keyの値を削除します。
 *
 * 現在のBlockKeyを削除したい場合
 * ```
 * Cuurent::remove('Block.key')
 * ```
 *
 * @param string|null $key Hashクラスのpath
 * @return array|null Current data.
 */
	public static function remove($key = null) {
		if (! isset(self::$current) || ! isset($key)) {
			self::$current = array();
		}

		Hash::remove(self::$current, $key);
	}

/**
 * 指定された$key(権限名文字列)の値を返します。
 *
 * ```
 * Current::permission('content_publishable')
 * ```
 *
 * @param string $key Hashクラスのpath
 * @return bool permission value
 */
	public static function permission($key) {
		if (! isset(self::$current)) {
			return false;
		}
		$path = 'Permission.' . $key . '.value';
		return (bool)Hash::get(self::$current, $path);
	}

}


/**
 * Current Utilityチェック
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class Current extends CurrentBase {

/**
 * Constant setting mode value
 */
	const SETTING_MODE_WORD = 'setting';

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
 * is setting mode true
 *
 * @var bool
 */
	protected static $_isSettingMode = null;

/**
 * Request object
 *
 * @var mixed
 */
	public static $request;

/**
 * Instance object
 *
 * @var mixed
 */
	protected static $_instance;

/**
 * M17n data
 *
 * @var array
 */
	public static $m17n = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$_instance) {
			self::$_instance = new Current();
		}

		self::$request = clone $request;

		self::$current['User'] = AuthComponent::user();

		(new CurrentSystem())->initialize();

		if (! self::isControlPanel()) {
			(new CurrentFrame())->initialize();
		}
	}

/**
 * 多言語のデータ取得
 *
 * @param string|null $languageId 言語ID
 * @param string|null $model モデル名
 * @param string|null $field フィールド名
 * @return mixed Current data.
 */
	public static function readM17n($languageId, $model = null, $field = null) {
		if (! isset(self::$m17n)) {
			return self::$m17n;
		}

		if (! isset($model)) {
			return self::$m17n;
		}

		if (! isset(self::$m17n[$model])) {
			return null;
		}
		if (! isset($languageId)) {
			return self::$m17n[$model];
		}

		$result = Hash::extract(self::$m17n, $model . '.{n}.' . $model . '[language_id=' . $languageId . ']');
		if (! $result) {
			return null;
		}

		if (! isset($field)) {
			return array($model => $result[0]);
		} else {
			return $result[0][$field];
		}
	}

/**
 * ログインチェック
 *
 * @return bool
 */
	public static function isLogin() {
		return (bool)AuthComponent::user('id');
	}

/**
 * セッティングモードチェック
 *
 * @param bool|null $settingMode セッティングモードの状態変更
 * @return bool
 */
	public static function isSettingMode($settingMode = null) {
		if (isset($settingMode)) {
			self::$_isSettingMode = $settingMode;
		}

		if (isset(self::$_isSettingMode)) {
			return self::$_isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			self::$_isSettingMode = true;
		} else {
			self::$_isSettingMode = false;
		}

		return self::$_isSettingMode;
	}

/**
 * セッティングモードの有無
 *
 * @return bool
 */
	public static function hasSettingMode() {
		return self::permission('page_editable');
	}

/**
 * コントロールパネルチェック
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$request->params['plugin'] === CurrentSystem::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$current['Plugin'])) {
			return false;
		}

		if (in_array(self::$current['Plugin']['type'], array(Plugin::PLUGIN_TYPE_FOR_SITE_MANAGER, Plugin::PLUGIN_TYPE_FOR_SYSTEM_MANGER), true)) {
			return true;
		} else {
			return false;
		}
	}

/**
 * コントロールパネルの有無
 *
 * @return bool
 */
	public static function hasControlPanel() {
		if (! isset(self::$current['PluginsRole'])) {
			return false;
		} else {
			return (bool)count(self::$current['PluginsRole']);
		}
	}

/**
 * 管理系プラグインの許可
 *
 * @param string $pluginKey プラグインkey
 * @return bool
 */
	public static function allowSystemPlugin($pluginKey) {
		if (! isset(self::$current['PluginsRole'])) {
			return false;
		}
		if (self::read('User.role_key') === UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR) {
			return true;
		}

		return Hash::check(Current::$current['PluginsRole'], '{n}[plugin_key=' . $pluginKey . ']');
	}

}
