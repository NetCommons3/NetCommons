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
App::uses('CurrentLib', 'NetCommons.Lib');

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
 * NcPermissionクラスのメンバ変数として、定義したいが、
 * 旧CurrentライブラリでCurrent::$permissionとして、直接書き換える処理が多数行われているため、
 * NcPermissionクラスのメンバ変数ではなく、CurrentLibクラスとする
 *
 * @var array
 */
	//public static $permission = [];

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
		CurrentLib::$permission = [];
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
		CurrentLib::$permission[$roomId]['Permission'][$key]['value'] = $value;
	}

/**
 * パーミッションデータをクリアする
 *
 * @param int|null $roomId ルームID
 * @return void
 */
	public static function clear($roomId = null) {
		if ($roomId) {
			if (isset(CurrentLib::$permission[$roomId])) {
				unset(CurrentLib::$permission[$roomId]);
			}
		} else {
			CurrentLib::$permission = [];
		}
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
		//UnitTestで使用するため、下のcontrollerのチェック前に行う。
		if (isset(CurrentLib::$permission[$roomId]['Permission'][$key]['value'])) {
			return CurrentLib::$permission[$roomId]['Permission'][$key]['value'];
		} elseif (isset(CurrentLib::$permission['0']['Permission'][$key]['value'])) {
			return CurrentLib::$permission['0']['Permission'][$key]['value'];
		}

		//コントローラがない場合、初期データが取得されていないため、falseとする。
		//PurifiableBehavior->setup()でCurrent::permissionを呼んでいる。
		//ここで呼んでいるが、パースする直前でもCurrent::permissionを呼んでチェックしてるため、影響ない。
		//@see https://github.com/NetCommons3/Wysiwyg/blob/3.2.2/Model/Behavior/PurifiableBehavior.php#L317-L324
		if (empty($this->_controller)) {
			return false;
		}

		$roomRoleKey = $this->CurrentLibRoom->getRoomRoleKeyByRoomId($roomId);

		// * デフォルトロールパーミッションデータのセット
		$permissions = $this->CurrentLibPermission->findDefaultRolePermissions($roomRoleKey);
		foreach ($permissions as $perm => $permission) {
			$this->write($roomId, $perm, $permission['value']);
		}

		// * ルームロールパーミッションデータのセット
		$permissions = $this->CurrentLibRoom->findRoomRolePermissions($roomId);
		foreach ($permissions as $perm => $permission) {
			$this->write($roomId, $perm, $permission['value']);
		}

		if (!isset(CurrentLib::$permission[$roomId]['Permission'][$key]['value'])) {
			return false;
		}

		return CurrentLib::$permission[$roomId]['Permission'][$key]['value'];
	}

}
