<?php
/**
 * パーミッションを操作するライブラリ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');

/**
 * パーミッションを操作するライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class NcPermission extends LibAppObject {

/**
 * パーミッションデータ保持
 *
 * @var array
 */
	public static $permission = array();

/**
 * インスタンスの取得
 *
 * @return NcPermission
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
 * 指定された$keyの値をセットします
 *
 * @param int|null $roomId ルームID
 * @param string $key パーミッションキー
 * @param bool $value パーミッション値
 * @return void
 */
	public static function write($roomId, $key, $value) {
		self::$permission[$roomId]['Permission'][$key]['value'] = $value;
	}

/**
 * 指定された$key(権限名文字列)の値を返します。
 *
 * ```
 * NcPermission::read('content_publishable')
 * ```
 *
 * @param int|null $roomId ルームID
 * @param string $key パーミッションキー
 * @return bool パーミッション値
 */
	public function read($roomId, $key) {
//		if (! isset(self::$current)) {
//			return false;
//		}
//		$currentRoomId = self::read('Room.id');
//		if (! $roomId) {
//			//$roomId = self::read('Room.id');
//			$roomId = $currentRoomId;
//		}
//
//		//$path = 'Permission.' . $key . '.value';
//		if (isset(self::$permission[$roomId]['Permission'][$key]['value'])) {
//			return self::$permission[$roomId]['Permission'][$key]['value'];
//		}
//
//		if ($roomId == $currentRoomId) {
//			//$result = (bool)self::read($path);
//			if (isset(self::$current['Permission'][$key]['value'])) {
//				$result = self::$current['Permission'][$key]['value'];
//			} else {
//				$result = false;
//			}
//		} else {
//			$RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');
//			if (isset(self::$current['User']['id'])) {
//				$userId = self::$current['User']['id'];
//			} else {
//				$userId = null;
//			}
//			$roleRoomUser = $RolesRoomsUser->find('first', array(
//				'recursive' => -1,
//				'conditions' => array(
//					'RolesRoomsUser.user_id' => $userId,
//					'RolesRoomsUser.room_id' => $roomId,
//				),
//			));
//			if (isset($roleRoomUser['RolesRoomsUser']['roles_room_id'])) {
//				$rolesRoomId = $roleRoomUser['RolesRoomsUser']['roles_room_id'];
//			} else {
//				$rolesRoomId = '0';
//			}
//
//			$RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');
//			$roomRolePermission = $RoomRolePermission->find('first', array(
//				'recursive' => -1,
//				'conditions' => array(
//					$RoomRolePermission->alias . '.roles_room_id' => $rolesRoomId,
//					$RoomRolePermission->alias . '.permission' => $key,
//				),
//			));
//			if (isset($roomRolePermission['RoomRolePermission']['value'])) {
//				$result = $roomRolePermission['RoomRolePermission']['value'];
//			} else {
//				$result = false;
//			}
//		}
//
//		//self::$permission = Hash::insert(self::$permission, $roomId . '.' . $path, $result);
//		self::$permission[$roomId]['Permission'][$key]['value'] = $result;
//		return $result;
	}

}
