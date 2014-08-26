<?php

App::uses('AppController', 'Controller');
App::uses('RoomPart', 'Rooms.Model');

class NetCommonsFrameAppController extends AppController {

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
		'Rooms.RoomPart',
		'Announcements.Announcement',
		'Announcements.AnnouncementPartSetting',
		'Announcements.AnnouncementSetting',
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
 */
	protected function _setFrameInitialize($frameId, $lang = '') {
		$this->__setFrameDefault();

		//language id
		$langId = $this->__getLangId($lang);
		$this->set('langId', $langId);

		//get frames recode
		$frame = $this->Frame->findById($frameId);
		if (! $frame ||
			! isset($frame[$this->Frame->name]['id']) ||
			! isset($frame[$this->Frame->name]['room_id'])) {

			return false;
		}

		$this->set('frameId', $frame[$this->Frame->name]['id']);
		$this->set('blockId', $frame[$this->Frame->name]['block_id']);
		$this->set('roomId', $frame[$this->Frame->name]['room_id']);

		//roomに所属していない
		if (! CakeSession::read('Auth.User.id') && ! $this->viewVars['roomId']) {
			return true;
		}
		//ユーザのルームパートのセット
		$this->__setUserRoomParts();
		return true;
	}

/**
 *  set frame default
 *
 * @return void
 */
	private function __setFrameDefault() {
		//default
		$this->set('frameId', 0);
		$this->set('blockId', 0);
		$this->set('roomId', 0);
		$this->set('langId', self::DEFAULT_LANGID);
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
	}

/**
 * set roomParts
 *
 * @return void
 */
	private function __setUserRoomParts() {
		//part list
		$partList = $this->LanguagesPart->find('all',
			array('conditions' => array(
				$this->LanguagesPart->name . '.language_id' => $this->viewVars['langId']
			)));
		$this->set('partList', $partList);

		$this->RoomPart;
		$userPart = $this->PartsRoomsUser->getPart($this->viewVars['roomId']);
		if (isset($userPart[$this->RoomPart->name]['part_id']) &&
			(int)$userPart[$this->RoomPart->name]['part_id'] === RoomPart::ROOM_ADMIN_PART_ID
		) {
			$this->set('isRoomAdmin', true);
		}
		$this->set('userPart', $userPart);

		$setParts = array(
			'blockCreateable' => 'create_block',
			'blockEditable' => 'edit_block',
			'blockPublishable' => 'publish_block',
			'blockCreateable' => 'create_block',
			'contentCreateable' => 'create_content',
			'contentEditable' => 'edit_content',
			'contentPublishable' => 'publish_content',
			'contentCreateable' => 'create_content',
		);

		foreach ($setParts as $setName => $colName) {
			//block
			if (! isset($userPart[$this->RoomPart->name][$colName])) {
				continue;
			}

			if ((int)$userPart[$this->RoomPart->name][$colName] === RoomPart::IS_ALLOW) {
				$this->set($setName, true);
			}
		}
	}

/**
 * get langId
 *
 * @param string $lang lang code
 * @return int
 */
	private function __getLangId($lang = '') {
		$rtn = $this->Language->findByCode($lang);
		if (isset($rtn[$this->Language->name]['id']) &&
			$rtn[$this->Language->name]['id']) {
			return $rtn[$this->Language->name]['id'];
		}
		return self::DEFAULT_LANGID;
	}

/**
 * ajax output
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
