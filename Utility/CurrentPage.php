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
App::uses('Space', 'Rooms.Model');

/**
 * CurrentPage Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class CurrentPage {

/**
 * Constant default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * CurrentFrame Instance object
 *
 * @var mixed
 */
	protected static $_instanceFrame;

/**
 * 同じデータを取得しないようにキャッシュする
 *
 * @var array
 */
	private static $__memoryCache = [];

/**
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		if (Current::$request->params['plugin'] === Current::PLUGIN_WYSIWYG) {
			$roomId = Hash::get(Current::$request->data, 'Room.id');
			if (! $roomId) {
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
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
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

		// デフォルトロールパーミッション取得
		$results = $this->__getDefaultRolePermissions($roomRoleKey);

		if ($results) {
			$result = [];
			foreach ($results as $rolePermission) {
				$permission = $rolePermission['DefaultRolePermission']['permission'];
				$result[$permission] = $rolePermission['DefaultRolePermission'];
				Current::$current['DefaultRolePermission'][$permission] = $result[$permission];
			}
			if ($isMerge) {
				if (! isset(Current::$current['Permission'])) {
					Current::$current['Permission'] = array();
				}
				Current::$current['Permission'] = Hash::merge(Current::$current['Permission'], $result);
			}
		}
	}

/**
 * Get DefaultRolePermissions
 *
 * @param string $roleKey ロールキー
 * @return array
 */
	private function __getDefaultRolePermissions($roleKey) {
		// RoomRoleKey毎にキャッシュする
		if (!isset(self::$__memoryCache['DefaultRolePermissions'][$roleKey])) {
			self::$__memoryCache['DefaultRolePermissions'][$roleKey]
				= $this->DefaultRolePermission->find('all', array(
					'recursive' => -1,
					'conditions' => array(
						'role_key' => $roleKey,
					)
				));
		}

		return self::$__memoryCache['DefaultRolePermissions'][$roleKey];
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

		// ルームロールパーミッション取得
		$results = $this->__getRoomRolePermissions(Current::$current['RolesRoom']['id']);

		if ($results) {
			foreach ($results as $rolePermission) {
				$permission = $rolePermission['RoomRolePermission']['permission'];
				Current::$current['RoomRolePermission'][$permission] = $rolePermission['RoomRolePermission'];
			}
		}
	}

/**
 * Get DefaultRolePermissions
 *
 * @param string $rolesRoomId ロールルームID
 * @return array
 */
	private function __getRoomRolePermissions($rolesRoomId) {
		// RoomRoleID毎にキャッシュする
		if (!isset(self::$__memoryCache['RoomRolePermissions'][$rolesRoomId])) {
			// ルーム毎にキャッシュする
			self::$__memoryCache['RoomRolePermissions'][$rolesRoomId]
				= $this->RoomRolePermission->find('all', array(
					'recursive' => -1,
					'conditions' => array(
						'roles_room_id' => $rolesRoomId,
					)
				));
		}

		return self::$__memoryCache['RoomRolePermissions'][$rolesRoomId];
	}

