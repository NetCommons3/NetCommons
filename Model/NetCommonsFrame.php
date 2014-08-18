<?php
/**
 * AnnouncementFrame Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');
App::uses('NetCommonsBlock', 'NetCommons.Model');
App::uses('NetCommonsRoom', 'NetCommons.Model');

class NetCommonsFrame extends AppModel {

/**
 * テーブルの指定
 *
 * @var bool
 */
	public $useTable = 'frames';

/**
 * Blocks model object
 *
 * @var null
 */
	private $__Block = null;

/**
 * Room model object
 *
 * @var null
 */
	private $__Room = null;

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
 * BlockIdが設定されているかどうか確認する。
 *
 * @param int $frameId frames.id
 * @return int blocks.id
 */
	public function getBlockId($frameId) {
		$frame = $this->findById($frameId);
		if ($frame
			&& isset($frame[$this->name])
			&& isset($frame[$this->name]['block_id'])
			&& $frame[$this->name]['block_id']) {
			return $frame[$this->name]['block_id'];
		}
		return null;
	}

/**
 * blockの作成
 *
 * @param int $flameId frames.id
 * @param int $userId  users.id
 * @return mix array or null
 */
	public function createBlock($flameId, $userId) {
		if (! $frame = $this->findById($flameId)) {
			return null;
		}
		//Block class object
		$this->__setModel();
		// data set
		$data = array();
		$data[$this->__Block->name]['room_id'] = $frame[$this->name]['room_id'];
		$data[$this->__Block->name]['created_user_id'] = $userId;
		$block = $this->__Block->save($data);
		return $block;
	}

/**
 * blockIdの更新
 *
 * @param int $flameId frames.id
 * @param int $blockId blocks.id
 * @param int $userId users.id
 * @return array
 */
	public function updateBlockId($flameId, $blockId, $userId) {
		$flame[$this->name]['id'] = $flameId;
		$flame[$this->name]['block_id'] = $blockId;
		$flame[$this->name]['modified_user_id'] = $userId;
		return $this->save($flame);
	}

/**
 * ルーム管理者の承認が必要かどうかの確認
 *
 * @param int $frameId flames.id
 * @return bool
 * @SuppressWarnings(PHPMD)
 */
	public function getRoomApproval($frameId) {
		//$frame = $this->findById($frameId);
		//$frame[$this->name]['room_id'];
		return true;
	}

/**
 * Model Object set.
 *
 * @return void
 */
	private function __setModel() {
		if (! $this->__Block) {
			$this->__Block = Classregistry::init("NetCommons.NetCommonsBlock");
		}
		if (! $this->__Room) {
			$this->__Room = Classregistry::init("NetCommons.NetCommonsRoom");
		}
	}
}