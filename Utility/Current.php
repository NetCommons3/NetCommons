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

App::uses('CurrentBase', 'NetCommons.Utility');
App::uses('CurrentSystem', 'NetCommons.Utility');
App::uses('CurrentFrame', 'NetCommons.Utility');
App::uses('CurrentPage', 'NetCommons.Utility');
App::uses('UserRole', 'UserRoles.Model');
App::uses('Plugin', 'PluginManager.Model');

/**
 * Current Utility
 *
 * NetCommonsの機能として必要な情報を保持します。<br>
 * [NetCommonsAppController::beforeFilter](./NetCommonsAppController.html#method_beforeFilter)
 * で初期処理が呼び出され、値が設定されます。<br>
 * 値を取得する時は、[readメソッド](#method_read)を使用します。<br>
 * 権限を取得する時は、[permissionメソッド](#method_permission)を使用します。<br>
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
 * Session object
 *
 * @var mixed
 */
	public static $session;

/**
 * layout
 *
 * @var string
 */
	public static $layout;

/**
 * Instance object
 *
 * @var mixed
 */
	protected static $_instance;

/**
 * setup current data
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public static function initialize(Controller $controller) {
		if (! self::$_instance) {
			self::$_instance = new Current();
		}

		self::$request = clone $controller->request;
		self::$session = clone $controller->Session;
		self::$layout = $controller->layout;

		if (Hash::get(self::$current, 'User.modified') !== AuthComponent::user('modified')) {
			$User = ClassRegistry::init('Users.User');
			$changeUser = $User->find('first', array(
				'recursive' => 0,
				'conditions' => array(
					'User.id' => AuthComponent::user('id'),
					'User.modified !=' => AuthComponent::user('modified'),
				),
			));
			if ($changeUser) {
				$sessionUser = $changeUser['User'];
				unset($changeUser['User']);
				CakeSession::write(
					AuthComponent::$sessionKey, array_merge_recursive($sessionUser, $changeUser)
				);
			}
		}
		self::$current['User'] = AuthComponent::user();

		(new CurrentSystem())->initialize();

		if (! self::isControlPanel()) {
			(new CurrentFrame())->initialize();
		}

		//会員権限に紐づくパーミッションのセット
		(new CurrentPage())->setDefaultRolePermissions(Hash::get(self::$current, 'User.role_key'), true);
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
		return self::permission('page_editable', Current::read('Page.room_id'));
	}

/**
 * コントロールパネルチェック
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (! isset(self::$request)) {
			return false;
		}

		if (self::$request->params['plugin'] === CurrentSystem::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$current['Plugin'])) {
			return false;
		}

		$controlPanelKeys = array(
			Plugin::PLUGIN_TYPE_FOR_SITE_MANAGER, Plugin::PLUGIN_TYPE_FOR_SYSTEM_MANGER
		);
		if (in_array(self::$current['Plugin']['type'], $controlPanelKeys, true)) {
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
		//if (self::read('User.role_key') === UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR) {
		//	return true;
		//}
		return Hash::check(Current::$current['PluginsRole'], '{n}[plugin_key=' . $pluginKey . ']');
	}

/**
 * 取得した結果を$currentにセットする
 *
 * @param array $results 取得結果
 * @param array $forceMargeModels 既に取得済みでも強制でマージするModelのリスト
 * @return void
 */
	public static function setCurrent($results, $forceMargeModels = []) {
		if (! $results) {
			return;
		}
		$models = array_keys($results);

		foreach ($models as $model) {
			if (array_key_exists('id', $results[$model]) && ! Hash::get($results[$model], 'id')) {
				continue;
			}
			if (! isset(Current::$current[$model]) ||
					$forceMargeModels === true || in_array($model, $forceMargeModels, true)) {
				Current::$current[$model] = $results[$model];
			}
		}
	}

}
