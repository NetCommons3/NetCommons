<?php
/**
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');

/**
 * NetCommonsの機能に必要な情報(ルーム関連)を取得する内容をまとめたUtility
 *
 * @property string $_lang 言語ID
 * @property Controller $_controller コントローラ
 * @property Room $Room Roomモデル
 * @property Space $Space Spaceモデル
 * @property RolesRoom $RolesRoom RolesRoomモデル
 * @property RoomRolePermission $RoomRolePermission RoomRolePermissionモデル
 * @property RolesRoomsUser $RolesRoomsUser RolesRoomsUserモデル
 * @property RoomsLanguage $RoomsLanguage RoomsLanguageモデル
 * @property PluginsRoom $PluginsRoom PluginsRoomモデル
 *
 * @property CurrentLibPlugin $CurrentLibPlugin CurrentLibPluginライブラリ
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibUser $CurrentLibUser CurrentLibUserライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibRoom extends LibAppObject {

/**
 * ログインなしで参照できるスペースリストデータ
 *
 * @var array
 */
	private static $__spacesWOLogin = [
		Space::PUBLIC_SPACE_ID,
	];

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'Room',
		'Space' => 'Rooms.Space',
		'RolesRoom',
		'RoomRolePermission',
		'RolesRoomsUser',
		'RoomsLanguage',
		'PluginsRoom',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'ControlPanel' => 'NetCommons.Lib',
		'CurrentLibPlugin' => 'NetCommons.Lib/Current',
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
		'CurrentLibUser' => 'NetCommons.Lib/Current',
	];

/**
	* 一度取得したルームデータを保持
 *
 * @var array|null
 */
	private $__rooms = null;

/**
 * プライベートルームID
 *
 * @var string|null
 */
	private $__privateRoomId = null;

/**
 * 一度取得した参加ルーム(roles_rooms_uses)のIDリストを保持
 *
 * ※カレンダーなどで使用できるように取得する
 *
 * @var array|null
 */
	private $__memberRoomIds = null;

/**
 * 一度取得したルーム権限(roles_rooms)データを保持
 *
 * @var array|null
 */
	private $__userRoomRoles = null;

/**
 * ルーム権限IDからルームIDに変換するためのIDを保存
 *
 * @var array|null
 */
	private $__roomsIdById = null;

/**
 * 一度取得したルームに対するプラグインデータを保持
 *
 * @var array|null
 */
	private $__plugins = null;

/**
 * ログインしたユーザIDを保持
 *
 * @var string ユーザID(intの文字列)
 */
	private $__userId = null;

/**
 * 言語IDを保持
 *
 * @var string 数値の文字列
 */
	private $__langId = null;

/**
 * 一度取得したルーム権限パーミッション(room_role_permissions)データを保持
 *
 * @var array|null
 */
	private $__rolePermissions = null;

/**
 * インスタンスの取得
 *
 * @return CurrentLibRoom
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
		parent::_resetInstance(__CLASS__);
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		parent::initialize($controller);

		$this->__langId = $this->CurrentLibLanguage->getLangId();
		$this->__userId = $this->CurrentLibUser->getLoginUserId();
	}

/**
 * ログインなしで閲覧可能なスペースIDリストに追加する
 *
 * @param string|int $spaceId スペースID
 * @return void
 */
	public static function addSpaceIdsWithoutLogin($spaceId) {
		if (! in_array($spaceId, self::$__spacesWOLogin, true)) {
			self::$__spacesWOLogin[] = $spaceId;
		}
	}

/**
 * ルームIDの取得
 *
 * @return string|null ルームID。nullの場合、パラメータ等からroom_idが取得できなかった
 */
	public function getCurrentRoomId() {
		if (isset($this->_controller->request->data['Room']['id'])) {
			//POSTにroom_idが含まれている
			$roomId = $this->_controller->request->data['Room']['id'];
		} elseif (isset($this->_controller->query['room_id'])) {
			//リクエストパラメータにroom_idが含まれている
			$roomId = $this->_controller->query['room_id'];
		} elseif (isset($this->_controller->request->params['room_id'])) {
			//controller->paramsにroom_idが含まれる
			//※URLのパスに/:room_idが含まれるか、直接controller->params['room_id']にセットされる場合、
			$roomId = $this->_controller->request->params['room_id'];
		} else {
			$roomId = null;
		}

		return $roomId;
	}

