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
App::uses('CurrentLibSystem', 'NetCommons.Lib/Current');

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
	protected $_uses = [
		'Room' => 'Rooms.Room',
		'Space' => 'Rooms.Space',
		'RolesRoom' => 'Rooms.RolesRoom',
		'RoomRolePermission' => 'Rooms.RoomRolePermission',
		'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
		'RoomsLanguage' => 'Rooms.RoomsLanguage',
		'PluginsRoom' => 'PluginManager.PluginsRoom',
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
	private $__roleRooms = null;

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
 * クラス内で処理するCurrentLibSystemインスタンス
 *
 * @var CurrentLibSystem
 */
	protected $_CurrentLibSystem;

/**
 * コンストラクター
 *
 * @param Controller|null $controller コントローラ
 * @return void
 */
	public function __construct($controller = null) {
		parent::__construct($controller);

		$this->__userId = Current::read('User.id');
	}

/**
 * インスタンスの取得
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentLibRoom
 */
	public static function getInstance($controller = null) {
		return parent::_getInstance(__CLASS__, $controller);
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function setController($controller) {
		parent::setController($controller);

		$this->_CurrentLibSystem = CurrentLibSystem::getInstance($controller);
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
	public function findRoom($roomId) {
		if (isset($this->__rooms[$roomId])) {
			return $this->__rooms[$roomId];
		}

		$room = $this->Room->find('first', array(
			'recursive' => -1,
			'fields' => [
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
			],
			'conditions' => [
				'id' => $roomId
			],

		));

		$this->__rooms[$roomId] = $room;
		$this->__rooms[$roomId] += $this->__findRoomsLanguage($roomId);
		$this->__rooms[$roomId] += $this->Space->getSpace($room['Room']['space_id']);

		return $this->__rooms[$roomId];
	}

/**
 * ルーム言語データの取得
 *
 * @param string $roomId ルームID(intの文字列)
 * @return array
 */
	private function __findRoomsLanguage($roomId) {
		$roomLanguage = $this->RoomsLanguage->find('first', [
			'recursive' => -1,
			'conditions' => [
				'room_id' => $roomId,
				'language_id' => $this->_langId,
			],
		]);
		return $roomLanguage;
	}

/**
 * プライベートルームデータを取得する
 *
 * @param string $userId ユーザID(intの文字列)
 * @return array
 */
	public function findPrivateRoom($userId) {
		if (isset($this->__privateRoomId)) {
			return $this->__rooms[$this->__privateRoomId];
		}

		$room = $this->Room->getPrivateRoomByUserId($userId);

		$roomId = $room['Room']['id'];
		$this->__privateRoomId = $roomId;
		$this->__rooms[$roomId] = $room;
		$this->__rooms[$roomId] += $this->__findRoomsLanguage($roomId);
		$this->__rooms[$roomId] += $this->Space->getSpace($roomId);

		return $this->__rooms[$roomId];
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
			$rolesRoomsUser = $this->RolesRoomsUser->find('all', [
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
			]);
			$this->__memberRoomIds = [];
			foreach ($rolesRoomsUser as $roleRoom) {
				$roomId = $roleRoom['RolesRoom']['room_id'];
				$roleRoomId = $roleRoom['RolesRoom']['id'];
				$this->__memberRoomIds[] = $roomId;
				$this->__roleRooms[$roomId] = $roleRoom;
				$this->__roomsIdById[$roleRoomId] = $roomId;
			}
		} else {
			$this->__memberRoomIds = [];
			$this->__roleRooms = [];
			$this->__roomsIdById = [];
		}
		return $this->__memberRoomIds;
	}

/**
 * ルームIDからルーム権限データ取得
 *
 * @return array
 */
	public function findRoleRoomByRoomId($roomId = null) {
		if (! isset($this->__roleRooms)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return null;
			}
		}
		if (isset($this->__roleRooms[$roomId])) {
			return $this->__roleRooms[$roomId];
		} else {
			return null;
		}
	}

/**
 * ルーム権限IDからルーム権限データ取得
 *
 * @return array
 */
	public function findRoleRoomById($roleRoomId = null) {
		if (! isset($this->__roomsIdById)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return [];
			}
		}
		if (isset($this->__roomsIdById[$roleRoomId])) {
			$roomId = $this->__roomsIdById[$roleRoomId];
			return $this->__roleRooms[$roomId];
		} else {
			return [];
		}
	}

/**
 * ルーム権限IDリスト取得
 *
 * @return array
 */
	public function findRoleRoomIds() {
		if (! isset($this->__roomsIdById)) {
			$roomIds = $this->getMemberRoomIds();
			if (! $roomIds) {
				return [];
			}
		}
		return array_keys($this->__roomsIdById);
	}

/**
 * ルームプラグインデータ取得
 *
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
		]);

		$pluginKeys = [];
		foreach ($pluginsRoom as $pluginRoom) {
			$pluginKeys[] = $pluginRoom['PluginsRoom']['plugin_key'];
		}

		$this->__plugins[$roomId] =
				$this->_CurrentLibSystem->findPlugins($pluginKeys, $this->__langId);

		return $this->__plugins[$roomId];
	}

}
