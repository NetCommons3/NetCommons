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
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * NetCommonsの機能に必要な情報(ブロック)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property Language $Language Languageモデル
 * @property Block $Block Pluginモデル
 * @property BlocksLanguage $BlocksLanguage BlocksLanguageモデル
 * @property BlockRolePermission $BlockRolePermission BlockRolePermissionモデル
 * @property BlockSetting $BlockSetting BlockSettingモデル
 *
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibRoom $CurrentLibRoom CurrentLibRoomライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibBlock extends LibAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'Language' => 'M17n.Language',
		'Block',
		'BlocksLanguage',
		'BlockRolePermission',
		'BlockSetting',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
		'CurrentLibRoom' => 'NetCommons.Lib/Current',
	];

/**
 * 一度取得したブロックデータを保持
 *
 * @var array
 */
	private $__blocks = [];

/**
 * 一度取得したルーム権限パーミッション(block_settingからblock_permissionのフォーマットに変換)データを保持
 *
 * @var array
 */
	private $__rolePermFromSetting = [];

/**
 * 一度取得したルーム権限パーミッション(block_role_permissions)データを保持
 *
 * @var array|null
 */
	private $__rolePermissions = null;

/**
 * インスタンスの取得
 *
 * @return CurrentLibFrame
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
	}

/**
 * ブロックIDの取得
 *
 * @return string|null ブロックID(intの文字列)。nullの場合、パラメータ等からblock_idが取得できなかった
 */
	public function getCurrentBlockId() {
		if (empty($this->_controller->request->params['requested']) &&
				!empty($this->_controller->request->data['Block']['id'])) {
			$blockId = $this->_controller->request->data['Block']['id'];
		} elseif (isset($this->_controller->request->params['block_id'])) {
			$blockId = $this->_controller->request->params['block_id'];
		} else {
			$blockId = null;
		}
		return $blockId;
	}

/**
 * ページブロックキーの取得
 *
 * @return array
 */
	public function getBlockKeysInCurrentPage() {
		$blockKeys = [];
		foreach ($this->__blocks as $block) {
			$blockKeys[] = $block['Block']['key'];
		}
		return array_unique($blockKeys);
	}

/**
 * リクエストパラメータにブロックIDがあるか
 *
 * @return bool
 */
	public function isBlockIdInRequest() {
		return empty($this->_controller->request->params['requested']) &&
					!empty($this->_controller->request->data['Block']['id']) ||
				!empty($this->_controller->request->params['block_id']);
	}

/**
 * ブロックデータを取得するカラムの取得
 *
 * CurrentLibFrameで使用する
 *
 * @return array
 */
	public function getFindFields() {
		return $this->__getFields();
	}

/**
 * ブロックデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __getFields() {
		$fields = [
			'Block.id',
			'Block.room_id',
			'Block.plugin_key',
			'Block.key',
			'Block.public_type',
			'Block.publish_start',
			'Block.publish_end',
			'Block.content_count',
			'BlocksLanguage.language_id',
			'BlocksLanguage.block_id',
			'BlocksLanguage.name',
			'BlocksLanguage.is_origin',
			'BlocksLanguage.is_translation',
			'BlocksLanguage.is_original_copy',
		];
		return $fields;
	}

/**
 * 多言語のフレーム取得のためのjoinsを生成する
 *
 * @return array
 */
	private function __makeJoinsByMultipleLang() {
		$joins = [
			[
				'type' => 'LEFT',
				'table' => $this->BlocksLanguage->table,
				'alias' => $this->BlocksLanguage->alias,
				'conditions' => [
					'BlocksLanguage.block_id = Block.id',
					'OR' => [
						'BlocksLanguage.is_translation' => false,
						'BlocksLanguage.language_id' => $this->__langId,
					],
				],
			],
		];

		return $joins;
	}

/**
 * 単一言語のフレーム取得のためのjoinsを生成する
 *
 * @return array
 */
	private function __makeJoinsBySingleLang() {
		$joins = [
			[
				'type' => 'LEFT',
				'table' => $this->BlocksLanguage->table,
				'alias' => $this->BlocksLanguage->alias,
				'conditions' => [
					'BlocksLanguage.block_id = Block.id',
					'BlocksLanguage.language_id' => $this->__langId,
				],
			],
		];

		return $joins;
	}

