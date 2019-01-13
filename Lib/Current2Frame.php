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

App::uses('CurrentAppObject', 'NetCommons.Lib');

/**
 * NetCommonsの機能に必要な情報(フレーム)を取得する内容をまとめたUtility
 *
 * @property string $_lang 言語ID
 * @property Controller $_controller コントローラ
 * @property Language $Language Languageモデル
 * @property Frame $Frame Frameモデル
 * @property FramePublicLanguage $FramePublicLanguage FramePublicLanguageモデル
 * @property FramesLanguage $FramesLanguage FramesLanguageモデル
 * @property Block $Block Pluginモデル
 * @property BlocksLanguage $BlocksLanguage BlocksLanguageモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class Current2Frame extends CurrentAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'Frame' => 'Frames.Frame',
		'FramePublicLanguage' => 'Frames.FramePublicLanguage',
		'FramesLanguage' => 'Frames.FramesLanguage',
		'Block' => 'Blocks.Block',
		'BlocksLanguage' => 'Blocks.Frame',
	];

/**
 * インスタンスの取得
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentSystem
 */
	public static function getInstance($controller = null) {
		return parent::_getInstance($controller, __CLASS__);
	}

/**
 * フレームデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __makeFields() {
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
			'FramePublicLanguagelanguage_id',
			'FramePublicLanguageframe_id',
			'FramePublicLanguageis_public',
			'FramesLanguage.id',
			'FramesLanguage.language_id',
			'FramesLanguage.frame_id',
			'FramesLanguage.name',
			'FramesLanguage.is_origin',
			'FramesLanguage.is_translation',
			'FramesLanguage.is_original_copy',
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
	private function __makeJoinsCommon() {
		$joins = [
			[
				'type' => 'LEFT',
				'table' => $this->Block->table,
				'alias' => $this->Block->alias,
				'conditions' => [
					'Frame.block_id' . ' = ' . 'Block.id',
				],
			],
		];

		return $joins;
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
					'FramePublicLanguage.language_id' => ['0', $this->_langId],
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
						'FramesLanguage.language_id' => $this->_langId,
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
						'BlocksLanguage.language_id' => $this->_langId,
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
					'FramePublicLanguage.language_id' => ['0', $this->_langId],
					'FramePublicLanguage.is_public' => true,
				],
			],
			[
				'type' => 'INNER',
				'table' => $this->FramesLanguage->table,
				'alias' => $this->FramesLanguage->alias,
				'conditions' => [
					'FramesLanguage.frame_id = Frame.id',
					'FramesLanguage.language_id' => $this->_langId,
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
					'BlocksLanguage.language_id' => $this->_langId,
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
		$fields = $this->__makeFields();
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
				'Frame.is_deleted' => false,
				'Frame.box_id' => $boxIds,
			],
			'order' => [
				'Frame.weight'
			],
		]);

		$results = [];
		foreach ($frames as $frame) {
			$boxId = $frame['Frame']['box_id'];
			$frameId = $frame['Frame']['id'];
			//$frame = array_merge($frame, $frame['FramesLanguage'], $frame['Frame']);
			$results[$boxId][$frameId] = $frame;
		}

		return $results;
	}

}
