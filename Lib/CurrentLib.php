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

App::uses('LibAppObject', 'NetCommons.Lib');
App::uses('Role', 'Roles.Model');
App::uses('CurrentLibPlugin', 'NetCommons.Lib/Current');
App::uses('SettingMode', 'NetCommons.Lib');

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
 * @property Controller $_controller コントローラ
 * @property SettingMode $SettingMode SettingModeライブラリ
 * @property ControlPanel $ControlPanel ControlPanelライブラリ
 * @property NcPermission $NcPermission NcPermissionライブラリ
 * @property CurrentLibFrame $CurrentLibFrame CurrentLibFrameライブラリ
 * @property CurrentLibPage $CurrentLibPage CurrentLibPageライブラリ
 * @property CurrentLibPermission $CurrentLibPermission CurrentLibPermissionライブラリ
 * @property CurrentLibRoom $CurrentLibRoom CurrentLibRoomライブラリ
 * @property CurrentLibBlock $CurrentLibBlock CurrentLibBlockライブラリ
 * @property CurrentLibPlugin $CurrentLibPlugin CurrentLibPluginライブラリ
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibUser $CurrentLibUser CurrentLibUserライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods) 別ファイルにすると分かりにくくなるため
 * @SuppressWarnings(PHPMD.TooManyMethods) 別ファイルにすると分かりにくくなるため
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity) $current変数を直接書き換えている処理が多数あり、分割できないため
 */
class CurrentLib extends LibAppObject {

/**
 * セッティングモードのワード
 *
 * 適切なライブラリに持っていきたいが、旧Currentライブラリで使用されているため、当クラスにも定義する。
 *
 * @var string
 */
	const SETTING_MODE_WORD = SettingMode::SETTING_MODE_WORD;

/**
 * Usersプラグイン名の定数
 *
 * 適切なライブラリに持っていきたいが、旧Currentライブラリで使用されているため、当クラスにも定義する。
 *
 * @var string
 */
	const PLUGIN_USERS = CurrentLibPlugin::PLUGIN_USERS;

/**
 * Groupsプラグイン名の定数
 *
 * 適切なライブラリに持っていきたいが、旧Currentライブラリで使用されているため、当クラスにも定義する。
 *
 * @var string
 */
	const PLUGIN_GROUPS = CurrentLibPlugin::PLUGIN_GROUPS;

/**
 * Wysiwygプラグイン名の定数
 *
 * 適切なライブラリに持っていきたいが、旧Currentライブラリで使用されているため、当クラスにも定義する。
 *
 * @var string
 */
	const PLUGIN_WYSIWYG = CurrentLibPlugin::PLUGIN_WYSIWYG;

/**
 * Pagesプラグイン名の定数
 *
 * 適切なライブラリに持っていきたいが、旧Currentライブラリで使用されているため、当クラスにも定義する。
 *
 * @var string
 */
	const PLUGIN_PAGES = CurrentLibPlugin::PLUGIN_PAGES;

/**
 * 現在処理しているプラグインに必要なデータを保持
 *
 * privateメソッドにしたいが、直接書き換える処理が多数行われているため、
 * publicのままとする
 *
 * @var array
 */
	public static $current = [];

/**
 * 現在処理しているプラグインに対するパーミッションを保持
 *
 * NcPermissionクラスのメンバ変数として、定義したいが、
 * Current::$permissionとして、直接書き換える処理が多数行われているため、
 * NcPermissionクラスのメンバ変数ではなく、CurrentLibクラスとする。
 *
 * @var array
 */
	public static $permission = [];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibLanguage' => 'NetCommons.Lib/Current', //最初に実行する必要あり
		'CurrentLibUser' => 'NetCommons.Lib/Current', //最初に実行する必要あり
		'SettingMode' => 'NetCommons.Lib',
		'ControlPanel' => 'NetCommons.Lib',
		'NcPermission' => 'NetCommons.Lib',
		'CurrentLibFrame' => 'NetCommons.Lib/Current',
		'CurrentLibPage' => 'NetCommons.Lib/Current',
		'CurrentLibPermission' => 'NetCommons.Lib/Current',
		'CurrentLibRoom' => 'NetCommons.Lib/Current',
		'CurrentLibBlock' => 'NetCommons.Lib/Current',
		'CurrentLibPlugin' => 'NetCommons.Lib/Current',
	];

