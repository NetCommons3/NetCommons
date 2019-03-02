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
 * @property CurrentLibPermission $CurrentLibPermission CurrentLibPermissionライブラリ
 * @property CurrentLibRoom $CurrentLibRoom CurrentLibRoomライブラリ
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
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibPermission' => 'NetCommons.Lib/Current',
		'CurrentLibRoom' => 'NetCommons.Lib/Current',
	];

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
		self::$permission = [];
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
		if (isset(self::$permission[$roomId]['Permission'][$key]['value'])) {
			return self::$permission[$roomId]['Permission'][$key]['value'];
		}

		$roomRoleKey = $this->CurrentLibRoom->getRoomRoleKeyByRoomId($roomId);

		// * デフォルトロールパーミッションデータのセット
		$permissions = $this->CurrentLibPermission->findDefaultRolePermissions($roomRoleKey);
		foreach ($permissions as $key => $permission) {
			$this->write($roomId, $key, $permission['value']);
		}

		// * ルームロールパーミッションデータのセット
		$permissions = $this->CurrentLibRoom->findRoomRolePermissions($roomId);
		foreach ($permissions as $key => $permission) {
			$this->write($roomId, $key, $permission['value']);
		}
	}

}
