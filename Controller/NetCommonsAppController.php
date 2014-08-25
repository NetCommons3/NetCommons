<?php

App::uses('AppController', 'Controller');
App::uses('RoomPart', 'Rooms.Model');

class NetCommonsAppController extends AppController {

/**
 *  langId of the default
 *
 * @var int
 */
	const DEFAULT_LANGID = 2;

/**
 * changeable part
 *
 * @var int
 */
	const IS_CHANGEABLE = 2;

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementPartSetting',
		'Announcements.AnnouncementSetting',
		'Rooms.RoomPart',
		'Rooms.PartsRoomsUser',
		'Frames.Frame',
		'LanguagesPart',
		'Language'
	);

/**
 *  Content Preparation
 *
 * @param int $frameId frames.id
 * @param string $lang language
 * @return bool
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	protected function _contentPreparation($frameId, $lang = '') {
		//language id
		$this->langId = $this->_getLangId($lang);

		//get frames recode
		$frame = $frame = $this->Frame->findById($frameId);
		//default
		$this->set('frameId', 0);
		$this->set('blockId', 0);
		$this->set('roomId', 0);
		$this->set('roomId', 0);
		$this->set('publishRoomAdminOnly', true);
		$this->set('isRoomAdmin', false);
		//block
		$this->set('blockCreateable', false);
		$this->set('blockEditable', false);
		$this->set('blockPublishable', false);
		$this->set('blockReadable', false);
		//content
		$this->set('contentCreateable', false);
		$this->set('contentEditable', false);
		$this->set('contentPublishable ', false);
		$this->set('contentReadable', false);
		//frames recode
		if (! $frame) {
			return false;
		}
		if ($frame &&
			isset($frame[$this->Frame->name]['id']) &&
			isset($frame[$this->Frame->name]['room_id'])) {
			$frame = $frame[$this->Frame->name];
			$this->set('frameId', $frame['id']);
			$this->set('blockId', $frame['block_id']);
			$this->set('roomId', $frame['room_id']);

			//part list
			$partList = $this->LanguagesPart->find('all',
				array('conditions' => array(
					$this->LanguagesPart->name . '.language_id' => $this->langId
				)));
			$this->set('partList', $partList);

			//roomに所属していない
			if (! CakeSession::read('Auth.User.id') &&
				! isset($frame['room_id'])
			) {
				return true;
			}
			$this->RoomPart;
			$userPart = $this->PartsRoomsUser->getPart($frame['room_id']);
			if (isset($userPart[$this->RoomPart->name]['part_id']) &&
				(int)$userPart[$this->RoomPart->name]['part_id'] === RoomPart::ROOM_ADMIN_PART_ID
			) {
				$this->set('isRoomAdmin', true);
			}
			$array = array(
				'blockCreateable' => 'create_block',
				'blockEditable' => 'edit_block',
				'blockPublishable' => 'publish_block',
				'blockCreateable' => 'create_block',
				'contentCreateable' => 'create_content',
				'contentEditable' => 'edit_content',
				'contentPublishable' => 'publish_content',
				'contentCreateable' => 'create_content',
			);

			foreach ($array as $setName => $colName) {
				//block
				if (isset($userPart[$this->RoomPart->name][$colName]) &&
					(int)$userPart[$this->RoomPart->name][$colName] === RoomPart::IS_ALLOW
				) {
					$this->set($setName, true);
				}
			}
			$this->set('userPart', $userPart);
			return true;
		}
		return false;
	}

/**
 * get langId
 *
 * @param string $lang lang code
 * @return int
 */
	protected function _getLangId($lang = '') {
		$rtn = $this->Language->findByCode($lang);
		if (isset($rtn[$this->Language->name]['id']) &&
			$rtn[$this->Language->name]['id']) {
			return $rtn[$this->Language->name]['id'];
		}
		return self::DEFAULT_LANGID;
	}

/**
 * ajax message output
 *
 * @param int $code status code
 * @param string $message message
 * @param array $data updated content data
 * @return CakeResponse
 */
	protected function _ajaxMessage($code, $message, $data = '') {
		$this->viewClass = 'Json';
		$this->layout = false;
		$this->view = null;
		//post以外の場合、エラー
		$this->response->statusCode($code);
		$result = array(
			'message' => $message,
			'data' => $data
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();
	}
}