/**
 * インスタンスの取得
 *
 * @return CurrentLib
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
		self::clear();
		parent::_resetInstance(__CLASS__);
	}

/**
 * コントローラごとに初期する必要がある$current変数の初期化処理
 *
 * @return void
 */
	private function __clearCurrent() {
		self::$current['DefaultRolePermission'] = [];
		self::$current['Permission'] = [];

		$unsets = [
			'Room',
			'Space',
			'RoomsLanguage',
			'PluginsRoom',
			'RolesRoomsUser',
			'RolesRoom',
			'RoomRolePermission',
			'Box',
			'BoxesPageContainer',
			'Frame',
			'FramePublicLanguage',
			'FramesLanguage',
			'Block',
			'BlocksLanguage',
			'BlockRolePermission',
			'Plugin',
		];
		foreach ($unsets as $modelName) {
			if (isset(self::$current[$modelName])) {
				unset(self::$current[$modelName]);
			}
		}
	}

/**
 * ユーザ関連のデータをCurrentにセットする
 *
 * @return void
 */
	private function __setCurrentUser() {
		//ログイン情報が変わっている場合、ログイン情報の更新
		$isLoginChanged = $this->CurrentLibUser->isLoginChanged();
		if ($isLoginChanged) {
			$this->CurrentLibUser->renewSessionUser();
		}

		if ($isLoginChanged ||
				! isset(self::$current['User']) ||
				empty($this->_controller->request->params['requested'])) {
			self::$current['User'] = $this->CurrentLibUser->getLoginUser();
		}

		//会員関連のパーミッションセット
		$userRoleKey = $this->CurrentLibUser->getLoginUserRoleKey();
		if ($userRoleKey) {
			$permissions = $this->CurrentLibPermission->findDefaultRolePermissions($userRoleKey);
			self::$current['DefaultRolePermission'] += $permissions;
			$this->writeCurrentPermissions('0', $permissions);
		}
	}

/**
 * 言語データをCurrentにセットする
 *
 * @return void
 */
	public function setCurrentLanguage() {
		$language = $this->CurrentLibLanguage->findLanguage();
		if (isset($language['Language'])) {
			self::$current['Language'] = $language['Language'];
			$this->CurrentLibLanguage->setConfigure($language['Language']['code']);
		}
	}

/**
 * プラグイン関連のデータをCurrentにセットする
 *
 * @return void
 */
	private function __setCurrentPlugin() {
		$CurrentLibPlugin = $this->CurrentLibPlugin;
		$pluginKey = $this->_controller->request->params['plugin'];

		if ($pluginKey === $CurrentLibPlugin::PLUGIN_PAGES ||
				$pluginKey === $CurrentLibPlugin::PLUGIN_CONTROL_PANEL) {
			return;
		}

		$plugin = $this->CurrentLibPlugin->findPlugin($pluginKey);
		self::$current['Plugin'] = $plugin['Plugin'];

		if (empty($this->_controller->request->params['requested'])) {
			//管理系のプラグイン取得
			$userRoleKey = $this->CurrentLibUser->getLoginUserRoleKey();
			$pluginRoles = $this->CurrentLibPlugin->findPluginRole($userRoleKey);
			if (isset($pluginRoles['PluginsRole'])) {
				self::$current['PluginsRole'] = $pluginRoles['PluginsRole'];
			}
		}
	}

