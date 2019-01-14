<?php
/**
 * NetCommonsの機能として必要な情報を操作するライブラリ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SettingMode', 'NetCommons.Lib');
App::uses('ControlPanel', 'NetCommons.Lib');
App::uses('NcPermission', 'NetCommons.Lib');
App::uses('Current2Frame', 'NetCommons.Lib');
App::uses('Current2Page', 'NetCommons.Lib');
App::uses('CurrentPermission', 'NetCommons.Lib');
App::uses('CurrentRoom', 'NetCommons.Lib');
App::uses('Current2System', 'NetCommons.Lib');
App::uses('CurrentUser', 'NetCommons.Lib');

/**
 * NetCommonsの機能として必要な情報を操作するライブラリ
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
class Current2 {

/**
 * セッティングモードのワード
 *
 * @var string
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * インスタンス
 *
 * @var object
 */
	private static $__instance;

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	private static $__mainController;

/**
 * 現在処理しているプラグインに必要なデータを保持
 *
 * @var array
 */
	public static $current = array();

///**
// * Current data
// *
// * @var array
// */
//	public static $originalCurrent = array();
//
///**
// * 現在処理しているプラグインに対するパーミッションを保持
// *
// * @var array
// */
//	public static $permission = array();

/**
 * クラス内で処理するControlPanelインスタンス
 *
 * @var ControlPanel
 */
	public $ControlPanel;

/**
 * クラス内で処理するSettingModeインスタンス
 *
 * @var SettingMode
 */
	public $SettingMode;

/**
 * クラス内で処理するNcPermissionインスタンス
 *
 * @var NcPermission
 */
	public $NcPermission;

/**
 * クラス内で処理するCurrentFrameインスタンス
 *
 * @var Current2Frame
 */
	public $CurrentFrame;

/**
 * クラス内で処理するCurrentPageインスタンス
 *
 * @var Current2Page
 */
	public $CurrentPage;

/**
 * クラス内で処理するCurrentPermissionインスタンス
 *
 * @var CurrentPermission
 */
	public $CurrentPermission;

/**
 * クラス内で処理するCurrentRoomインスタンス
 *
 * @var CurrentRoom
 */
	public $CurrentRoom;

/**
 * クラス内で処理するCurrentSystemインスタンス
 *
 * @var Current2System
 */
	public $CurrentSystem;

/**
 * クラス内で処理するCurrentUserインスタンス
 *
 * @var CurrentUser
 */
	public $CurrentUser;

/**
 * インスタンスの取得
 *
 * 既存のstaticメソッドを有効にするために
 *
 * @return Current2
 */
	public static function getInstance() {
		if (! self::$__instance) {
			$className = __CLASS__;
			self::$__instance = new $className();
		}
		return self::$__instance;
	}

