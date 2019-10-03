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
 * NetCommonsの機能に必要な情報(フレーム)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property Language $Language Languageモデル
 * @property Frame $Frame Frameモデル
 * @property FramePublicLanguage $FramePublicLanguage FramePublicLanguageモデル
 * @property FramesLanguage $FramesLanguage FramesLanguageモデル
 * @property Block $Block Pluginモデル
 * @property BlocksLanguage $BlocksLanguage BlocksLanguageモデル
 *
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibRoom $CurrentLibRoom CurrentLibRoomライブラリ
 * @property CurrentLibPage $CurrentLibPage CurrentLibPageライブラリ
 * @property CurrentLibBlock $CurrentLibBlock CurrentLibBlockライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibFrame extends LibAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'Language' => 'M17n.Language',
		'Frame',
		'FramePublicLanguage',
		'FramesLanguage',
		'Block',
		'BlocksLanguage',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
		'CurrentLibRoom' => 'NetCommons.Lib/Current',
		'CurrentLibPage' => 'NetCommons.Lib/Current',
		'CurrentLibBlock' => 'NetCommons.Lib/Current',
	];

/**
 * 言語IDを保持
 *
 * @var string 数値の文字列
 */
	private $__langId = null;

/**
 * 取得したフレームデータを保持
 *
 * @var array
 */
	private $__frames = [];

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
 * リクエストの中からフレームIDを取得
 *
 * @return int|null フレームID。nullの場合、パラメータ等からframe_idが取得できなかった
 */
	private function __getFrameIdInRequest() {
		if (empty($this->_controller->request->params['requested']) &&
				isset($this->_controller->request->data['Frame']['id'])) {
			$frameId = $this->_controller->request->data['Frame']['id'];
		} elseif (isset($this->_controller->request->params['frame_id'])) {
			$frameId = $this->_controller->request->params['frame_id'];
		} elseif (isset($this->_controller->request->params['?']['frame_id'])) {
			$frameId = $this->_controller->request->params['?']['frame_id'];
		} elseif (isset($this->_controller->request->query['frame_id'])) {
			$frameId = $this->_controller->request->query['frame_id'];
		} else {
			//$frameId = null;
			return null;
		}
		return (int)$frameId;
	}

/**
 * フレームIDの取得
 *
 * @return string|null フレームID。nullの場合、パラメータ等からframe_idが取得できなかった
 */
	public function getCurrentFrameId() {
		$frameId = $this->__getFrameIdInRequest();
		if (! $frameId) {
			return null;
		}
		$frame = $this->findFrameById($frameId);
		if (! $frame) {
			return null;
		}

		if ($frame['Frame']['block_id'] &&
				$this->CurrentLibBlock->isBlockIdInRequest()) {
			$blockId = $this->CurrentLibBlock->getCurrentBlockId();
			$block = $this->CurrentLibBlock->findBlockById($blockId);
			//指定されたブロックとフレームのブロックについて、
			//ルームIDとプラグインキーが同じかチェックする
			if (! $this->isSameRoomAndPluginByRequestBlockAndFrameBlock($frame, $block)) {
				return null;
			}
		}
		return $frame['Frame']['id'];
	}

/**
 * リクエストの中からボックスIDを取得(主にフレーム追加で使用)
 *
 * @return string|null ボックスID。nullの場合、パラメータ等からbox_idが取得できなかった
 */
	public function getBoxIdByFrameInRequest() {
		if (empty($this->_controller->request->params['requested']) &&
				isset($this->_controller->request->data['Frame']['box_id'])) {
			$boxId = $this->_controller->request->data['Frame']['box_id'];
		} else {
			$boxId = null;
		}
		return $boxId;
	}