/**
 * ページ関連のデータをCurrentにセットする
 *
 * @return void
 */
	private function __setCurrentPage() {
		if (empty($this->_controller->request->params['requested'])) {
			//初回のみセットする(requestActionで呼ばれた際はセットしない)
			$roomId = null;
			if ($this->_controller->request->params['plugin'] === CurrentLibPlugin::PLUGIN_WYSIWYG) {
				//Wysiwygの場合、ページ情報を取得する必要なし
				if (isset($this->_controller->request->data['Room']['id'])) {
					$roomId = $this->_controller->request->data['Room']['id'];
				} else {
					$roomId = $this->_controller->request->params['pass'][0];
				}
			}
			//$roomIdがある場合、ページを取得しない
			if ($roomId) {
				$this->__setCurrentRoom($roomId);
			} else {
				$this->setCurrentPage();
			}
		}
	}

/**
 * ページ関連のデータをCurrentにセットする
 *
 * @param string|int $pageId ページID
 * @return bool セット出来たか否か
 */
	public function setCurrentPage($pageId = null) {
		$topPage = $this->CurrentLibPage->findTopPage();
		if (isset($topPage['Page'])) {
			self::$current['TopPage'] = $topPage['Page'];
		} else {
			self::$current['TopPage'] = null;
		}

		if ($pageId) {
			$page = $this->CurrentLibPage->findPage($pageId);
			if ($page['Page']['id'] == $pageId) {
				$this->CurrentLibPage->setCurrentPage($page);
			} else {
				return false;
			}
		} else {
			$page = $this->CurrentLibPage->findCurrentPage();
		}
		if ($page) {
			self::$current += $page;

			$this->__setCurrentRoom($page['Page']['room_id']);

			$blockKeys = $this->CurrentLibBlock->getBlockKeysInCurrentPage();
			$this->CurrentLibBlock->setBlockRolePermissions($page['Page']['room_id'], $blockKeys);
			$this->CurrentLibBlock->setUseWorkflowPermissions($page['Page']['room_id'], $blockKeys);
			return true;
		} else {
			return false;
		}
	}

/**
 * ページ関連のデータをCurrentにセットする
 *
 * @param string $permalink パーマリンク
 * @param string|int|null $spaceId スペースID
 * @return bool セット出来たか否か
 */
	public function setCurrentPageByPermalink($permalink, $spaceId) {
		$pageId = $this->CurrentLibPage->getPageIdByPermalink($permalink, $spaceId);
		if ($pageId) {
			$result = $this->setCurrentPage($pageId);
			return $result;
		} else {
			return false;
		}
	}

/**
 * ページコンテナー関連のデータをCurrentにセットする
 *
 * GET
 *
 * @return void
 */
	private function __setCurrentPageContainer() {
		if (empty($this->_controller->request->params['requested'])) {
			if (isset(self::$current['Page']['id'])) {
				self::$current['PageContainer'] =
						$this->CurrentLibPage->findCurrentPageContainer();
			}
		}
	}

/**
 * フレーム関連のデータをCurrentにセットする
 *
 * @param string|int|null $frameId フレームID
 * @return void
 */
	private function __setCurrentFrame($frameId) {
		if ($frameId) {
			//フレームIDがある場合
			$frame = $this->CurrentLibFrame->findFrameById($frameId);
			self::$current += $frame;
			self::$current += $this->CurrentLibPage->findBoxById($frame['Frame']['box_id']);
			$blockId = $frame['Frame']['block_id'];
			$roomId = $frame['Frame']['room_id'];
		}

		if ($this->CurrentLibBlock->isBlockIdInRequest()) {
			//リクエストにブロックIDがある場合
			$blockId = $this->CurrentLibBlock->getCurrentBlockId();
			$block = $this->CurrentLibBlock->findBlockById($blockId);

			if (empty($frame) && !empty($block)) {
				self::$current['Block'] = $block['Block'];
				self::$current['BlocksLanguage'] = $block['BlocksLanguage'];
				$roomId = $block['Block']['room_id'];
			} elseif ($this->CurrentLibFrame->isSameRoomAndPluginByRequestBlockAndFrameBlock($frame, $block) &&
					! $this->CurrentLibFrame->isSameBlockByRequestBlockAndFrameBlock($frame, $block)) {
				$this->CurrentLibFrame->setBlockInFrame($frame['Frame']['id'], $block);
				self::$current['Block'] = $block['Block'];
				self::$current['BlocksLanguage'] = $block['BlocksLanguage'];
				$blockId = $block['Block']['id'];
				$roomId = $block['Block']['room_id'];
			} else {
				$blockId = $frame['Frame']['block_id'];
				$roomId = $frame['Frame']['room_id'];
			}
		}

		if (!empty($roomId)) {
			//ルーム関連データのセット
			$this->__setCurrentRoom($roomId);
			//ブロック関連データのセット
			$this->__setCurrentBlock($roomId, $blockId);

			//当該ルーム内で設置しているフレームに遷移した方がい良いが、パフォーマンスが遅くなるため、
			//フレームなしとして、各設定のデフォルトを使用する。
			//バグっぽかったら、ここに組み込む。
		}
	}

