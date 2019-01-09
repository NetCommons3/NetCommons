<?php
/**
 * NetCommonsの機能に必要な情報(パーミッション関連)を取得する内容をまとめたUtility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CurrentGetRoom', 'NetCommons.Utility');

/**
 * NetCommonsの機能に必要な情報(パーミッション関連)を取得する内容をまとめたUtility
 *
 * @property DefaultRolePermission $DefaultRolePermission DefaultRolePermissionモデル
 * @property RoomRolePermission $RoomRolePermission RoomRolePermissionモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetPermission extends CurrentGetAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'DefaultRolePermission' => 'Roles.DefaultRolePermission',
		'RoomRolePermission' => 'Rooms.RoomRolePermission',
	];

/**
 * 一度取得したルーム権限パーミッション(room_role_permissions)データを保持
 *
 * @var array|null
 */
	private $__roomRolePermissions = null;

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetPermission
 */
	public static function getInstance(Controller $controller) {
		return parent::_getInstance($controller, __CLASS__);
	}

/**
 * デフォルトロールデータ取得
 *
 * @param string $roleKey ロールキー
 * @return array
 */
	public function findDefaultRolePermissions($roleKey) {
		$queryOptions = [
			'recursive' => -1,
			'conditions' => [
				'role_key' => $roleKey,
			],
		];
		$cacheKey = $this->DefaultRolePermission->createCacheQueryKey($queryOptions);

		$permissions = $this->DefaultRolePermission->cacheRead('current', $cacheKey);
		if ($permissions) {
			return $permissions;
		}

		$results = [];
		$permissions = $this->DefaultRolePermission->cacheFindQuery('all', $queryOptions);
		foreach ($permissions as $permission) {
			$key = $permission['DefaultRolePermission']['permission'];
			$results[$key] = $permission['DefaultRolePermission'];
		}

		$this->DefaultRolePermission->cacheWrite($results, 'current', $cacheKey);
		return $results;
	}

/**
 * ルーム権限パーミッションデータ取得
 *
 * @return array
 */
	public function findRoomRolePermissions($roomId) {
		if (isset($this->__roomRolePermissions[$roomId])) {
			return $this->__roomRolePermissions[$roomId];
		}
		if (isset($this->__roomRolePermissions)) {
			return [];
		}

		$instance = CurrentGetRoom::getInstance($this->__controller);

		$roleRoomIds = $instance->getRoleRoomIds();
		if ($roleRoomIds) {
			// ルーム権限パーミッション取得
			$results = $this->RoomRolePermission->find('all', [
				'recursive' => -1,
				'conditions' => [
					'roles_room_id' => $roleRoomIds,
				],
			]);
			foreach ($results as $permission) {
				$roleRoomId = $permission['RoomRolePermission']['roles_room_id'];
				$key = $permission['RoomRolePermission']['permission'];
				$roomId = $instance->findRoleRoomById($roleRoomId);
				$this->__roomRolePermissions[$roomId][$key] = $permission['RoomRolePermission'];
			}
		}

		if (isset($this->__roomRolePermissions[$roomId])) {
			return $this->__roomRolePermissions[$roomId];
		} else {
			return [];
		}
	}

}
