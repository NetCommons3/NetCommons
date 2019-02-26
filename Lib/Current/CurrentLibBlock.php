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
		'Block' => 'Blocks.Block',
		'BlocksLanguage' => 'Blocks.Frame',
		'BlockRolePermission' => 'Blocks.BlockRolePermission',
		'BlockSetting' => 'Blocks.BlockSetting',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
//		'CurrentLibPage' => 'NetCommons.Lib/Current',
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
 * リクエストパラメータにブロックIDがあるか
 *
 * @return bool
 */
	public function isBlockIdInRequest() {
		return empty($this->_controller->request->params['requested']) &&
					!empty($this->_controller->request->data['Block']['id']) ||
				isset($this->_controller->request->params['block_id']);
	}

/**
 * ブロックデータを取得するカラムの取得
 *
 * CurrentLibFrameで使用する
 *
 * @return array
 */
	public function getFindFields() {
		return $this->__makeFields();
	}

/**
 * ブロックデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __makeFields() {
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

		$fields = $this->__makeFields();
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
		$this->__blocks[$blockId] = [
			'Block' => $block['Block'],
			'BlocksLanguage' => $block['BlocksLanguage']
		];
	}

/**
 * ブロックキーからブロックロールパーミッションのデータを取得
 *
 * @param string $blockKey ブロックキー
 * @return array
 */
	public function findBlockRolePermissionsByBlockKey($blockKey) {
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
			]
		]);
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
 * ブロックキーからブロック設定データからワークフローの有無を取得
 *
 * 承認ありのルームの場合、BlockSettingの承認有無は使用せずに、room_role_permissionsを使用する。
 * 承認なしのルームの場合、BlockSettingにあれば、room_role_permissionsの設定値を使用する。
 * 承認なしのルームのデフォルト値は、承認ありとする。
 *
 * @param string|int $roomId ルームID
 * @param string $blockKey ブロックキー
 * @return array
 */
	public function findUseWorkflowPermissions($roomId, $blockKey) {
		$room = $this->CurrentLibRoom->findRoomById($roomId);
		if ($room['Room']['need_approval']) {
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

		$blockSetting = $this->BlockSetting->find('list', array(
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
		));

		if (!$blockSetting) {
			$this->__rolePermFromSetting[$blockKey]['content_publishable']['value'] = true;
			$this->__rolePermFromSetting[$blockKey]['content_comment_publishable']['value'] = true;
		} else {
			$this->__rolePermissions[$blockKey] = [];
			if (empty($blockSetting[BlockSettingBehavior::FIELD_USE_WORKFLOW])) {
				$this->__rolePermFromSetting[$blockKey]['content_publishable']['value'] = true;
			}
			if (empty($blockSetting[BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL])) {
				$this->__rolePermFromSetting[$blockKey]['content_comment_publishable']['value'] = true;
			}
		}
		return $this->__rolePermissions[$blockKey];
	}

}