/**
 * ブロック関連のデータをCurrentにセットする
 *
 * @param string|int $roomId ルームID
 * @param string|int $blockId ブロックID
 * @return void
 */
	private function __setCurrentBlock($roomId, $blockId) {
		if ($blockId) {
			$block = $this->CurrentLibBlock->findBlockById($blockId);
			self::$current += $block;

			$blockKey = $block['Block']['key'];
			$permissions =
				$this->CurrentLibBlock->findBlockRolePermissionsByBlockKey($roomId, $blockKey);
			if (isset(self::$current['BlockRolePermission'])) {
				self::$current['BlockRolePermission'] += $permissions;
			} else {
				self::$current['BlockRolePermission'] = $permissions;
			}
			$this->writeCurrentPermissions($roomId, $permissions);
		} else {
			$blockKey = null;
		}

		$permissions = $this->CurrentLibBlock->findUseWorkflowPermissionsByBlockKey($roomId, $blockKey);
		$this->writeCurrentPermissions($roomId, $permissions);
	}

/**
 * ルーム関連のデータをCurrentにセットする
 *
 * @param string|int $roomId ルームID
 * @return void
 */
	private function __setCurrentRoom($roomId) {
		//ルームデータのセット
		self::$current += $this->CurrentLibRoom->findRoomById($roomId);

		//ルームのプラグインデータのセット
		if (!empty(self::$current['Space']['after_user_save_model'])) {
			$roomIdTop = self::$current['Space']['room_id_root'];
			self::$current['PluginsRoom'] = $this->CurrentLibRoom->findPluginsRoom($roomIdTop);
		} else {
			self::$current['PluginsRoom'] = $this->CurrentLibRoom->findPluginsRoom($roomId);
		}

		//ユーザのルーム権限データのセット
		self::$current += $this->CurrentLibRoom->findUserRoomRoleByRoomId($roomId);
		$roomRoleKey = $this->CurrentLibRoom->getRoomRoleKeyByRoomId($roomId);
		if (! $roomRoleKey) {
			$roomRoleKey = Role::ROOM_ROLE_KEY_VISITOR;
		}

		// * デフォルトロールパーミッションデータのセット
		$permissions = $this->CurrentLibPermission->findDefaultRolePermissions($roomRoleKey);
		if (isset(self::$current['DefaultRolePermission'])) {
			self::$current['DefaultRolePermission'] += $permissions;
		} else {
			self::$current['DefaultRolePermission'] = $permissions;
		}
		$this->writeCurrentPermissions($roomId, $permissions);
		// * ルームロールパーミッションデータのセット
		$permissions = $this->CurrentLibRoom->findRoomRolePermissions($roomId);
		if (isset(self::$current['RoomRolePermission'])) {
			self::$current['RoomRolePermission'] += $permissions;
		} else {
			self::$current['RoomRolePermission'] = $permissions;
		}

		$this->writeCurrentPermissions($roomId, $permissions);
	}

