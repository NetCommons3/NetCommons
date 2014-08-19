<?php
/**
 * NetCommons Plugin Component
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Component', 'Controller');


class NetCommonsPluginComponent extends Component {

/**
 * room admin's parts.id
 *
 * @var int
 */
	const ROOM_ADMIN_PART_ID = 1;

/**
 * room admin
 *
 * @var bool
 */
	public $isRoomAdmin = false;

/**
 * setting mode flag
 *
 * @var bool
 */
	public $isSetting = false;

/**
 * frames id
 *
 * @var int
 */
	public $frameId = 0;

/**
 * blocks id
 *
 * @var bool
 */
	public $blockId = 0;

/**
 * users id
 *
 * @var int
 */
	public $userId = 0;

/**
 * rooms id
 *
 * @var int
 */
	public $roomId = 0;

/**
 * block edit flag
 *
 * @var bool
 */
	public $isBlockEdit = false;

/**
 * block create flag
 *
 * @var bool
 */
	public $isBlockCreate = false;

/**
 * publish is need the permission of the room admin.
 *
 * @var bool
 */
	public $isNeedApproval = false;

/**
 * frames id set
 *
 * @param Controller $controller controller object
 * @param int $frameId frames.id
 * @return array
 */
	public function setFrameId(Controller $controller, $frameId) {
		//初期設定
		$controller->set('frameId', $this->frameId);
		$controller->set('roomId', $this->roomId);
		$controller->set('blockId', $this->blockId);
		$controller->set('isNeedApproval', $this->isNeedApproval);
		$controller->set('blockId', $this->blockId);

		//userId取得
		$this->getUserId($controller);

		//frameの情報を取得する
		$frame = $controller->NetCommonsFrame->findById($frameId);
		//frameの情報から、諸々設定値を書く王する。
		if ($frame && isset($frame[$controller->NetCommonsFrame->name]['id'])) {
			//frames.id
			$this->frameId = $frame[$controller->NetCommonsFrame->name]['id'];
			$controller->set('frameId', $this->frameId);
			//rooms.id
			$this->roomId = $frame[$controller->NetCommonsFrame->name]['room_id'];
			$controller->set('roomId', $this->roomId);
			//blocks.id
			$this->blockId = $frame[$controller->NetCommonsFrame->name]['block_id'];
			$controller->set('blockId', $this->blockId);

			//need approval flag
			$this->isNeedApproval = $controller->NetCommonsRoom->checkApproval($this->roomId);
			$controller->set('isNeedApproval', $this->isNeedApproval);

			//rooms part for login user
			$roomPart = $controller->NetCommonsPartsRoomsUser->getRoomPart($this->roomId, $this->userId);
			$this->checkRoomAdmin($controller, $roomPart);

			$columnName = 'edit_block';
			$approval = 'isBlockEdit';
			$this->checkApproval($controller, $roomPart, $columnName, $approval);

			$columnName = 'create_block';
			$approval = 'isBlockCreate';
			$this->checkApproval($controller, $roomPart, $columnName, $approval);
		}
		return $frame;
	}

/**
 * set userId
 *
 * @param Controller $controller controller object
 * @return int
 */
	public function getUserId(Controller $controller) {
		$controller->Set('isLogin', false);
		if ($controller->Auth->loggedIn()) {
			$this->userId = $controller->Auth->user('id');
			$controller->Set('isLogin', true);
		}
		return $this->userId;
	}

/**
 * check room admin
 *
 * @param Controller $controller controller object
 * @param array $roomPart room_parts recode
 * @return bool
 */
	public function checkRoomAdmin(Controller $controller, $roomPart) {
		if (isset($roomPart['RoomPart'])
			&& $roomPart['RoomPart']['part_id'] == self::ROOM_ADMIN_PART_ID
		) {
			//権限無し
			$this->isRoomAdmin = true;
			$controller->set('isRoomAdmin', $this->isRoomAdmin);
			return true;
		}
		return false;
	}

/**
 * check approval
 *
 * @param Controller $controller controller object
 * @param array $roomPart room_parts recode
 * @param string $columnName table col
 * @param string $approval sets name
 * @return bool
 */
	public function checkApproval(Controller $controller, $roomPart, $columnName, $approval) {
		//allow approval
		$approvalAllow = array(
			'isBlockEdit',
			'isBlockCreate'
		);

		//param error
		if (! $approval
			|| ! $roomPart
			|| ! $columnName
			|| ! in_array($approval, $approvalAllow)
			|| ! $this->frameId
		) {
			return false;
		}

		$this->$approval = false;
		if (isset($roomPart['RoomPart'][$columnName]) && $roomPart['RoomPart'][$columnName]) {
			$this->$approval = true;
		}
		//set
		$controller->set($approval, $this->$approval);
		return $this->$approval;
	}
}