/**
 * ブロックデータを取得
 *
 * @param string|int $blockId ブロックID
 * @return array
 */
	public function findBlockById($blockId) {
		if (isset($this->__blocks[$blockId])) {
			return $this->__blocks[$blockId];
		}

		$fields = $this->__getFields();
		if ($this->Language->isMultipleLang()) {
			$joins = $this->__makeJoinsByMultipleLang();
		} else {
			$joins = $this->__makeJoinsBySingleLang();
		}

		$block = $this->Block->find('first', [
			'recursive' => -1,
			'fields' => $fields,
			'joins' => $joins,
			'conditions' => [
				'Block.id' => $blockId,
			],
			'callbacks' => false,
		]);

		$this->setBlock($blockId, $block);
		return $block;
	}

/**
 * ブロックデータを変数にセットする
 *
 * CurrentLibFrameで使用するため、publicメソッド化
 *
 * @param string|int $blockId ブロックID
 * @param array $block ブロックデータ
 * @return void
 */
	public function setBlock($blockId, $block) {
		if ($block) {
			$this->__blocks[$blockId] = [
				'Block' => $block['Block'],
				'BlocksLanguage' => $block['BlocksLanguage']
			];
		} else {
			$this->__blocks[$blockId] = [
				'Block' => null,
				'BlocksLanguage' => null
			];
		}
	}

/**
 * ブロックキーからブロックロールパーミッションのデータを取得
 *
 * @param string|int $roomId ルームID
 * @param string $blockKey ブロックキー
 * @return array
 * @throws InternalErrorException
 */
	public function findBlockRolePermissionsByBlockKey($roomId, $blockKey) {
		if (isset($this->__rolePermissions[$blockKey])) {
			return $this->__rolePermissions[$blockKey];
		}

		$results = $this->BlockRolePermission->find('all', [
			'recursive' => -1,
			'fields' => [
				'id', 'roles_room_id', 'block_key', 'permission', 'value'
			],
			'conditions' => [
				'block_key' => $blockKey,
				'roles_room_id' => $this->CurrentLibRoom->getRoleRoomIdByRoomId($roomId),
			],
			'callbacks' => false,
		]);

		$this->__rolePermissions[$blockKey] = [];
		foreach ($results as $permission) {
			$blockKey = $permission['BlockRolePermission']['block_key'];
			$key = $permission['BlockRolePermission']['permission'];
			$this->__rolePermissions[$blockKey][$key] = $permission['BlockRolePermission'];
		}

		// content_publishable は BlockRolePermission から無くなったが、あった場合throw Exception しとく
		// アップデート時にMigrationで削除するのでありえない。
		// unsetして継続させた方が良いのか？アップデート時は管理者で操作するので問題なし。
		// アップデート時に、ファイル上書きして、プラグイン管理のアップデートを実行するまでの間あり得る
		if (isset($this->__rolePermissions[$blockKey]['content_publishable'])) {
			throw new InternalErrorException('BlockRolePermission.content_publishable exists');
		}

		return $this->__rolePermissions[$blockKey];
	}

/**
 * ブロックキーからブロックロールパーミッションのデータをローカル変数にセットする
 *
 * @param string|int $roomId ルームID
 * @param array $blockKeys ブロックキーリスト
 * @return void
 * @throws InternalErrorException
 */
	public function setBlockRolePermissions($roomId, $blockKeys) {
		$results = $this->BlockRolePermission->find('all', [
			'recursive' => -1,
			'fields' => [
				'id', 'roles_room_id', 'block_key', 'permission', 'value'
			],
			'conditions' => [
				'block_key' => $blockKeys,
				'roles_room_id' => $this->CurrentLibRoom->getRoleRoomIdByRoomId($roomId)
			],
			'callbacks' => false,
		]);

		//変数の初期化
		foreach ($blockKeys as $blockKey) {
			$this->__rolePermissions[$blockKey] = [];
		}

		foreach ($results as $permission) {
			$blockKey = $permission['BlockRolePermission']['block_key'];
			$key = $permission['BlockRolePermission']['permission'];
			$this->__rolePermissions[$blockKey][$key] = $permission['BlockRolePermission'];

			// content_publishable は BlockRolePermission から無くなったが、あった場合throw Exception しとく
			// アップデート時にMigrationで削除するのでありえない。
			// unsetして継続させた方が良いのか？アップデート時は管理者で操作するので問題なし。
			// アップデート時に、ファイル上書きして、プラグイン管理のアップデートを実行するまでの間あり得る
			if (isset($this->__rolePermissions[$blockKey]['content_publishable'])) {
				throw new InternalErrorException('BlockRolePermission.content_publishable exists');
			}
		}
	}