/**
 * 現在表示している情報の初期設定
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function doInitializeLibs($controller) {
		//イニシャライズの実行
		parent::initialize($controller);
		$libs = array_keys($this->libs);
		foreach ($libs as $class) {
			parent::$_instances[$class]->initialize($controller);
		}
	}

/**
 * 現在表示している情報の初期設定
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		//イニシャライズの実行
		$this->doInitializeLibs($controller);

		//コントローラごとに初期する必要がある$currentの中身を初期化する
		$this->__clearCurrent();

		//ログイン情報のセット
		$this->__setCurrentUser();

		//言語データのセット
		$this->setCurrentLanguage();

		//プラグイン関連のデータセット
		$this->__setCurrentPlugin();

		if (! $this->ControlPanel->isControlPanel()) {
			//コントロールパネルでないなら、ページ情報を取得する
			$this->__setCurrentPage();
			if ($this->_controller->request->is('get')) {
				$this->__setCurrentPageContainer();
			}

			$frameId = $this->CurrentLibFrame->getCurrentFrameId();
			$this->__setCurrentFrame($frameId);
		}
	}

/**
 * 現在表示している情報の終了処理
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function terminate($controller = null) {
		if (!empty($controller->request) &&
				! $controller->request->is('get') &&
				$controller->viewClass !== 'Json' &&
				$controller->response->statusCode() != 302) {
			$this->__setCurrentPageContainer();
		}
	}

/**
 * カレントデータの初期化
 *
 * @return array|null Current data.
 */
	public static function clear() {
		self::$current = [];
		$instance = self::getInstance();
		$instance->NcPermission->clear();
		$instance->CurrentLibLanguage->clear();
		$instance->CurrentLibPlugin->clear();
		$instance->CurrentLibPermission->clear();
	}

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
		if (! $roomId) {
			$roomId = self::read('Room.id');
		}
		return $instance->NcPermission->read($roomId, $key);
	}

/**
 * パーミッション関連のデータをCurrentにセットする
 *
 * 注意）一時的に権限を書き換えるときは、戻す処理を必ず入れること
 *
 * @param string|int|null $roomId ルームID。nullの場合、roomに紐づかない。
 * @param array $permissions パーミッションデータ
 * @return void
 */
	public static function writeCurrentPermissions($roomId, $permissions) {
		$instance = self::getInstance();
		foreach ($permissions as $key => $permission) {
			if (isset(self::$current['Permission'][$key])) {
				self::$current['Permission'][$key] =
							array_merge(self::$current['Permission'][$key], $permission);
			} else {
				self::$current['Permission'][$key] = $permission;
			}
			if ($roomId) {
				$instance->NcPermission->write($roomId, $key, $permission['value']);
			} else {
				$instance->NcPermission->write('0', $key, $permission['value']);
			}
		}
	}

/**
 * パーミッション関連のデータをCurrentにセットする
 *
 * 注意）一時的に権限を書き換えるときは、戻す処理を必ず入れること
 *
 * @return void
 */
	public static function clearCurrentPermissions() {
		$instance = self::getInstance();
		self::$current['Permission'] = [];
		$instance->NcPermission->clear();
	}

/**
 * 取得した結果を$currentにセットする
 *
 * これは、旧Currentで使用していたメソッドであり、基本これは使用しない。
 * ※Wysiwigで使用しているため残す。
 *
 * @param array $results 取得結果
 * @return void
 * @see https://github.com/NetCommons3/Wysiwyg/blob/3.2.2/Controller/WysiwygImageDownloadController.php#L120
 */
	public static function setCurrent($results) {
		if (! $results) {
			return;
		}
		$models = array_keys($results);

		foreach ($models as $model) {
			if (array_key_exists('id', $results[$model]) && ! $results[$model]['id']) {
				continue;
			}
			if (! isset(Current::$current[$model])) {
				self::$current[$model] = $results[$model];
			}
		}
	}

/**
 * 指定された$keyの値をセットします
 *
 * Wysiwigで使用しているsetCurrent()メソッド用に必要
 *
 * @param int|null $roomId ルームID
 * @param string $key パーミッションキー
 * @param bool $value パーミッション値
 * @return void
 */
	public static function writePermission($roomId, $key, $value) {
		self::$permission[$roomId]['Permission'][$key]['value'] = $value;
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
		return $instance->CurrentLibUser->isLogined();
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
