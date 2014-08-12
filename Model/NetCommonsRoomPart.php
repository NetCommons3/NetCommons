<?php
/**
 * AnnouncementRoomPart Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

class NetCommonsRoomPart extends NetCommonsAppModel {

/**
 * テーブルの指定
 * @var bool
 */
	public $useTable = 'room_parts';

/**
 * name
 *
 * @var string
 */
	public $name = "NetCommonsRoomPart";

/**
 * language id デェフォルト値
 *
 * @var int
 */
	public $languageId = 2;

/**
 * __construct
 *
 * @param bool $id id
 * @param null $table db table
 * @param null $ds connection
 * @return void
 * @SuppressWarnings(PHPMD)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * パート一覧
 *
 * @param int $langId languages.id
 * @return array
 */
	public function getList($langId = 2) {
		return $this->find('all', array(
			'joins' => array(
				array(
					'type' => 'LEFT',
					'table' => 'languages_parts',
					'alias' => 'LanguagesPart',
					'conditions' => array(
						'LanguagesPart.part_id=NetCommonsRoomPart.part_id',
						'LanguagesPart.language_id=' . $langId //言語id
						)
					)
				),
				'fields' => array(
					'NetCommonsRoomPart.*',
					'LanguagesPart.name'
				),
				'order' => array('NetCommonsRoomPart.weight ASC')
			)
		);
	}

/**
 * 変更可能な権限のpartを取得する
 *
 * @param string $abilityName edit_content or publish_content
 * @return array
 */
	public function getVariableList($abilityName) {
		if (! $abilityName) {
			return array();
		}
		if ($abilityName != 'publish_content') {
			return $this->find('all', array(
					'conditions' => array(
						$this->name . "." . $abilityName => 2
					)
				)
			);
		}
		//公開権限の場合 編集権限がなければ変更不可とします。
		return $this->find('all', array(
				'conditions' => array(
					$this->name . ".publish_content" => 2,
					'and' => array(
						'or' => array($this->name . ".edit_content" => 1,
						'or' => array($this->name . ".edit_content" => 2)
						)
					)
				)
			)
		);
	}

/**
 * 変更可能な権限のpartのidを返す
 *
 * @param string $abilityName edit_content or publish_content
 * @return array
 */
	public function getVariableListPartIds($abilityName) {
		$list = $this->getVariableList($abilityName);
		$rtn = array();
		foreach ($list as $item) {
			if (isset($item[$this->name])
				&& isset($item[$this->name]['part_id'])
			) {
				$rtn[$item[$this->name]['part_id']] = $item[$this->name]['part_id'];
			}
		}
		return $rtn;
	}

/**
 * plugin block part 設定を作成するためのデェフォルト値の作成
 *
 * @param int $blockId blocks.d
 * @param int $userId users.id ( create_user_id )
 * @return array
 */
	public function getBlockPartConfig($blockId, $userId) {
		$rtn = array();
		$roomPartList = $this->find('all', array(
				'fields' => array(
					'part_id',
					'read_content',
					'edit_content',
					'create_content',
					'publish_content'
				)
			)
		);
		$con = 0;
		// 2:可変の場合はまずは権限無しとして初期値を作る。
		foreach ($roomPartList as $roomPart) {
			foreach ($roomPart[$this->name] as $key => $item) {
				if ($key != 'part_id' && $item == 2) {
					$roomPart[$this->name][$key] = 0;
				}
			}
			$roomPart[$this->name]['block_id'] = $blockId;
			$roomPart[$this->name]['create_user_id'] = $userId;
			$roomPart[$this->name]['modified_user_id'] = $userId;
			$rtn[$con] = $roomPart[$this->name];
			$con++;
		}
		return $rtn;
	}
}
