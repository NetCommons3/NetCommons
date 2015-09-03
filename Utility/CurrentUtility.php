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

/**
 * Current Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentUtility {

/**
 * Constant setting mode value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * Constant Plugin value
 */
	const PLUGIN_PAGES = 'pages',
			PLUGIN_CONTROL_PANEL = 'control_panel';

/**
 * is setting mode true
 *
 * @var bool
 */
	private static $__isSettingMode = null;

/**
 * Request object
 *
 * @var mixed
 */
	private static $__request;

/**
 * Instance object
 *
 * @var mixed
 */
	private static $__instance;

/**
 * Current data
 *
 * @var array
 */
	public static $current = array();


/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
CakeLog::debug('CurrentUtility::initialize()');

		if (! self::$__instance) {
			self::$__instance = new CurrentUtility();
		}

		self::$__request = $request;

		self::$current['User'] = AuthComponent::user();

		self::$__instance->__setLanguage();
		self::$__instance->__setPlugin();

		if (self::isControlPanel()) {
			$roleKey = AuthComponent::user('User.role_key');
			self::$__instance->__setPluginRole($roleKey);
		} else {
			self::$__instance->__setFrame();

			self::$__instance->__setBlock();

			self::$__instance->__setPage();

			self::$__instance->__setBlockRolePermissions();

//			$frameId = self::$__request->params['pass'][0];
//
//			list($frameId, $blockId) = self::$__request->params['pass'];
		}

//CakeLog::debug('CurrentUtility::initialize() self::$__request ' . print_r(self::$__request, true));
CakeLog::debug('CurrentUtility::initialize() self::$current ' . print_r(self::$current, true));

	}

/**
 * Check setting mode
 *
 * @return bool
 */
	public static function isSettingMode() {
		if (isset(self::$__isSettingMode)) {
			return self::$__isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			self::$__isSettingMode = true;
		} else {
			self::$__isSettingMode = false;
		}

		return self::$__isSettingMode;
	}

/**
 * Check Control panel
 *
 * @return bool
 */
	public static function isControlPanel() {
		if (self::$__request->params['plugin'] === self::PLUGIN_CONTROL_PANEL) {
			return true;
		}

		if (! isset(self::$current['Plugin'])) {
			return false;
		}

		if (self::$current['Plugin']['type'] === Plugin::PLUGIN_TYPE_FOR_CONTROL_PANEL) {
			return true;
		}

		return false;
	}

/**
 * Set Language
 *
 * @return void
 */
	private function __setLanguage() {
		if (isset(self::$current['Language'])) {
			return;
		}

		self::$__instance->Language = ClassRegistry::init('M17n.Language');
		$result = self::$__instance->Language->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'code' => Configure::read('Config.language')
			),
		));
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

/**
 * Set Plugin
 *
 * @return void
 */
	private function __setPlugin() {
		if (isset(self::$current['Plugin'])) {
			unset(self::$current['Plugin']);
		}

		if (self::$__request->params['plugin'] === self::PLUGIN_PAGES ||
				self::$__request->params['plugin'] === self::PLUGIN_CONTROL_PANEL) {
			return;
		}

		//Pluginデータ取得
		self::$__instance->Plugin = ClassRegistry::init('PluginManager.Plugin');
		$result = self::$__instance->Plugin->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'key' => self::$__request->params['plugin'],
				'language_id' => self::$current['Language']['id']
			),
		));
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

/**
 * Set PluginRole
 *
 * @return void
 */
	private function __setPluginRole($roleKey) {
		if (isset(self::$current['PluginsRole'])) {
			unset(self::$current['PluginsRole']);
		}

		if (self::$__request->params['plugin'] === self::PLUGIN_PAGES ||
				self::$__request->params['plugin'] === self::PLUGIN_CONTROL_PANEL) {
			return;
		}
		if (! isset(self::$current['Plugin'])) {
			return;
		}

		//PluginsRoleデータ取得
		self::$__instance->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
		$result = self::$__instance->Plugin->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'role_key' => $roleKey,
				'plugin_key' => self::$current['Plugin']['key']
			),
		));
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