/**
 * Currentにセットする
 *
 * @return void
 */
	private function __setCurrent() {

	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	private function __setController($controller) {
		$this->_controller = $controller;

		$this->NcPermission = NcPermission::getInstance();
		$this->SettingMode = SettingMode::getInstance();

		$this->CurrentPage = Current2Page::getInstance($this->_controller);
		$this->CurrentSystem = Current2System::getInstance($this->_controller);
		$this->CurrentUser = CurrentUser::getInstance($this->_controller);
		$this->ControlPanel = ControlPanel::getInstance($this->_controller);

		$this->CurrentFrame = Current2Frame::getInstance($this->_controller);
		$this->CurrentPermission = CurrentPermission::getInstance($this->_controller);
		$this->CurrentRoom = CurrentRoom::getInstance($this->_controller);
	}

/**
 * 現在表示している情報の初期設定
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller) {
		$this->__setController($controller);

		//ログイン情報が変わっている場合、ログイン情報の更新
		if ($this->CurrentUser->isLoginChanged()) {
			$this->CurrentUser->renewSessionUser();
		}

		//言語のセット
		$this->CurrentSystem->setLanguage();

//		self::__setInstance();
//
//		self::$request = clone $controller->request;
//		self::$session = $controller->Session;
//		self::$layout = $controller->layout;
//
//		$User = ClassRegistry::init('Users.User');
//		$User->setSlaveDataSource();
//
//		if (isset(self::$current['User']['modified']) &&
//				(self::$current['User']['modified']) !== AuthComponent::user('modified')) {
//			$changeUser = $User->find('first', array(
//				'recursive' => 0,
//				'conditions' => array(
//					'User.id' => AuthComponent::user('id'),
//					'User.modified !=' => AuthComponent::user('modified'),
//				),
//			));
//			if ($changeUser) {
//				$sessionUser = $changeUser['User'];
//				unset($changeUser['User']);
//				$sessionUser += $changeUser;
//				foreach ($sessionUser as $key => $value) {
//					CakeSession::write(AuthComponent::$sessionKey . '.' . $key, $value);
//				}
//			}
//		}
//		self::$current['User'] = AuthComponent::user();
//
//		self::$_instanceSystem->initialize();
//
//		if (! self::isControlPanel()) {
//			self::$_instanceFrame->initialize();
//		}
//
//		//会員権限に紐づくパーミッションのセット
//		if (isset(self::$current['User']['role_key'])) {
//			$roleKey = self::$current['User']['role_key'];
//		} else {
//			$roleKey = null;
//		}
//		self::$_instancePage->setDefaultRolePermissions($roleKey, true);
//
//		if (empty($controller->request->params['requested'])) {
//			self::$originalCurrent = self::$current;
//		}
	}
//
///**
// * setup current data
// *
// * @param Controller $controller コントローラ
// * @return void
// */
//	public static function terminate(Controller $controller) {
////		self::$current = self::$originalCurrent;
//	}

/**
 * 指定された$keyの値を返します。
 *
 * 現在のBlockKeyを取得したい場合
 * ```
 * Cuurent::read('Block.key')
 * ```
 *
 * @param string|null $key Hashクラスのpath
 * @param array|string|int|bool|null $default デフォルト値
 * @return array|null
 */
	public static function read($key = null, $default = null) {
		if (! isset(self::$current) || ! $key) {
			return self::$current;
		}

		$keyArray = explode('.', $key);
		$count = count($keyArray);
		if ($count === 1) {
			if (isset(self::$current[$keyArray[0]])) {
				return self::$current[$keyArray[0]];
			} else {
				return $default;
			}
		} elseif ($count === 2) {
			if (isset(self::$current[$keyArray[0]][$keyArray[1]])) {
				return self::$current[$keyArray[0]][$keyArray[1]];
			} else {
				return $default;
			}
		} elseif ($count === 3) {
			if (isset(self::$current[$keyArray[0]][$keyArray[1]][$keyArray[2]])) {
				return self::$current[$keyArray[0]][$keyArray[1]][$keyArray[2]];
			} else {
				return $default;
			}
		} else {
			return Hash::get(self::$current, $key, $default);
		}
	}

/**
 * 指定された$key(権限名文字列)の値を返します。
 *
 * ```
 * Current::permission('content_publishable')
 * ```
 *
 * @param string $key Hashクラスのpath
 * @param int|null $roomId ルームID
 * @return bool permission value
 */
	public static function permission($key, $roomId = null) {
		$instance = self::getInstance();
		return $instance->NcPermission->read($key, $roomId);
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
 * @param mixed $value セットする値
 * @return void
 */
	public static function write($key, $value) {
		if (! isset(self::$current)) {
			self::$current = [];
		}
		if (! isset($key)) {
			self::$current = Hash::merge(self::$current, $value);
		} else {
			$keyArray = explode('.', $key);
			$count = count($keyArray);
			if ($count === 1) {
				self::$current[$keyArray[0]] = $value;
			} elseif ($count === 2) {
				self::$current[$keyArray[0]][$keyArray[1]] = $value;
			} elseif ($count === 3) {
				self::$current[$keyArray[0]][$keyArray[1]][$keyArray[2]] = $value;
			} else {
				self::$current = Hash::insert(self::$current, $key, $value);
			}
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
		if (! isset(self::$current) || ! $key) {
			self::$current = array();
			return;
		}

		$keyArray = explode('.', $key);
		$count = count($keyArray);
		if ($count === 1) {
			if (isset(self::$current[$keyArray[0]])) {
				unset(self::$current[$keyArray[0]]);
			}
		} elseif ($count === 2) {
			if (isset(self::$current[$keyArray[0]][$keyArray[1]])) {
				unset(self::$current[$keyArray[0]][$keyArray[1]]);
			}
		} elseif ($count === 3) {
			if (isset(self::$current[$keyArray[0]][$keyArray[1]][$keyArray[2]])) {
				unset(self::$current[$keyArray[0]][$keyArray[1]][$keyArray[2]]);
			}
		} else {
			self::$current = Hash::remove(self::$current, $key);
		}
	}

/**
 * ログインチェック
 *
 * @return bool
 */
	public static function isLogin() {
		$instance = self::getInstance();
		return $instance->CurrentUser->isLogined();
	}

/**
 * セッティングモードチェック
 *
 * @return bool
 */
	public static function isSettingMode() {
		$instance = self::getInstance();
		return $instance->SettingMode->isSettingMode();
	}

/**
 * セッティングモードチェック
 *
 * @param bool|null $settingMode セッティングモードの状態変更
 * @return void
 */
	public static function setSettingMode($settingMode) {
		$instance = self::getInstance();
		$instance->SettingMode->setSettingMode($settingMode);
	}

/**
 * セッティングモードの有無
 *
 * @return bool
 */
	public static function hasSettingMode() {
		$instance = self::getInstance();
		return $instance->SettingMode->hasSettingMode();
	}

/**
 * コントロールパネルチェック
 *
 * @return bool
 */
	public static function isControlPanel() {
		$instance = self::getInstance();
		return $instance->ControlPanel->isControlPanel();
	}

/**
 * コントロールパネルとするプラグインキーのセット
 *
 * @param array $controlPanelKeys セットするプラグインタイプキー
 * @return bool
 */
	public static function setControlPanelKeys($controlPanelKeys) {
		ControlPanel::setControlPanelKeys($controlPanelKeys);
	}

/**
 * コントロールパネルの有無
 *
 * @return bool
 */
	public static function hasControlPanel() {
		$instance = self::getInstance();
		return $instance->ControlPanel->hasControlPanel();
	}

/**
 * 管理系プラグインの許可
 *
 * @param string $pluginKey プラグインkey
 * @return bool
 */
	public static function allowSystemPlugin($pluginKey) {
		$instance = self::getInstance();
		return $instance->ControlPanel->allowSystemPlugin($pluginKey);
	}

}