/**
 * リクエストパラメータにルームIDがあるか
 *
 * @return bool
 */
	public function isRoomIdInRequest() {
		return isset($this->_controller->request->data['Room']['id']) ||
				isset($this->_controller->request->query['room_id']) ||
				isset($this->_controller->request->params['room_id']);
	}

/**
 * ルームデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __makeFieldsByRoom() {
		$fields = [
			'Room.id',
			'Room.space_id',
			'Room.page_id_top',
			'Room.parent_id',
			'Room.active',
			'Room.default_role_key',
			'Room.need_approval',
			'Room.default_participation',
			'Room.page_layout_permitted',
			'Room.theme',
		];
		return $fields;
	}

/**
 * ルーム言語データを取得するカラムを生成する
 *
 * @return array
 */
	private function __makeFieldsByRoomsLanguage() {
		$fields = [
			'RoomsLanguage.id',
			'RoomsLanguage.language_id',
			'RoomsLanguage.is_origin',
			'RoomsLanguage.is_translation',
			'RoomsLanguage.room_id',
			'RoomsLanguage.name'
		];
		return $fields;
	}

/**
 * ルームデータを取得する
 *
 * @param array $roomIds ルームID(intの文字列)リスト
 * @return array
 */
	public function findRoomsByIds($roomIds) {
		if (isset($this->__rooms)) {
			$findRoomIds = array_diff(array_unique($roomIds), array_keys($this->__rooms));
		} else {
			$findRoomIds = $roomIds;
		}

		if (count($findRoomIds) > 0) {
			$rooms = $this->Room->find('all', array(
				'recursive' => -1,
				'fields' => $this->__makeFieldsByRoom(),
				'conditions' => [
					'id' => $findRoomIds
				],
				'callbacks' => false,
			));
			foreach ($rooms as $room) {
				$roomId = $room['Room']['id'];
				$this->__rooms[$roomId] = $room;
				$this->__rooms[$roomId] += $this->__findRoomsLanguage($roomId);
				$this->__rooms[$roomId]['Space'] = $this->Space->getSpace($room['Room']['space_id']);
			}
		}

		$results = [];
		foreach ($roomIds as $roomId) {
			$results[] = $this->__rooms[$roomId];
		}
		return $results;
	}

