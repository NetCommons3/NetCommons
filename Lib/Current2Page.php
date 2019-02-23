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
App::uses('CurrentRoom', 'NetCommons.Lib');
App::uses('CurrentFrame', 'NetCommons.Lib');
App::uses('Current2', 'NetCommons.Utility');

/**
 * NetCommonsの機能に必要な情報(ページ関連)を取得する内容をまとめたUtility
 *
 * @property string $_lang 言語ID
 * @property Controller $_controller コントローラ
 * @property Page $Page Pageモデル
 * @property PagesLanguage $PagesLanguage PagesLanguageモデル
 * @property PageContainer $PageContainer PageContainerモデル
 * @property Room $Room Roomモデル
 * @property RoomsLanguage $RoomsLanguage RoomsLanguageモデル
 * @property Box $Box Boxモデル
 * @property BoxesPageContainer $BoxesPageContainer BoxesPageContainerモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class Current2Page extends CurrentAppObject {

/**
 * キャッシュクラスを保持する変数
 *
 * @var array
 */
	private $__cache;

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'Page' => 'Pages.Page',
		'PagesLanguage' => 'Pages.PagesLanguage',
		'PageContainer' => 'Pages.PageContainer',
		'Room' => 'Rooms.Room',
		'RoomsLanguage' => 'Rooms.RoomsLanguage',
		'Box' => 'Boxes.Box',
		'BoxesPageContainer' => 'Boxes.BoxesPageContainer',
	];

/**
 * 一度取得したページデータを保持
 *
 * @var array|null
 */
	private $__topPage = null;

/**
 * 一度取得したページデータを保持
 *
 * @var array|null
 */
	private $__page = null;

/**
 * クラス内で処理するCurrentFrameインスタンス
 *
 * @var CurrentFrame
 */
	protected $_CurrentFrame;

/**
 * クラス内で処理するCurrentRoomインスタンス
 *
 * @var CurrentRoom
 */
	protected $_CurrentRoom;

/**
 * コンストラクター
 *
 * @param Controller|null $controller コントローラ
 * @return void
 */
	public function __construct($controller = null) {
		parent::__construct($controller);

		$cacheName = 'current_' .
				$this->Page->useDbConfig . '_' . $this->Page->tablePrefix . $this->Page->table;
		$isTest = ($this->Page->useDbConfig === 'test');
		$this->__cache[$this->Page->alias] = new NetCommonsCache($cacheName, $isTest, 'netcommons_model');
	}