/**
 * フレームデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __getFields() {
		$fields = [
			'Frame.id',
			'Frame.room_id',
			'Frame.box_id',
			'Frame.plugin_key',
			'Frame.block_id',
			'Frame.key',
			'Frame.header_type',
			'Frame.weight',
			'Frame.is_deleted',
			'Frame.default_action',
			'Frame.default_setting_action',
			'FramePublicLanguage.id',
			'FramePublicLanguage.language_id',
			'FramePublicLanguage.frame_id',
			'FramePublicLanguage.is_public',
			'FramesLanguage.id',
			'FramesLanguage.language_id',
			'FramesLanguage.frame_id',
			'FramesLanguage.name',
			'FramesLanguage.is_origin',
			'FramesLanguage.is_translation',
			'FramesLanguage.is_original_copy',
		];

		return array_merge($fields, $this->CurrentLibBlock->getFindFields());
	}

/**
 * 多言語のフレーム取得のためのjoinsを生成する
 *
 * @return array
 */
	private function __makeJoinsByMultipleLang() {
		$joins = [
			[
				'type' => 'INNER',
				'table' => $this->FramePublicLanguage->table,
				'alias' => $this->FramePublicLanguage->alias,
				'conditions' => [
					'FramePublicLanguage.frame_id' . ' = ' . 'Frame.id',
					'FramePublicLanguage.language_id' => ['0', $this->__langId],
					'FramePublicLanguage.is_public' => true,
				],
			],
			[
				'type' => 'INNER',
				'table' => $this->FramesLanguage->table,
				'alias' => $this->FramesLanguage->alias,
				'conditions' => [
					'FramesLanguage.frame_id = Frame.id',
					'OR' => [
						'FramesLanguage.is_translation' => false,
						'FramesLanguage.language_id' => $this->__langId,
					]
				],
			],
			[
				'type' => 'LEFT',
				'table' => $this->Block->table,
				'alias' => $this->Block->alias,
				'conditions' => [
					'Frame.block_id' . ' = ' . 'Block.id',
				],
			],
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
				'type' => 'INNER',
				'table' => $this->FramePublicLanguage->table,
				'alias' => $this->FramePublicLanguage->alias,
				'conditions' => [
					'FramePublicLanguage.frame_id = Frame.id',
					'FramePublicLanguage.language_id' => ['0', $this->__langId],
					'FramePublicLanguage.is_public' => true,
				],
			],
			[
				'type' => 'INNER',
				'table' => $this->FramesLanguage->table,
				'alias' => $this->FramesLanguage->alias,
				'conditions' => [
					'FramesLanguage.frame_id = Frame.id',
					'FramesLanguage.language_id' => $this->__langId,
				],
			],
			[
				'type' => 'LEFT',
				'table' => $this->Block->table,
				'alias' => $this->Block->alias,
				'conditions' => [
					'Frame.block_id = Block.id',
				],
			],
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
 * フレームデータを取得
 *
 * @param array $boxIds ボックスIDリスト
 * @return array
 */
	public function findFramesByBoxIds($boxIds) {
		$fields = $this->__getFields();
		if ($this->Language->isMultipleLang()) {
			$joins = $this->__makeJoinsByMultipleLang();
		} else {
			$joins = $this->__makeJoinsBySingleLang();
		}

		$frames = $this->Frame->find('all', [
			'recursive' => -1,
			'fields' => $fields,
			'joins' => $joins,
			'conditions' => [
				'Frame.box_id' => $boxIds,
				'Frame.is_deleted' => false,
			],
			'order' => [
				'Frame.box_id',
				'Frame.is_deleted',
				'Frame.weight'
			],
			'callbacks' => false,
		]);

		$results = [];
		$roomIds = [];
		foreach ($frames as $frame) {
			$boxId = $frame['Frame']['box_id'];
			$frameId = $frame['Frame']['id'];

			$this->__frames[$frameId] = $frame;

			$frame = array_merge($frame['FramesLanguage'], $frame['Frame'], $frame);
			$results[$boxId][$frameId] = $frame;

			$roomIds[] = $frame['Frame']['room_id'];
			$this->CurrentLibBlock->setBlock($frame['Frame']['block_id'], $frame);
		}

		//CurrentLibRoomにデータを保持する。再取得させないため。
		$this->CurrentLibRoom->findRoomsByIds($roomIds);

		return $results;
	}

/**
 * フレームデータを取得
 *
 * @param string|int $frameId フレームID
 * @return array
 */
	public function findFrameById($frameId) {
		if (isset($this->__frames[$frameId])) {
			return $this->__frames[$frameId];
		} else {
			$fields = $this->__getFields();
			if ($this->Language->isMultipleLang()) {
				$joins = $this->__makeJoinsByMultipleLang();
			} else {
				$joins = $this->__makeJoinsBySingleLang();
			}
			$frame = $this->Frame->find('first', [
				'recursive' => -1,
				'fields' => $fields,
				'joins' => $joins,
				'conditions' => [
					'Frame.id' => $frameId,
				],
				'callbacks' => false,
			]);
			$this->__frames[$frameId] = $frame;
			if (!empty($frame['Frame']['block_id'])) {
				$this->CurrentLibBlock->setBlock($frame['Frame']['block_id'], $frame);
			}

			return $frame;
		}
	}

/**
 * フレームデータの中にBlockをセットする
 *
 * @param string|int $frameId フレームID
 * @param array $block ブロックデータ
 * @return void
 */
	public function setBlockInFrame($frameId, $block) {
		$this->__frames[$frameId]['Frame']['block_id'] = $block['Block']['id'];
		$this->__frames[$frameId]['Block'] = $block['Block'];
		$this->__frames[$frameId]['BlocksLanguage'] = $block['BlocksLanguage'];
	}

/**
 * リクエストのBlockとFrameのBlockが同じプラグインと同じルームかどうかチェックする。
 *
 * @param array $frame フレームデータ
 * @param array $block ブロックデータ
 * @return bool
 */
	public function isSameRoomAndPluginByRequestBlockAndFrameBlock($frame, $block) {
		if (isset($block['Block']['room_id']) &&
				($block['Block']['room_id'] !== $frame['Frame']['room_id'] ||
				$block['Block']['plugin_key'] !== $frame['Frame']['plugin_key'])) {
			return false;
		} else {
			return true;
		}
	}

/**
 * リクエストのBlockとFrameのBlockが同じかどうかチェックする
 *
 * @param array $frame フレームデータ
 * @param array $block ブロックデータ
 * @return bool
 */
	public function isSameBlockByRequestBlockAndFrameBlock($frame, $block) {
		if (isset($block['Block']['id']) &&
					$block['Block']['id'] !== $frame['Frame']['block_id']) {
			return false;
		} else {
			return true;
		}
	}

}