/**
 * ページ取得の条件取得
 *
 * @return array 条件配列
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	private function __getPageConditions() {
		if ($pageId = Hash::get(Current::$request->data, 'Page.id')) {
			$conditions = array('Page.id' => $pageId);

		} elseif (!empty(Current::$request->params['pageView'])) {
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

		} elseif (!empty(Current::$request->params['pageEdit'])) {
			$value = Hash::get(Current::$request->params, 'pass.1', '');
			if (! $value) {
				$this->setRoom(Hash::get(Current::$request->params, 'pass.0', ''));
				$value = Hash::get(Current::$current, 'Room.page_id_top', '');
			}
			$conditions = array('Page.id' => $value);

		} elseif ($pageId = Hash::get(Current::$request->query, 'page_id')) {
			$conditions = array('Page.id' => $pageId);

		} elseif ($pageId = Hash::get(Current::$request->params, 'page_id')) {
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
				'Page.root_id' => Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID),
				'Page.parent_id NOT' => null,
			),
			'order' => array('Page.sort_key' => 'asc')
		));
		if (isset($result['Page'])) {
			Current::$current['TopPage'] = $result['Page'];
		} else {
			Current::$current['TopPage'] = null;
		}
	}

/**
 * ページ取得
 *
 * @param array $query クエリ
 * @return array 条件配列
 */
	private function __getPage($query) {
		$this->Page = ClassRegistry::init('Pages.Page');
		$this->Space = ClassRegistry::init('Rooms.Space');

		$cacheId = json_encode($query);
		if (isset(self::$__memoryCache['Page'][$cacheId])) {
			$result = self::$__memoryCache['Page'][$cacheId];
		} else {
			$query['fields'] = [
				$this->Page->alias . '.id',
				$this->Page->alias . '.room_id',
				$this->Page->alias . '.root_id',
				$this->Page->alias . '.parent_id',
				//$this->Page->alias . '.lft', //後で、Page.lft消す
				//$this->Page->alias . '.rght', //後で、Page.rght消す
				$this->Page->alias . '.weight',
				$this->Page->alias . '.sort_key',
				$this->Page->alias . '.child_count',
				$this->Page->alias . '.permalink',
				$this->Page->alias . '.slug',
				$this->Page->alias . '.is_container_fluid',
				$this->Page->alias . '.theme',
			];

			if (! empty(Current::$request->params['requested'])) {
				$this->Page->unbindModel(array(
					'belongsTo' => array('Room'),
				), true);
				$this->Page->unbindModel(array(
					'belongsTo' => array('Space'),
				), true);
			} elseif ($query['recursive'] === 0) {
				$query['fields'] = array_merge($query['fields'], [
					$this->Page->Room->alias . '.id',
					$this->Page->Room->alias . '.space_id',
					$this->Page->Room->alias . '.page_id_top',
					$this->Page->Room->alias . '.parent_id',
					//$this->Page->Room->alias . '.lft',
					//$this->Page->Room->alias . '.rght',
					$this->Page->Room->alias . '.active',
					//$this->Page->Room->alias . '.in_draft',
					$this->Page->Room->alias . '.default_role_key',
					$this->Page->Room->alias . '.need_approval',
					$this->Page->Room->alias . '.default_participation',
					$this->Page->Room->alias . '.page_layout_permitted',
					$this->Page->Room->alias . '.theme',
					$this->Space->alias . '.id',
					$this->Space->alias . '.parent_id',
					//$this->Space->alias . '.lft',
					//$this->Space->alias . '.rght',
					$this->Space->alias . '.type',
					$this->Space->alias . '.plugin_key',
					$this->Space->alias . '.default_setting_action',
					$this->Space->alias . '.room_disk_size',
					$this->Space->alias . '.room_id_root',
					$this->Space->alias . '.page_id_top',
					$this->Space->alias . '.permalink',
					$this->Space->alias . '.is_m17n',
					$this->Space->alias . '.after_user_save_model',
				]);
				$query['recursive'] = -1;
				$query['joins'] = [
					[
						'type' => 'INNER',
						'table' => $this->Page->Room->table,
						'alias' => $this->Page->Room->alias,
						'conditions' => [
							$this->Page->Room->alias . '.id' . '=' . $this->Page->alias . '.room_id',
						],
					],
					[
						'type' => 'INNER',
						'table' => $this->Space->table,
						'alias' => $this->Space->alias,
						'conditions' => [
							$this->Space->alias . '.id' . '=' . $this->Page->Room->alias . '.space_id',
						],
					]
				];
			}
			$result = $this->Page->find('first', $query);
			self::$__memoryCache['Page'][$cacheId] = $result;
		}

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
				'order' => array('Page.sort_key' => 'asc')
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

		if (! self::$_instanceFrame) {
			self::$_instanceFrame = new CurrentFrame();
		}
		self::$_instanceFrame->setBoxPageContainer();
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
		$result = $this->__getPage(array(
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

		$cacheId = 'room_id_' . $roomId;
		if (isset(self::$__memoryCache['Room'][$cacheId])) {
			$cache = self::$__memoryCache['Room'][$cacheId];
			Current::setCurrent($cache);
		} else {
			$conditions = array(
				'Room.id' => $roomId
			);
			$result = $this->Room->find('first', array(
				'recursive' => 0,
				'fields' => [
					$this->Room->alias . '.id',
					$this->Room->alias . '.space_id',
					$this->Room->alias . '.page_id_top',
					$this->Room->alias . '.parent_id',
					//$this->Room->alias . '.lft',
					//$this->Room->alias . '.rght',
					$this->Room->alias . '.active',
					//$this->Room->alias . '.in_draft',
					$this->Room->alias . '.default_role_key',
					$this->Room->alias . '.need_approval',
					$this->Room->alias . '.default_participation',
					$this->Room->alias . '.page_layout_permitted',
					$this->Room->alias . '.theme',
					$this->Room->Space->alias . '.id',
					$this->Room->Space->alias . '.parent_id',
					//$this->Room->Space->alias . '.lft',
					//$this->Room->Space->alias . '.rght',
					$this->Room->Space->alias . '.type',
					$this->Room->Space->alias . '.plugin_key',
					$this->Room->Space->alias . '.default_setting_action',
					$this->Room->Space->alias . '.room_disk_size',
					$this->Room->Space->alias . '.room_id_root',
					$this->Room->Space->alias . '.page_id_top',
					$this->Room->Space->alias . '.permalink',
					$this->Room->Space->alias . '.is_m17n',
					$this->Room->Space->alias . '.after_user_save_model',
				],
				'conditions' => $conditions,
			));
			self::$__memoryCache['Room'][$cacheId] = $result;
			Current::setCurrent($result);
		}
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
