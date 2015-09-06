<?php
/**
 * CurrentFrame Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CurrentFrame Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentFrame {

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * Constant Plugin value
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
 * Current data
 *
 * @var array
 */
	private static $__current = array();

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request, $current) {
		if (! self::$__instance) {
			self::$__instance = new CurrentFrame();
		}

		self::$__request = $request;

		self::$__current = $current;

		if (isset(self::$__current['Frame'])) {
			unset(self::$__current['Frame']);
		}
		if (isset(self::$__current['Block'])) {
			unset(self::$__current['Block']);
		}
		if (isset(self::$__current['BlockRolePermission'])) {
			unset(self::$__current['BlockRolePermission']);
		}
		if (self::$__request->params['plugin'] !== self::PLUGIN_PAGES) {
			self::$__instance->setFrame();
			self::$__instance->setBlock();
		}

		self::$__instance->setPage();

		self::$__instance->setPageByRoomPageTopId();

		self::$__instance->setRolesRoomsUser();

		self::$__instance->setDefaultRolePermissions();

		self::$__instance->setRoomRolePermissions();

		self::$__instance->setBlockRolePermissions();

		return self::$__current;
	}

/**
 * Set Frame
 *
 * @return void
 */
	public function setFrame() {
		if (isset(self::$__request->data['Frame']) && isset(self::$__request->data['Frame']['id'])) {
			$frameId = self::$__request->data['Frame']['id'];
		} elseif (isset(self::$__request->params['pass'][0])) {
			$frameId = self::$__request->params['pass'][0];
		}

		self::$__instance->Frame = ClassRegistry::init('Frames.Frame');
		self::$__instance->Box = ClassRegistry::init('Boxes.Box');

		if (isset($frameId)) {
			$result = self::$__instance->Frame->findById($frameId);
			if (! $result) {
				return;
			}
			self::$__current = Hash::merge(self::$__current, $result);
			if (isset(self::$__current['Page'])) {
				return;
			}
		}

		if (isset(self::$__current['Box']['id'])) {
			$boxId = self::$__current['Box']['id'];
		} elseif (isset(self::$__request->data['Frame']) && isset(self::$__request->data['Frame']['box_id'])) {
			$boxId = self::$__request->data['Frame']['box_id'];
		} elseif (isset(self::$__request->data['Box']) && isset(self::$__request->data['Box']['id'])) {
			$boxId = self::$__request->data['Box']['id'];
		} else {
			return;
		}

		$result = self::$__instance->Box->find('first', array(
			'conditions' => array(
				'Box.id' => $boxId,
			),
		));
		if (! $result) {
			return;
		}
		self::$__current['Page'] = $result['Page'][0];

		if (! isset(self::$__current['Room'])) {
			self::$__current['Room'] = $result['Room'];
		}
	}

/**
 * Set Block
 *
 * @return void
 */
	public function setBlock() {
		if (isset(self::$__request->data['Block']) && self::$__request->data['Block']['id']) {
			$blockId = self::$__request->data['Block']['id'];
		} elseif (isset(self::$__request->params['pass'][1])) {
			$blockId = self::$__request->params['pass'][1];
		} elseif (isset(self::$__current['Frame'])) {
			$blockId = self::$__current['Frame']['block_id'];
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
		self::$__current = Hash::merge(self::$__current, $result);
	}

/**
 * Set RolesRoomsUser
 *
 * @return void
 */
	public function setRolesRoomsUser() {
		self::$__instance->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');

		if (isset(self::$__current['User']['id']) && isset(self::$__current['Room']['id']) && ! isset(self::$__current['RolesRoomsUser'])) {
			$result = self::$__instance->RolesRoomsUser->getRolesRoomsUsers(array(
				'RolesRoomsUser.user_id' => self::$__current['User']['id'],
				'Room.id' => self::$__current['Room']['id']
			));
			if ($result) {
				self::$__current = Hash::merge(self::$__current, $result[0]);
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

		if (isset(self::$__current['DefaultRolePermission'])) {
			return;
		}
		if (isset(self::$__current['RolesRoom'])) {
			$roomRoleKey = self::$__current['RolesRoom']['role_key'];
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
			self::$__current['DefaultRolePermission'] = Hash::combine($result, '{n}.DefaultRolePermission.permission', '{n}.DefaultRolePermission');
		}
	}

/**
 * Set RoomRolePermissions
 *
 * @return void
 */
	public function setRoomRolePermissions() {
		self::$__instance->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');

		if (isset(self::$__current['RoomRolePermission']) || ! isset(self::$__current['RolesRoom'])) {
			return;
		}
		$result = self::$__instance->RoomRolePermission->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'roles_room_id' => self::$__current['RolesRoom']['id'],
			)
		));
		if ($result) {
			self::$__current['RoomRolePermission'] = Hash::combine($result, '{n}.RoomRolePermission.permission', '{n}.RoomRolePermission');
		}
	}

