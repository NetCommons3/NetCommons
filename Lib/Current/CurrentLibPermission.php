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

App::uses('LibAppObject', 'NetCommons.Lib');

/**
 * NetCommonsの機能に必要な情報(パーミッション関連)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property DefaultRolePermission $DefaultRolePermission DefaultRolePermissionモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibPermission extends LibAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'DefaultRolePermission' => 'Roles.DefaultRolePermission',
	];

/**
 * インスタンスの取得
 *
 * @return CurrentPermission
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
 * デフォルトロールデータ取得
 *
 * @param string $roleKey ロールキー
 * @return array
 */
	public function findDefaultRolePermissions($roleKey) {
		$queryOptions = [
			'recursive' => -1,
			'fields' => [
				'id', 'role_key', 'type', 'permission', 'value', 'fixed'
			],
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

}
