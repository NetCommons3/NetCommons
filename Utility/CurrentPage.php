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

App::uses('CurrentFrame', 'NetCommons.Utility');
App::uses('Space', 'Rooms.Space');

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
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		if (Current::$request->params['plugin'] === Current::PLUGIN_WYSIWYG) {
			if (Hash::get(Current::$request->data, 'Room.id')) {
				$roomId = Hash::get(Current::$request->data, 'Room.id');
			} else {
				$roomId = Hash::get(Current::$request->params, 'pass.0', '');
			}
			$this->setRoom($roomId);
		}

		$this->setPage();
		$this->setTopPage();
		$this->setPageByRoomPageTopId();
		$this->setRolesRoomsUser();
		$this->setDefaultRolePermissions();
		$this->setRoomRolePermissions();
		$this->setPluginsRoom();
		//$this->setSpace();
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
				unset($result[0]['Room']);
				Current::setCurrent($result[0], true);
			}
		}
	}

/**
 * Set BlockRolePermissions
 *
 * @param string $roleKey ロールキー
 * @param bool $isMerge マージするかどうか
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function setDefaultRolePermissions($roleKey = null, $isMerge = false) {
		$this->DefaultRolePermission = ClassRegistry::init('Roles.DefaultRolePermission');

		if (! isset(Current::$current['DefaultRolePermission'])) {
			Current::$current['DefaultRolePermission'] = array();
		}

		if (! $roleKey && Current::$current['DefaultRolePermission']) {
			return;
		}

		if ($roleKey) {
			$roomRoleKey = $roleKey;
		} elseif (isset(Current::$current['RolesRoom'])) {
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
			$result = Hash::combine(
				$result, '{n}.DefaultRolePermission.permission', '{n}.DefaultRolePermission'
			);
			Current::$current['DefaultRolePermission'] = Hash::merge(
				Current::$current['DefaultRolePermission'], $result
			);

			if ($isMerge) {
				if (! isset(Current::$current['Permission'])) {
					Current::$current['Permission'] = array();
				}
				Current::$current['Permission'] = Hash::merge(Current::$current['Permission'], $result);
			}
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
			Current::$current['RoomRolePermission'] = Hash::combine(
				$result, '{n}.RoomRolePermission.permission', '{n}.RoomRolePermission'
			);
		}
	}

/**
 * ページ取得の条件取得
 *
 * @return array 条件配列
 */
	private function __getPageConditions() {
		if (Hash::get(Current::$request->data, 'Page.id')) {
			$pageId = Current::$request->data['Page']['id'];
			$conditions = array('Page.id' => $pageId);

		} elseif (Current::$request->params['plugin'] === Current::PLUGIN_PAGES) {
			if (Current::$request->params['controller'] === 'pages') {
				$value = implode('/', Current::$request->params['pass']);
				if ($value === '') {
					$value = Page::PUBLIC_ROOT_PAGE_ID;
					$conditions = array('Page.root_id' => $value);
				} else {
					$conditions = array(
						'Page.permalink' => $value,
						'Room.space_id' => Hash::get(
							Current::$request->params, 'spaceId', Space::PUBLIC_SPACE_ID
						),
					);
				}
			} else {
				$value = Hash::get(Current::$request->params, 'pass.1', '');
				if (! $value) {
					$this->setRoom(Hash::get(Current::$request->params, 'pass.0', ''));
					$value = Hash::get(Current::$current, 'Room.page_id_top', '');
				}
				$conditions = array('Page.id' => $value);
			}

		} elseif (Hash::get(Current::$request->query, 'page_id')) {
			$pageId = Hash::get(Current::$request->query, 'page_id');
			$conditions = array('Page.id' => $pageId);

		} elseif (in_array(Current::$request->params['plugin'],
								[Current::PLUGIN_USERS, Current::PLUGIN_GROUPS], true) &&
					! Current::$request->is('ajax')) {
			$this->Room = ClassRegistry::init('Rooms.Room');
			$result = $this->Room->getPrivateRoomByUserId(Current::read('User.id'));
			Current::setCurrent($result);

			$conditions = array(
				'Page.id' => Hash::get($result, 'Room.page_id_top', Page::PUBLIC_ROOT_PAGE_ID)
			);
		} else {
			$conditions = null;
		}

		return $conditions;
	}

/**
 * Set TopPage
 *
 * @return bool
 */
	public function setTopPage() {
		$this->Page = ClassRegistry::init('Pages.Page');
		if (isset(Current::$current['TopPage'])) {
			return;
		}

		$result = $this->__getPage(array(
			'recursive' => -1,
			'conditions' => array(
				'Page.room_id' => Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID),
				'Page.parent_id NOT' => null,
			),
			'order' => array('Page.lft' => 'asc')
		));
		Current::$current['TopPage'] = Hash::get($result, 'Page');
	}

/**
 * ページ取得
 *
 * @param array $query クエリ
 * @return array 条件配列
 */
	private function __getPage($query) {
		$this->Page = ClassRegistry::init('Pages.Page');

		if (! empty(Current::$request->params['requested'])) {
			$this->Page->unbindModel(array(
				'belongsTo' => array('Room'),
			), true);
			$this->Page->unbindModel(array(
				'belongsTo' => array('Space'),
			), true);
		}

		$result = $this->Page->find('first', $query);
		return $result;
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

		$conditions = $this->__getPageConditions();
		if ($conditions) {
			$result = $this->__getPage(array(
				'recursive' => 0,
				'conditions' => $conditions,
				'order' => array('Page.lft' => 'asc')
			));

			Current::setCurrent($result);
			if (isset(Current::$current['Page'])) {
				return;
			}
		}

		if (isset(Current::$current['Room'])) {
			$pageId = Hash::get(Current::$current, 'Room.page_id_top');
		} elseif (! $conditions && Current::$request->params['plugin']) {
			$pageId = $this->Page->getTopPageId();
		} else {
			$pageId = null;
		}
		if ($pageId) {
			$result = $this->__getPage(array(
				'recursive' => 0,
				'conditions' => array('Page.id' => $pageId),
			));
			Current::setCurrent($result);
		}

		(new CurrentFrame())->setBoxPageContainer();
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
			'Page.id' => Hash::get(Current::$current, 'Room.page_id_top')
		);
		$result = $this->Page->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		Current::setCurrent($result);
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

		$result = $this->PluginsRoom->getPlugins(Current::read('Room.id'));
		Current::$current['PluginsRoom'] = $result;
	}

/**
 * Set Room
 *
 * @param int $roomId Rooms.id
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
		Current::setCurrent($result);
	}

/**
 * set Space
 *
 * @return void
 */
	//public function setSpace() {
	//	if (! isset(Current::$current['Room'])) {
	//		return;
	//	}
	//
	//	$this->Space = ClassRegistry::init('Rooms.Space');
	//	$conditions = array(
	//		'Space.id' => Hash::get(Current::$current, 'Room.space_id')
	//	);
	//	$result = $this->Space->find('first', array(
	//		'recursive' => 0,
	//		'conditions' => $conditions,
	//	));
	//	Current::setCurrent($result, true);
	//}

}