/**
 * Set BlockRolePermissions
 *
 * @return void
 */
	public function setBlockRolePermissions() {
		self::$__instance->BlockRolePermission = ClassRegistry::init('Blocks.BlockRolePermission');

		if (isset(self::$__current['BlockRolePermission'])) {
			return;
		}

		if (isset(self::$__current['RolesRoom']) && isset(self::$__current['Block']['key'])) {
			$result = self::$__instance->BlockRolePermission->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'roles_room_id' => self::$__current['RolesRoom']['id'],
					'block_key' => self::$__current['Block']['key'],
				)
			));
			if ($result) {
				self::$__current['BlockRolePermission'] = Hash::combine($result, '{n}.BlockRolePermission.permission', '{n}.BlockRolePermission');
			}
		}

		$permission = array();
		if (isset(self::$__current['DefaultRolePermission'])) {
			$permission = Hash::merge($permission, self::$__current['DefaultRolePermission']);
		}
		if (isset(self::$__current['RoomRolePermission'])) {
			$permission = Hash::merge($permission, self::$__current['RoomRolePermission']);
		}
		if (isset(self::$__current['BlockRolePermission'])) {
			$permission = Hash::merge($permission, self::$__current['BlockRolePermission']);
		}

		self::$__current['Permission'] = $permission;

	}

/**
 * Set Page
 *
 * @return bool
 */
	public function setPage() {
		if (isset(self::$__current['Page'])) {
			return;
		}

		if (isset(self::$__request->data['Page']) && self::$__request->data['Page']['id']) {
			$pageId = self::$__request->data['Page']['id'];
			$conditions = array(
				'Page.id' => $pageId
			);

		} elseif (self::$__request->params['plugin'] === self::PLUGIN_PAGES) {
			if (self::$__request->params['action'] === 'index') {
				if (isset(self::$__request->params['pass'][0])) {
					$permalink = self::$__request->params['pass'][0];
				} else {
					$permalink = '';
				}
				$conditions = array(
					'Page.permalink' => $permalink
				);
			} else {
				if (isset(self::$__request->params['pass'][0])) {
					$pageId = self::$__request->params['pass'][0];
				} else {
					$pageId = 0;
				}
				$conditions = array(
					'Page.id' => $pageId
				);
			}

		} else {
			return;
		}

		self::$__instance->Page = ClassRegistry::init('Pages.Page');
		$result = self::$__instance->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		if ($result) {
			self::$__current = Hash::merge(self::$__current, $result);
		}
		if (isset(self::$__current['Page'])) {
			return;
		}

		if (isset(self::$__current['Room'])) {
			$conditions = array(
				'Page.id' => self::$__current['Room']['page_id_top']
			);
			$result = self::$__instance->Page->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			));
		}
		if ($result) {
			self::$__current = Hash::merge(self::$__current, $result);
		}
	}

/**
 * Set Page
 *
 * @return bool
 */
	public function setPageByRoomPageTopId() {
		if (isset(self::$__current['Page']) || ! isset(self::$__current['Room'])) {
			return;
		}

		$conditions = array(
			'Page.id' => self::$__current['Room']['page_id_top']
		);
		$result = self::$__instance->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));
		if ($result) {
			self::$__current = Hash::merge(self::$__current, $result);
		}
	}

}