/**
 * インスタンスの取得
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentPage
 */
	public static function getInstance($controller = null) {
		return parent::_getInstance($controller, __CLASS__);
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function setController($controller) {
		parent::setController($controller);

		$this->_CurrentFrame = Current2Frame::getInstance($controller);
		$this->_CurrentRoom = CurrentRoom::getInstance($controller);
	}

/**
 * トップページのデータを取得する
 *
 * @return array
 */
	public function findTopPage() {
		if ($this->__topPage) {
			return $this->__topPage;
		}

		$cacheTopPageId = $this->__cache[$this->Page->alias]->read('current', 'top_page_id');
		if ($cacheTopPageId) {
			$result = $this->Page->find('first', [
				'fields' => ['id', 'weight'],
				'recursive' => -1,
				'conditions' => [
					'id' => $cacheTopPageId,
				],
			]);
			if ($result[$this->Page->alias]['weight'] == '1') {
				//キャッシュのトップページの内容と変わってなければ、キャッシュの内容を
				$this->__topPage = $this->__cache[$this->Page->alias]->read('current', 'top_page');
				return $this->__topPage;
			}
		}

		//キャッシュにトップページが存在しない、もしくは、トップページが変わっている場合、再取得
		$topPageId = $this->Page->find('first', [
			'recursive' => -1,
			'fields' => ['Page.id'],
			'joins' => [
				[
					'table' => $this->Room->table,
					'alias' => $this->Room->alias,
					'type' => 'INNER',
					'conditions' => [
						$this->Page->alias . '.room_id' . ' = ' . ' .id',
					],
				],
			],
			'conditions' => [
				// パブリックルームのトップページ取得は、パブリックルームが複数ありえるため、スペースIDを指定して取得する
				//'Page.root_id' => Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID),
				'Room.space_id' => Space::PUBLIC_SPACE_ID,
				'Page.parent_id NOT' => null,
			],
			'order' => ['Page.sort_key' => 'asc'],
		]);

		$this->__cache[$this->Page->alias]->write($topPageId['Page']['id'], 'current', 'top_page_id');

		$topPage = $this->Page->find('first', [
			'recursive' => -1,
			'conditions' => [
				'id' => $topPageId['Page']['id'],
			],
		]);

		$this->__cache[$this->Page->alias]->write($topPage, 'current', 'top_page');
		$this->__topPage = $topPage;
		return $this->__topPage;
	}

/**
 * ページデータを取得する
 *
 * @return array
 */
	public function findCurrentPage() {
		if ($this->__page) {
			return $this->__page;
		}

		$pageId = $this->__getCurrentPageId();
		$topPage = $this->findTopPage();

		if ($pageId === $topPage['Page']['id']) {
			$this->__page = $topPage;
		} else {
			$page = $this->Page->find('first', [
				'recursive' => -1,
				'conditions' => [
					'id' => $pageId,
				],
			]);
			$this->__page = $page;
		}

		//ページ言語データ取得
		$this->__page += $this->__findPagesLanguage($pageId);

		return $this->__page;
	}

/**
 * ページIDの取得
 *
 * @return string ページID(intの文字列)
 */
	private function __getCurrentPageId() {
		$privateRoomPlugins = [Current::PLUGIN_USERS, Current::PLUGIN_GROUPS];

		if (isset($this->_controller->request->data['Page']['id'])) {
			$pageId = $this->_controller->request->data['Page']['id'];
		} elseif (!empty($this->_controller->request->params['pageView'])) {
			$permalink = implode('/', $this->_controller->request->params['pass']);
			$pageId = $this->__getPageIdByPermalink($permalink);
		} elseif (!empty($this->_controller->request->params['pageEdit'])) {
			if (isset($this->_controller->request->params['pass'][1])) {
				$pageId = $this->_controller->request->params['pass'][1];
			} else {
				$roomId = $this->_controller->request->params['pass'][0];
				$pageId = $this->__getPageIdByRoomId($roomId);
			}
		} elseif (isset($this->_controller->query['page_id'])) {
			$pageId = $this->_controller->query['page_id'];
		} elseif (isset($this->_controller->request->params['page_id'])) {
			$pageId = $this->_controller->request->params['page_id'];
		} elseif (in_array($this->_controller->request->params['plugin'], $privateRoomPlugins, true) &&
					! $this->_controller->request->is('ajax')) {
			$userId = Current::read('User.id');
			$pageId = $this->__getPageIdByPrivateRoom($userId);
		} elseif (isset($this->_controller->request->data['Room']['id'])) {
			$roomId = $this->_controller->request->data['Room']['id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} elseif (isset($this->_controller->query['room_id'])) {
			$roomId = $this->_controller->query['room_id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} elseif (isset($this->_controller->request->params['room_id'])) {
			$roomId = $this->_controller->request->params['room_id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} else {
			$pageId = null;
		}

		return $pageId;
	}

/**
 * ページ言語データの取得
 *
 * @param string $pageId ページID(intの文字列)
 * @return array
 */
	private function __findPagesLanguage($pageId) {
		$pageLanguage = $this->PagesLanguage->find('first', [
			'recursive' => -1,
			'conditions' => [
				'page_id' => $pageId,
				'language_id' => $this->_langId,
			],
		]);
		return $pageLanguage;
	}

/**
 * ページコンテナ―データの取得
 *
 * @param string $pageId ページID(intの文字列)
 * @return array
 */
	private function __findPageContainer($pageId) {
		$pageContainers = $this->PageContainer->find('all', array(
			'recursive' => -1,
			'fields' => [
				'id', 'page_id', 'container_type', 'is_published', 'is_configured'
			],
			'conditions' => array(
				'page_id' => $pageId,
			),
			//'order' => array('container_type' => 'asc'),
		));

		$results = [];
		$pageContainerIds = [];
		foreach ($pageContainers as $container) {
			$containerType = $container['PageContainer']['container_type'];
			$pageContainerIds[] = $container['PageContainer']['id'];
			$results[$containerType] = $container['PageContainer'];
		}
		ksort($results);

		//ボックスデータ取得
		$boxesEachPageContId = $this->__findBoxes($pageContainerIds);
		foreach ($boxesEachPageContId as $pageContainerId => $boxes) {
			$results[$pageContainerId]['Boxes'] += $boxes;
		}

		return $results;
	}

/**
 * ボックスデータの取得
 *
 * @param array $pageContainerIds ページコンテナ―IDリスト
 * @return array
 */
	private function __findBoxes($pageContainerIds) {
		$query = array(
			'recursive' => -1,
			'fields' => [
				'BoxesPageContainer.id',
				'BoxesPageContainer.page_container_id',
				'BoxesPageContainer.page_id',
				'BoxesPageContainer.container_type',
				'BoxesPageContainer.box_id',
				'BoxesPageContainer.is_published',
				'BoxesPageContainer.weight',
				'Box.id',
				'Box.container_id',
				'Box.type',
				'Box.space_id',
				'Box.room_id',
				'Box.page_id',
				'Box.container_type',
				'Box.weight',
				'Room.id',
				'Room.space_id',
				'Room.page_id_top',
				'Room.parent_id',
				'Room.weight',
				'Room.sort_key',
				'Room.child_count',
				'Room.active',
				'Room.in_draft',
				'Room.default_role_key',
				'Room.need_approval',
				'Room.default_participation',
				'Room.page_layout_permitted',
				'Room.theme',
				'RoomsLanguage.id',
				'RoomsLanguage.name',
			],
			'conditions' => array(
				'BoxesPageContainer.page_container_id' => $pageContainerIds,
			),
			'joins' => [
				[
					'type' => 'INNER',
					'table' => $this->Box->table,
					'alias' => $this->Box->alias,
					'conditions' => [
						'Box.id = BoxesPageContainer.box_id',
					],
				],
				[
					'type' => 'INNER',
					'table' => $this->Room->table,
					'alias' => $this->Room->alias,
					'conditions' => [
						'Box.room_id = Room.id',
					],
				],
				[
					'type' => 'LEFT',
					'table' => $this->RoomsLanguage->table,
					'alias' => $this->RoomsLanguage->alias,
					'conditions' => [
						'RoomsLanguage.language_id' => $this->__lang,
						'Room.id = RoomsLanguage.room_id',
					],
				],
			],
			'order' => '.weight',
		);

		//セッティングモードOFFなら公開に設定されているボックスのみ表示する
		if (! Current2::isSettingMode()) {
			$query['conditions']['.is_published'] = true;
		}

		$boxes = $this->BoxesPageContainer->find('all', $query);

		$results = [];
		$boxIds = [];
		foreach ($boxes as $box) {
			$pageContainerId = $box['BoxesPageContainer']['page_container_id'];
			$boxId = $box['Box']['id'];
			$results[$pageContainerId][$boxId] = $box;
			$boxIds[] = $boxId;
		}

		//Frameデータ取得
		$framesEachBoxId = $this->_CurrentFrame->findFramesByBoxIds($boxIds);
		foreach ($pageContainerIds as $pageContainerId) {
			foreach ($framesEachBoxId as $boxId => $frames) {
				$results[$pageContainerId][$boxId]['Frames'] = $frames;
			}
		}

		return $results;
	}

/**
 * パーマリンクからページIDを取得
 *
 * @param string $permalink パーマリンク
 * @return string ページID(intの文字列)
 */
	private function __getPageIdByPermalink($permalink) {
		$permalink = implode('/', $this->_controller->request->params['pass']);
		if ($permalink === '') {
			$page['Page'] = $this->findTopPage();
		} else {
			if (isset($this->_controller->request->params['spaceId'])) {
				$spaceId = $this->_controller->request->params['spaceId'];
			} else {
				$spaceId = Space::PUBLIC_SPACE_ID;
			}
			$page = $this->Page->find('first', [
				'recursive' => -1,
				'fields' => ['Page.id'],
				'joins' => [
					[
						'table' => $this->Room->table,
						'alias' => $this->Room->alias,
						'type' => 'INNER',
						'conditions' => [
							$this->Page->alias . '.room_id' . ' = ' . ' .id',
						],
					],
				],
				'conditions' => [
					'Room.space_id' => $spaceId,
					'Page.permalink' => $permalink,
				],
			]);
		}

		return $page['Page']['id'];
	}

/**
 * room_idからルームのトップページIDを取得
 *
 * @param string $roomId ルームID(intの文字列)
 * @return string ページID(intの文字列)
 */
	private function __getPageIdByRoomId($roomId) {
		$room = $this->_CurrentRoom->getRoom($roomId);
		if ($room) {
			return $room['page_id_top'];
		} else {
			return null;
		}
	}

/**
 * room_idからルームのトップページIDを取得
 *
 * @param string $userId ユーザID(intの文字列)
 * @return string ページID(intの文字列)
 */
	private function __getPageIdByPrivateRoom($userId) {
		$room = $this->_CurrentRoom->getPrivateRoom($userId);
		if ($room) {
			return $room['page_id_top'];
		} else {
			return null;
		}
	}

}
