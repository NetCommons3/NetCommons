<?php
/**
 * CurrentPage Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CurrentPage Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentPage {

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * Pagesプラグイン名の定数
 */
	const PLUGIN_PAGES = 'pages';

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
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new CurrentPage();
		}

		self::$__request = $request;

		self::$__instance->setPage();

		self::$__instance->setPageByRoomPageTopId();

		self::$__instance->setRolesRoomsUser();

		self::$__instance->setDefaultRolePermissions();

		self::$__instance->setRoomRolePermissions();

		self::$__instance->setPluginsRoom();
	}

/**
 * Set RolesRoomsUser
 *
 * @return void
 */
	public function setRolesRoomsUser() {
		self::$__instance->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');

		if (isset(Current::$current['User']['id']) &&
				isset(Current::$current['Room']['id']) && ! isset(Current::$current['RolesRoomsUser'])) {
			$result = self::$__instance->RolesRoomsUser->getRolesRoomsUsers(array(
				'RolesRoomsUser.user_id' => Current::$current['User']['id'],
				'Room.id' => Current::$current['Room']['id']
			));
			if ($result) {
				Current::$current = Hash::merge(Current::$current, $result[0]);
			}
		}
	}

/**
 * Set BlockRolePermissions
 *
 * @return void
 */
	public function setDefaultRolePermissions() {
		self::$__instance->DefaultRolePermission = ClassRegistry::init('Roles.DefaultRolePermission');

		if (isset(Current::$current['DefaultRolePermission'])) {
			return;
		}
		if (isset(Current::$current['RolesRoom'])) {
			$roomRoleKey = Current::$current['RolesRoom']['role_key'];
		} else {
			$roomRoleKey = self::DEFAULT_ROOM_ROLE_KEY;
		}
		$result = self::$__instance->DefaultRolePermission->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'role_key' => $roomRoleKey,
			)
		));
		if ($result) {
			Current::$current['DefaultRolePermission'] = Hash::combine($result, '{n}.DefaultRolePermission.permission', '{n}.DefaultRolePermission');
		}
	}

/**
 * Set RoomRolePermissions
 *
 * @return void
 */
	public function setRoomRolePermissions() {
		self::$__instance->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');

		if (isset(Current::$current['RoomRolePermission']) || ! isset(Current::$current['RolesRoom'])) {
			return;
		}
		$result = self::$__instance->RoomRolePermission->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'roles_room_id' => Current::$current['RolesRoom']['id'],
			)
		));
		if ($result) {
			Current::$current['RoomRolePermission'] = Hash::combine($result, '{n}.RoomRolePermission.permission', '{n}.RoomRolePermission');
		}
	}

/**
 * Set Page
 *
 * @return bool
 */
	public function setPage() {
		self::$__instance->Page = ClassRegistry::init('Pages.Page');

		if (isset(Current::$current['Page'])) {
			return;
		}

		if (Hash::get(self::$__request->data, 'Page.id')) {
			$pageId = self::$__request->data['Page']['id'];
			$conditions = array('Page.id' => $pageId);

		} elseif (self::$__request->params['plugin'] === self::PLUGIN_PAGES) {
			if (self::$__request->params['action'] === 'index') {
				$field = 'Page.permalink';
			} else {
				$field = 'Page.id';
			}
			$value = Hash::get(self::$__request->params, 'pass.0', '');
			$conditions = array($field => $value);

		} elseif (self::$__request->params['plugin'] === Current::PLUGIN_USERS && ! self::$__request->is('ajax')) {
			self::$__instance->Room = ClassRegistry::init('Rooms.Room');
			$result = self::$__instance->Room->getPrivateRoomByUserId(Current::read('User.id'));
			Current::$current = Hash::merge(Current::$current, $result);
			$conditions = array(
				'Page.id' => $result['Room']['page_id_top']
			);
		} else {
			return;
		}

		$result = self::$__instance->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		Current::$current = Hash::merge(Current::$current, $result);
		if (isset(Current::$current['Page'])) {
			return;
		}

		if (isset(Current::$current['Room'])) {
			$conditions = array(
				'Page.id' => Current::$current['Room']['page_id_top']
			);
			$result = self::$__instance->Page->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			));
			Current::$current = Hash::merge(Current::$current, $result);
		}
	}

/**
 * Set Page
 *
 * @return bool
 */
	public function setPageByRoomPageTopId() {
		if (isset(Current::$current['Page']) || ! isset(Current::$current['Room'])) {
			return;
		}

		$conditions = array(
			'Page.id' => Current::$current['Room']['page_id_top']
		);
		$result = self::$__instance->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		Current::$current = Hash::merge(Current::$current, $result);
	}

/**
 * Set PluginsRoom
 *
 * @return bool
 */
	public function setPluginsRoom() {
		if (isset(Current::$current['PluginsRoom']) || ! isset(Current::$current['Room'])) {
			return;
		}
		self::$__instance->PluginsRoom = ClassRegistry::init('PluginManager.PluginsRoom');

		$result = self::$__instance->PluginsRoom->getPlugins(Current::read('Room.id'), Current::read('Language.id'));
		Current::$current['PluginsRoom'] = $result;
	}

}
