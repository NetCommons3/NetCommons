<?php
/**
 * PartsRoomsUser Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for PartsRoomsUser Model
 */
class NetCommonsPartsRoomsUser extends NetCommonsAppModel {

/**
 * テーブルの指定
 *
 * @var bool
 */
	public $useTable = 'parts_rooms_users';

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
 * useridから、ルーム内のパートの情報を取得する。
 *
 * @param int $roomId rooms.id
 * @param int $userId users.id
 * @return array
 */
	public function getRoomPart($roomId, $userId) {
		//どちらかがないなら、
		if (! $roomId || !$userId) {
			return array();
		}
		$rtn = $this->find('first', array(
				'joins' => array(
					array(
						'type' => 'LEFT',
						'table' => 'room_parts',
						'alias' => 'RoomPart',
						'conditions' => array(
							'RoomPart.part_id=' . $this->name . '.part_id'
						)
					)
				),
				'conditions' => array(
					$this->name . '.room_id' => $roomId,
					'and' => array(
						$this->name . '.user_id' => $userId
					)
				),
				'fields' => array(
					$this->name . '.*',
					'RoomPart.*'
				)
			)
		);
		return $rtn;
	}
}