/**
 * Set Frame
 *
 * @return void
 */
	private function __setFrame() {
		if (isset(self::$current['Frame'])) {
			unset(self::$current['Frame']);
		}
		if (self::$__request->params['plugin'] === self::PLUGIN_PAGES) {
			return;
		}

		if (isset(self::$__request->data['Frame']) && self::$__request->data['Frame']['id']) {
			$frameId = self::$__request->data['Frame']['id'];
		} elseif (isset(self::$__request->params['pass'][0])) {
			$frameId = self::$__request->params['pass'][0];
		} else {
			return;
		}

		self::$__instance->Frame = ClassRegistry::init('Frames.Frame');
		self::$__instance->Box = ClassRegistry::init('Boxes.Box');

		$result = self::$__instance->Frame->findById($frameId);
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);

		if (! isset(self::$current['Page'])) {
			$result = self::$__instance->Box->find('first', array(
				'conditions' => array(
					'Box.id' => self::$current['Box']['id'],
				),
			));
			if (! $result) {
				return;
			}
			self::$current['Page'] = $result['Page'][0];
		}
	}

/**
 * Set Block
 *
 * @return void
 */
	private function __setBlock() {
		if (isset(self::$current['Block'])) {
			unset(self::$current['Block']);
		}
		if (self::$__request->params['plugin'] === self::PLUGIN_PAGES) {
			return;
		}

		if (isset(self::$__request->data['Block']) && self::$__request->data['Block']['id']) {
			$blockId = self::$__request->data['Block']['id'];
		} elseif (isset(self::$__request->params['pass'][1])) {
			$blockId = self::$__request->params['pass'][1];
		} elseif (isset(self::$current['Frame'])) {
			$blockId = self::$current['Frame']['block_id'];
		} else {
			return;
		}

		self::$__instance->Block = ClassRegistry::init('Blocks.Block');
		$result = self::$__instance->Block->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'Block.id' => $blockId,
			),
		));
		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

/**
 * Set BlockRolePermissions
 *
 * @return void
 */
	private function __setBlockRolePermissions() {
		$models = array(
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'BlockRolePermission' => 'Blocks.BlockRolePermission'
		);
		foreach ($models as $model => $class) {
			self::$__instance->$model = ClassRegistry::init($class);
		}

		if (self::$current['User']['id'] && ! isset(self::$current['RolesRoomsUser'])) {
			$result = self::$__instance->RolesRoomsUser->getRolesRoomsUsers(array(
				'RolesRoomsUser.user_id' => self::$current['User']['id'],
				'Room.id' => self::$current['Room']['id']
			));
			if ($result) {
				self::$current = Hash::merge(self::$current, $result[0]);
			}
		}

		if (isset(self::$current['RolesRoom'])) {
			$roomRoleKey = self::$current['RolesRoom']['role_key'];
			$rolesRoomid = self::$current['RolesRoom']['id'];
		} else {
			$roomRoleKey = self::DEFAULT_ROOM_ROLE_KEY;
			$rolesRoomid = 0;
		}

		if (! isset(self::$current['DefaultRolePermission'])) {
			$result = self::$__instance->DefaultRolePermission->findAllByRoleKey($roomRoleKey);
			if ($result) {
				self::$current['DefaultRolePermission'] = Hash::combine($result, '{n}.DefaultRolePermission.permission', '{n}.DefaultRolePermission');
			}
		}

		if (self::$current['User']['id'] && ! isset(self::$current['RoomRolePermission'])) {
			$result = self::$__instance->RoomRolePermission->findAllByRolesRoomId($rolesRoomid);
			if ($result) {

			}
		}
	}

/**
 * Set Page
 *
 * @return bool
 */
	private function __setPage() {
		if (isset(self::$current['Page'])) {
			return;
		}

		if (isset(self::$__request->data['Page']) && self::$__request->data['Page']['id']) {
			$pageId = self::$__request->data['Page']['id'];
			$conditions = array(
				'Page.id' => $pageId
			);

		} elseif (self::$__request->params['plugin'] === self::PLUGIN_PAGES) {
			if (isset(self::$__request->params['pass'][0])) {
				$permalink = self::$__request->params['pass'][0];
			} else {
				$permalink = '';
			}
			$conditions = array(
				'Page.permalink' => $permalink
			);

		} else {
			return;
		}

		self::$__instance->Page = ClassRegistry::init('Pages.Page');
		$result = self::$__instance->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		if (! $result) {
			return;
		}
		self::$current = Hash::merge(self::$current, $result);
	}

}