/**
 * ルームデータを取得する
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	public function findRoomById($roomId) {
		if (isset($this->__rooms[$roomId])) {
			return $this->__rooms[$roomId];
		}

		$room = $this->Room->find('first', array(
			'recursive' => -1,
			'fields' => $this->__makeFieldsByRoom(),
			'conditions' => [
				'id' => $roomId
			],
			'callbacks' => false,
		));

		$this->__rooms[$roomId] = $room;
		$this->__rooms[$roomId] += $this->__findRoomsLanguage($roomId);
		$this->__rooms[$roomId]['Space'] = $this->Space->getSpace($room['Room']['space_id']);

		return $this->__rooms[$roomId];
	}

/**
 * スペースデータを取得する
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	public function findSpaceByRoomId($roomId) {
		$room = $this->findRoomById($roomId);
		return $room['Space'];
	}

/**
 * ルーム言語データの取得
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	private function __findRoomsLanguage($roomId) {
		$roomLanguage = $this->RoomsLanguage->find('first', [
			'recursive' => -1,
			'fields' => $this->__makeFieldsByRoomsLanguage(),
			'conditions' => [
				'room_id' => $roomId,
				'language_id' => $this->__langId,
			],
			'callbacks' => false,
		]);

		//対象の言語の名称がなければ、主になっている言語の名称を取得する
		if (! $roomLanguage) {
			$roomLanguage = $this->RoomsLanguage->find('first', [
				'recursive' => -1,
				'fields' => $this->__makeFieldsByRoomsLanguage(),
				'conditions' => [
					'room_id' => $roomId,
					'is_origin' => true,
				],
				'callbacks' => false,
			]);
		}
		return $roomLanguage;
	}

/**
 * プライベートルームデータを取得する
 *
 * @param string|int $userId ユーザID
 * @return array
 */
	public function findPrivateRoom($userId) {
		if (isset($this->__privateRoomId)) {
			return $this->__rooms[$this->__privateRoomId];
		}

		$room = $this->Room->find('first', [
			'recursive' => -1,
			'fields' => [
				$this->Room->alias . '.id',
			],
			'conditions' => [
				$this->Room->alias . '.space_id' => Space::PRIVATE_SPACE_ID,
				$this->Room->alias . '.page_id_top NOT' => null,
			],
			'joins' => [
				[
					'table' => $this->RolesRoomsUser->table,
					'alias' => $this->RolesRoomsUser->alias,
					'type' => 'INNER',
					'conditions' => [
						$this->RolesRoomsUser->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
						$this->RolesRoomsUser->alias . '.user_id' => $userId,
					],
				],
			],
		]);

		$roomId = $room['Room']['id'];
		$this->__privateRoomId = $roomId;
		$this->__rooms[$roomId] = $this->findRoomById($roomId);

		return $this->__rooms[$roomId];
	}

/**
 * 参加ルーム(roles_rooms_uses)のIDリストを取得する
 * ※同時に、ユーザのルーム内役割も取得し、内部変数に保持する
 *
 * @return array
 */
	public function getMemberRoomIds() {
		if (isset($this->__memberRoomIds)) {
			return $this->__memberRoomIds;
		}

		if ($this->__userId) {
			if ($this->allowRoomManager()) {
				$conditions = [
					'RolesRoomsUser.user_id' => $this->__userId,
				];
			} else {
				$conditions = [
					'RolesRoomsUser.user_id' => $this->__userId,
					'Room.active' => true,
					'Room.in_draft' => false
				];
			}

			$rolesRoomsUser = $this->RolesRoomsUser->find('all', [
				'recursive' => -1,
				'fields' => [
					'Room.id',
					'Room.active',
					'Room.in_draft',
					'RolesRoom.id',
					'RolesRoom.room_id',
					'RolesRoom.role_key',
					'RolesRoom.id',
					'RolesRoom.room_id',
					'RolesRoom.role_key',
					'RolesRoomsUser.id',
					'RolesRoomsUser.roles_room_id',
					'RolesRoomsUser.user_id',
					'RolesRoomsUser.room_id',
					'RolesRoomsUser.access_count',
					'RolesRoomsUser.last_accessed',
				],
				'conditions' => $conditions,
				'joins' => [
					[
						'table' => $this->Room->table,
						'alias' => $this->Room->alias,
						'type' => 'INNER',
						'conditions' => [
							'RolesRoomsUser.room_id = Room.id',
						],
					],
					[
						'table' => $this->RolesRoom->table,
						'alias' => $this->RolesRoom->alias,
						'type' => 'INNER',
						'conditions' => [
							'RolesRoomsUser.roles_room_id = RolesRoom.id',
						],
					],
				],
				'callbacks' => false,
			]);
			$this->__memberRoomIds = [];
			foreach ($rolesRoomsUser as $roleRoom) {
				unset($roleRoom['Room']);
				$roomId = $roleRoom['RolesRoom']['room_id'];
				$roleRoomId = $roleRoom['RolesRoom']['id'];
				$this->__memberRoomIds[] = $roomId;
				$this->__userRoomRoles[$roomId] = $roleRoom;
				$this->__roomsIdById[$roleRoomId] = $roomId;
			}
		} else {
			$this->__memberRoomIds = [];
			$this->__userRoomRoles = [];
			$this->__roomsIdById = [];
		}
		return $this->__memberRoomIds;
	}

