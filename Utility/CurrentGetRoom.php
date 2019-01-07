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

/**
 * NetCommonsの機能に必要な情報(ルーム関連)を取得する内容をまとめたUtility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetRoom {

/**
 * CurrentGetRoomインスタンス
 *
 * @var CurrentGetRoom
 */
	private static $___instance;

/**
 * ログインなしで参照できるスペースリストデータ
 *
 * @var array
 */
	public static $__spacesWOLogin = [
		Space::PUBLIC_SPACE_ID,
	];

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	private $__controller;

/**
 * Roomモデル
 *
 * @var Room
 */
	public $Room;

/**
 * Roomモデル
 *
 * @var Space
 */
	public $Space;

/**
 * RolesRoomモデル
 *
 * @var RolesRoom
 */
	public $RolesRoom;

/**
 * RoomRolePermissionモデル
 *
 * @var RoomRolePermission
 */
	public $RoomRolePermission;

/**
 * RolesRoomsUserモデル
 *
 * @var RolesRoomsUser
 */
	public $RolesRoomsUser;

/**
	* 一度取得したルームデータを保持
 *
 * @var array|null
 */
	private $__room = null;

/**
	* 一度取得したスペースデータを保持
 *
 * @var array|null
 */
	private $__space = null;

/**
	* 一度取得したルームデータを保持
 *
 * @var array|null
 */
	private $__room = null;

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
 * ※カレンダーなどで使用できるように取得する
 *
 * @var array|null
 */
	private $__rolesRooms = null;

/**
 * ログインしたユーザIDを保持
 *
 * @var string ユーザID(intの文字列)
 */
	private $__userId = null;

/**
 * コンストラクター
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function __construct(Controller $controller) {
		$this->__controller = $controller;

		$this->Space = ClassRegistry::init('Rooms.Space');
		$this->Room = ClassRegistry::init('Rooms.Room');
		$this->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');
		$this->RolesRoom = ClassRegistry::init('Rooms.RolesRoom');
		$this->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');

		$this->__userId = Current::read('User.id');
	}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetRoom
 */
	public static function getInstance(Controller $controller) {
		if (! self::$___instance) {
			self::$___instance = new CurrentGetRoom($controller);
		}
		return self::$___instance;
	}

/**
 * ログインなしで閲覧可能なスペースIDリストに追加する
 *
 * @param string $spaceId スペースID(intの文字列)
 * @return void
 */
	public static function addSpaceIdsWithoutLogin($spaceId) {
		if (! in_array($spaceId, self::$__spacesWOLogin, true)) {
			self::$__spacesWOLogin[] = $spaceId;
		}
	}

/**
 * ルームデータを取得する
 *
 * @param string $roomId ルームID(intの文字列)
 * @return array
 */
	public function getRoom($roomId) {
		if ($this->__room) {
			return $this->__room;
		}

		$room = $this->Room->find('first', array(
			'recursive' => -1,
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
			],
			'conditions' => [
				'id' => $roomId
			],
		));

		$this->__room = $room['Room'];
		$this->__space = $this->Space->getSpace($room['Room']['space_id']);

		return $this->__room;
	}

/**
 * プライベートルームデータを取得する
 *
 * @param string $userId ユーザID(intの文字列)
 * @return array
 */
	public function getPrivateRoom($userId) {
		if ($this->__room) {
			return $this->__room;
		}

		$room = $this->Room->getPrivateRoomByUserId($userId);
		$this->__room = $room['Room'];
		$this->__space = $this->Space->getSpace($room['Room']['space_id']);

		return $this->__room;
	}

/**
 * 参加ルーム(roles_rooms_uses)のIDリストを取得する
 * ※同時に、ルーム権限データも取得する
 *
 * @param string $userId ユーザID(intの文字列)
 * @return array
 */
	public function getMemberRoomIds() {
		if (isset($this->__memberRoomIds)) {
			return $this->__memberRoomIds;
		}

		if ($this->__userId) {
			$rolesRoomsUser = $this->RolesRoomsUser->find('all', array(
				'recursive' => -1,
				'fields' => [
					$this->RolesRoom->alias . '.id',
					$this->RolesRoom->alias . '.room_id',
					$this->RolesRoom->alias . '.role_key',
				],
				'conditions' => [
					'RolesRoomsUser.user_id' => $this->__userId
				],
				'joins' => [
					[
						'table' => $this->Room->table,
						'alias' => $this->Room->alias,
						'type' => 'INNER',
						'conditions' => [
							$this->RolesRoomsUser->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
						],
					],
					[
						'table' => $this->RolesRoom->table,
						'alias' => $this->RolesRoom->alias,
						'type' => 'INNER',
						'conditions' => [
							$this->RolesRoomsUser->alias . '.roles_room_id' . ' = ' . $this->RolesRoom->alias . ' .id',
						],
					],
				],
			));
			$this->__memberRoomIds = [];
			foreach ($rolesRoomsUser as $roleRoom) {
				$roomId = $roleRoom['RolesRoom']['room_id'];
				$this->__memberRoomIds[] = $roomId;
				$this->__rolesRooms[$roomId] = $roleRoom;
			}
		} else {
			$this->__memberRoomIds = [];
			$this->__rolesRooms = [];
		}
		return $this->__memberRoomIds;
	}

/**
 * ルームロール権限データ取得
 *
 * @return [
 */
	public function getRoomRolePermissions($roomId) {
		if (! isset($this->__rolesRooms[$roomId])) {
			$roomIds = $this->getMemberRoomIds();
			if (! in_array($roomId, $roomIds, true)) {
				return [];
			}
		}
		$roleRoomId = $this->__rolesRooms[$roomId];


//		if (isset(Current::$current['RoomRolePermission']) || ! isset(Current::$current['RolesRoom'])) {
//			return;
//		}
//
//		// ルームロールパーミッション取得
//		$results = $this->__getRoomRolePermissions(Current::$current['RolesRoom']['id']);
//
//		if ($results) {
//			foreach ($results as $rolePermission) {
//				$permission = $rolePermission['RoomRolePermission']['permission'];
//				Current::$current['RoomRolePermission'][$permission] = $rolePermission['RoomRolePermission'];
//			}
//		}
	}

}