/**
 * ブロックキーからブロック設定データからワークフローの有無を取得
 *
 * ・承認ありのルームの場合、BlockSettingの承認有無は使用せずに、room_role_permissionsを使用する。
 * ・承認なしのルームの場合、BlockSettingにデータは、承認なしのデータとする。
 * 　ただし、実際に利用するpermissionのデータは、room_role_permissionsの設定値を利用する。
 * 　逆にBlockSettingにデータがない場合、承認ありとする(元のソースktera)。
 *
 * @param string|int $roomId ルームID
 * @param string $blockKey ブロックキー
 * @return array
 */
	public function findUseWorkflowPermissionsByBlockKey($roomId, $blockKey) {
		$room = $this->CurrentLibRoom->findRoomById($roomId);
		if (! $room ||
				$room['Room']['need_approval']) {
			return [];
		}

		if (! $blockKey) {
			$permissions = [];
			$permissions['content_publishable']['value'] = true;
			$permissions['content_comment_publishable']['value'] = true;
			return $permissions;
		}

		if (isset($this->__rolePermFromSetting[$blockKey])) {
			return $this->__rolePermFromSetting[$blockKey];
		}

		$results = $this->BlockSetting->find('all', array(
			'recursive' => -1,
			'fields' => array('field_name', 'value'),
			'conditions' => array(
				'room_id' => $roomId,
				'block_key' => $blockKey,
				'field_name' => array(
					BlockSettingBehavior::FIELD_USE_WORKFLOW,
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL
				),
			),
			'callbacks' => false,
		));

		$blockSettings = [];
		foreach ($results as $result) {
			$key = $result['BlockSetting']['field_name'];
			$value = $result['BlockSetting']['value'];
			$blockSettings[$key] = $value;
		}
		$this->__setUseWorkflowPermission($blockKey, $blockSettings);

		return $this->__rolePermissions[$blockKey];
	}

/**
 * ブロック設定データのワークフローの有無をローカル変数にセットする
 *
 * @param string|int $roomId ルームID
 * @param array $blockKeys ブロックキーリスト
 * @return array
 */
	public function setUseWorkflowPermissions($roomId, $blockKeys) {
		$results = $this->BlockSetting->find('all', array(
			'recursive' => -1,
			'fields' => array('block_key', 'field_name', 'value'),
			'conditions' => array(
				'room_id' => $roomId,
				'block_key' => $blockKeys,
				'field_name' => array(
					BlockSettingBehavior::FIELD_USE_WORKFLOW,
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL
				),
			),
			'callbacks' => false,
		));
		$blockSettings = [];
		foreach ($results as $result) {
			$blockKey = $result['BlockSetting']['block_key'];
			$key = $result['BlockSetting']['field_name'];
			$value = $result['BlockSetting']['value'];
			$blockSettings[$blockKey][$key] = $value;
		}

		foreach ($blockKeys as $blockKey) {
			if (isset($blockSettings[$blockKey])) {
				$this->__setUseWorkflowPermission($blockKey, $blockSettings[$blockKey]);
			} else {
				$this->__setUseWorkflowPermission($blockKey, []);
			}
		}
	}

/**
 * ブロック設定データのワークフローの有無をローカル変数をセットする
 *
 * @param string $blockKey ブロックキー
 * @param array $blockSettings ブロック設定データリスト
 * @return array
 */
	private function __setUseWorkflowPermission($blockKey, $blockSettings) {
		if (!$blockSettings) {
			$this->__rolePermFromSetting[$blockKey]['content_publishable']['value'] = true;
			$this->__rolePermFromSetting[$blockKey]['content_comment_publishable']['value'] = true;
		} else {
			$this->__rolePermissions[$blockKey] = [];
			if (empty($blockSettings[BlockSettingBehavior::FIELD_USE_WORKFLOW])) {
				$this->__rolePermFromSetting[$blockKey]['content_publishable']['value'] = true;
			}
			if (empty($blockSettings[BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL])) {
				$this->__rolePermFromSetting[$blockKey]['content_comment_publishable']['value'] = true;
			}
		}
	}

}