/**
 * ルームIDからユーザのルーム権限データ取得
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	public function findUserRoomRoleByRoomId($roomId) {
		if (! isset($this->__userRoomRoles)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return [];
			}
		}
		if (isset($this->__userRoomRoles[$roomId])) {
			return $this->__userRoomRoles[$roomId];
		} else {
			return [];
		}
	}

/**
 * ルーム権限IDからルーム権限データ取得
 *
 * @param string|int $roleRoomId ルーム権限ID
 * @return array
 */
	public function findRoleRoomById($roleRoomId) {
		if (! isset($this->__roomsIdById)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return [];
			}
		}
		if (isset($this->__roomsIdById[$roleRoomId])) {
			$roomId = $this->__roomsIdById[$roleRoomId];
			return $this->__userRoomRoles[$roomId];
		} else {
			return [];
		}
	}

/**
 * ルーム権限IDの取得
 *
 * @param string|int $roomId ルームID
 * @return string|null
 */
	public function getRoleRoomIdByRoomId($roomId) {
		if (! isset($this->__userRoomRoles)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return null;
			}
		}
		if (isset($this->__userRoomRoles[$roomId])) {
			return $this->__userRoomRoles[$roomId]['RolesRoom']['id'];
		} else {
			return null;
		}
	}

/**
 * ルーム権限の取得
 *
 * @param string|int $roomId ルームID
 * @return string|null 権限の文字列
 */
	public function getRoomRoleKeyByRoomId($roomId) {
		if (! isset($this->__userRoomRoles)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return null;
			}
		}

		if (isset($this->__userRoomRoles[$roomId])) {
			return $this->__userRoomRoles[$roomId]['RolesRoom']['role_key'];
		} else {
			return null;
		}
	}

/**
 * ルームプラグインデータ取得
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	public function findPluginsRoom($roomId) {
		if (isset($this->__plugins[$roomId])) {
			return $this->__plugins[$roomId];
		}

		$pluginsRoom = $this->PluginsRoom->find('all', [
			'recursive' => -1,
			'fields' => [
				'PluginsRoom.plugin_key',
			],
			'conditions' => [
				'room_id' => $roomId
			],
			'callbacks' => false,
		]);

		$pluginKeys = [];
		foreach ($pluginsRoom as $pluginRoom) {
			$pluginKeys[] = $pluginRoom['PluginsRoom']['plugin_key'];
		}

		$this->__plugins[$roomId] =
				$this->CurrentLibPlugin->findPlugins($pluginKeys, $this->__langId);

		return $this->__plugins[$roomId];
	}

/**
 * ルーム権限パーミッションデータ取得
 *
 * @param string|int $roomId ルームID
 * @return array
 */
	public function findRoomRolePermissions($roomId) {
		if (isset($this->__rolePermissions[$roomId])) {
			return $this->__rolePermissions[$roomId];
		}

		$roleRoomId = $this->getRoleRoomIdByRoomId($roomId);
		if ($roleRoomId) {
			// ルーム権限パーミッション取得
			$results = $this->RoomRolePermission->find('all', [
				'recursive' => -1,
				'fields' => [
					'id', 'roles_room_id', 'permission', 'value'
				],
				'conditions' => [
					'roles_room_id' => $roleRoomId,
				],
				'callbacks' => false,
			]);
			foreach ($results as $permission) {
				$key = $permission['RoomRolePermission']['permission'];
				$this->__rolePermissions[$roomId][$key] = $permission['RoomRolePermission'];
			}
		}

		if (isset($this->__rolePermissions[$roomId])) {
			return $this->__rolePermissions[$roomId];
		} else {
			return [];
		}
	}

/**
 * ルーム管理が使用できるか否か
 *
 * @return bool
 */
	public function allowRoomManager() {
		return $this->CurrentLibPlugin->allowSystemPlugin('rooms');
	}

}
