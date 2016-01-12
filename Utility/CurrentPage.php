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
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		$this->setPage();
		$this->setPageByRoomPageTopId();
		$this->setRolesRoomsUser();
		$this->setDefaultRolePermissions();
		$this->setRoomRolePermissions();
		$this->setPluginsRoom();
	}

/**
 * Set RolesRoomsUser
 *
 * @return void
 */
	public function setRolesRoomsUser() {
		$this->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');

		if (isset(Current::$current['User']['id']) &&
				isset(Current::$current['Room']['id']) && ! isset(Current::$current['RolesRoomsUser'])) {
			$result = $this->RolesRoomsUser->getRolesRoomsUsers(array(
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
		$this->DefaultRolePermission = ClassRegistry::init('Roles.DefaultRolePermission');

		if (isset(Current::$current['DefaultRolePermission'])) {
			return;
		}
		if (isset(Current::$current['RolesRoom'])) {
			$roomRoleKey = Current::$current['RolesRoom']['role_key'];
		} else {
			$roomRoleKey = self::DEFAULT_ROOM_ROLE_KEY;
		}
		$result = $this->DefaultRolePermission->find('all', array(
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
		$this->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');

		if (isset(Current::$current['RoomRolePermission']) || ! isset(Current::$current['RolesRoom'])) {
			return;
		}
		$result = $this->RoomRolePermission->find('all', array(
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
		$this->Page = ClassRegistry::init('Pages.Page');

		if (isset(Current::$current['Page'])) {
			return;
		}

		if (Hash::get(Current::$request->data, 'Page.id')) {
			$pageId = Current::$request->data['Page']['id'];
			$conditions = array('Page.id' => $pageId);

		} elseif (Current::$request->params['plugin'] === self::PLUGIN_PAGES) {
			if (Current::$request->params['controller'] === 'pages' &&
					Current::$request->params['action'] === 'index') {
				$field = 'Page.permalink';
				$value = Hash::get(Current::$request->params, 'pass.0', '');
			} else {
				$field = 'Page.id';
				$value = Hash::get(Current::$request->params, 'pass.1', '');
				if (! $value) {
					$this->setRoom(Hash::get(Current::$request->params, 'pass.0', ''));
					$field = 'Page.id';
					$value = Hash::get(Current::$current, 'Room.page_id_top', '');
				}
			}
			$conditions = array($field => $value);

		} elseif (Current::$request->params['plugin'] === Current::PLUGIN_USERS && ! Current::$request->is('ajax')) {
			$this->Room = ClassRegistry::init('Rooms.Room');
			$result = $this->Room->getPrivateRoomByUserId(Current::read('User.id'));
			Current::$current = Hash::merge(Current::$current, $result);
			$conditions = array(
				'Page.id' => $result['Room']['page_id_top']
			);
		} else {
			return;
		}

		$result = $this->Page->find('first', array(
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
			$result = $this->Page->find('first', array(
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
		$result = $this->Page->find('first', array(
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
		$this->PluginsRoom = ClassRegistry::init('PluginManager.PluginsRoom');

		$result = $this->PluginsRoom->getPlugins(Current::read('Room.id'), Current::read('Language.id'));
		Current::$current['PluginsRoom'] = $result;
	}

/**
 * Set Room
 *
 * @return bool
 */
	public function setRoom($roomId) {
		$this->Room = ClassRegistry::init('Rooms.Room');
		$conditions = array(
			'Room.id' => $roomId
		);
		$result = $this->Room->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));
		Current::$current = Hash::merge(Current::$current, $result);
	}

}
