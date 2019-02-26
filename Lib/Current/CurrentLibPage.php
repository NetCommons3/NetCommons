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
App::uses('CurrentLibPlugin', 'NetCommons.Lib/Current');

/**
 * NetCommonsの機能に必要な情報(ページ関連)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property Page $Page Pageモデル
 * @property PagesLanguage $PagesLanguage PagesLanguageモデル
 * @property PageContainer $PageContainer PageContainerモデル
 * @property Room $Room Roomモデル
 * @property RoomsLanguage $RoomsLanguage RoomsLanguageモデル
 * @property Box $Box Boxモデル
 * @property BoxesPageContainer $BoxesPageContainer BoxesPageContainerモデル
 *
 * @property SettingMode $SettingMode SettingModeライブラリ
 * @property CurrentLibFrame $CurrentLibFrame CurrentLibFrameライブラリ
 * @property CurrentLibRoom $CurrentLibRoom CurrentLibRoomライブラリ
 * @property CurrentLibBlock $CurrentLibBlock CurrentLibBlockライブラリ
 * @property CurrentLibLanguage $CurrentLibLanguage CurrentLibLanguageライブラリ
 * @property CurrentLibUser $CurrentLibUser CurrentLibUserライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibPage extends LibAppObject {

/**
 * キャッシュクラスを保持する変数
 *
 * @var array
 */
	private static $__privateRooms = [
		CurrentLibPlugin::PLUGIN_USERS, CurrentLibPlugin::PLUGIN_GROUPS
	];

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
	public $uses = [
		'Page' => 'Pages.Page',
		'PagesLanguage' => 'Pages.PagesLanguage',
		'PageContainer' => 'Pages.PageContainer',
		'Room' => 'Rooms.Room',
		'RoomsLanguage' => 'Rooms.RoomsLanguage',
		'Box' => 'Boxes.Box',
		'BoxesPageContainer' => 'Boxes.BoxesPageContainer',
	];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'SettingMode' => 'NetCommons.Lib',
		'CurrentLibFrame' => 'NetCommons.Lib/Current',
		'CurrentLibRoom' => 'NetCommons.Lib/Current',
		'CurrentLibBlock' => 'NetCommons.Lib/Current',
		'CurrentLibLanguage' => 'NetCommons.Lib/Current',
		'CurrentLibUser' => 'NetCommons.Lib/Current',
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
 * 言語IDを保持
 *
 * @var string 数値の文字列
 */
	private $__langId = null;

/**
 * $__pageに保持したボックスデータを取得するための情報保持
 *
 * ```
 * $this->__boxMaps = [
 *		(ボックスID) => [
 *			'box_id' => (ボックスID),
 *			'page_id' => (ページID),
 *			'container_type' => (コンテナータイプ：左カラム等のタイプ),
 *			'page_container_id' => (ページコンテナーID：ページID＋コンテナータイプで一意になるID),
 *		]
 * ];
 * ```
 *
 * @var array
 */
	private $__boxMaps = [];

/**
 * インスタンスの取得
 *
 * @return CurrentPage
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
 * プライベートルームとするプラグインの追加
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentPage
 */
	public static function addPluginAsPrivateRooms($plugin) {
		self::$__privateRooms[] = $plugin;
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		parent::initialize($controller);

		if (! $this->__cache) {
			$cacheName = 'current_' .
					$this->Page->useDbConfig . '_' . $this->Page->tablePrefix . $this->Page->table;
			$isTest = ($this->Page->useDbConfig === 'test');
			$this->__cache[$this->Page->alias] = new NetCommonsCache($cacheName, $isTest, 'netcommons_model');
		}

		$this->__langId = $this->CurrentLibLanguage->getLangId();
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
						'Page.room_id' . ' = ' . 'Room.id',
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
			//ページ情報がなかった場合、トップページで表示する
			if ($page) {
				$this->__page = $page;
			} else {
				$this->__page = $topPage;
			}
		}

		//ページ言語データ取得
		$this->__page += $this->__findPagesLanguage($pageId);

		//ページコンテナーデータ取得
		$this->__page += $this->__findPageContainer($pageId);

		return $this->__page;
	}

/**
 * リクエストの中からページIDを取得
 *
 * @return string|null ページID。nullの場合、パラメータ等からpage_idが取得できなかった
 */
	private function __getPageIdInRequest() {
		if (isset($this->_controller->request->data['Page']['id'])) {
			//POSTにpage_idが含まれている場合、それが優先とする
			$pageId = $this->_controller->request->data['Page']['id'];
		} elseif (!empty($this->_controller->request->params['pageView'])) {
			//ページ全体を表示するアクションの場合、permalinkからpage_idから取得
			$permalink = implode('/', $this->_controller->request->params['pass']);
			$pageId = $this->__getPageIdByPermalink($permalink);
		} elseif (!empty($this->_controller->request->params['pageEdit'])) {
			//ページ編集するアクションの場合、URLのパスにpage_idが含まれている
			if (isset($this->_controller->request->params['pass'][1])) {
				//URLのパスが、/:plugin/:controller/:action/(room_id)/(page_id)
				$pageId = $this->_controller->request->params['pass'][1];
			} else {
				//URLのパスが、/:plugin/:controller/:action/(room_id)の場合、ルームの先頭のpage_id
				$roomId = $this->_controller->request->params['pass'][0];
				$pageId = $this->__getPageIdByRoomId($roomId);
			}
		} elseif (isset($this->_controller->query['page_id'])) {
			//リクエストパラメータにpage_idが含まれる
			$pageId = $this->_controller->query['page_id'];
		} elseif (isset($this->_controller->request->params['page_id'])) {
			//controller->paramsにpage_idが含まれる
			//※URLのパスに/:page_idが含まれるか、直接controller->params['page_id']にセットされる場合、
			$pageId = $this->_controller->request->params['page_id'];
		} else {
			$pageId = null;
		}
		return $pageId;
	}

/**
 * ページIDの取得
 *
 * @return string|null ページID(intの文字列)。nullの場合、パラメータ等からpage_idが取得できなかった
 */
	private function __getCurrentPageId() {
		$pageId = $this->__getPageIdInRequest();
		if ($pageId) {
			//リクエストの中からpage_idを取得できた場合、何もしない。
		} elseif (in_array($this->_controller->request->params['plugin'], self::$__privateRooms, true) &&
					! $this->_controller->request->is('ajax')) {
			//プライベートとするアクションであれば、プライベートルームのp
			$userId = $this->CurrentLibUser->getLoginUserId();
			$pageId = $this->__getPageIdByPrivateRoom($userId);
		} elseif ($this->CurrentLibRoom->isRoomIdInRequest()) {
			//リクエストパラメータにroom_idが含まれる場合、そのroom_idからpage_idを取得
			$roomId = $this->CurrentLibRoom->getCurrentRoomId();
			$pageId = $this->__getPageIdByRoomId($roomId);
		} elseif ($this->CurrentLibBlock->isBlockIdInRequest()) {
			//リクエストパラメータにblock_idが含まれる場合、そのblock_idからpage_idを取得
			$blockId = $this->CurrentLibBlock->getCurrentBlockId();
			$pageId = $this->__getPageIdByRoomId($blockId);
		} else {
			//それ以外は、frame_idもしくはblock_idから取得する。取得できなかった場合、未設定として、nullとする
			$frameId = $this->CurrentLibFrame->getCurrentFrameId();
			if ($frameId) {
				$pageId = $this->__getPageIdByFrameId($frameId);
			} elseif ($this->CurrentLibBlock->isBlockIdInRequest()) {
				$blockId = $this->CurrentLibBlock->getCurrentBlockId();
				$pageId = $this->__getPageIdByBlockId($blockId);
			} else {
				$pageId = null;
			}
		}
		return $pageId;
	}

/**
 * ページ言語データの取得
 *
 * @param string|int $pageId ページID
 * @return array
 */
	private function __findPagesLanguage($pageId) {
		$pageLanguage = $this->PagesLanguage->find('first', [
			'recursive' => -1,
			'conditions' => [
				'page_id' => $pageId,
				'language_id' => $this->__langId,
			],
		]);
		return $pageLanguage;
	}

/**
 * ページコンテナ―データの取得
 *
 * @param string|int $pageId ページID
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
			$results[$container['PageContainer']['id']] = $container['PageContainer'];
		}
		ksort($results);

		//ボックスデータ取得
		$boxesEachPageContId = $this->__findBoxes($pageContainerIds);
		foreach ($boxesEachPageContId as $pageContainerId => $boxes) {
			$results[$pageContainerId]['Boxes'] = $boxes;
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
						'RoomsLanguage.language_id' => $this->__langId,
						'Room.id = RoomsLanguage.room_id',
					],
				],
			],
			'order' => 'Box.weight',
		);

		//セッティングモードOFFなら公開に設定されているボックスのみ表示する
		if (! $this->SettingMode->isSettingMode()) {
			$query['conditions']['BoxesPageContainer.is_published'] = true;
		}

		$boxes = $this->BoxesPageContainer->find('all', $query);

		$results = [];
		$boxIds = [];
		foreach ($boxes as $box) {
			$pageContainerId = $box['BoxesPageContainer']['page_container_id'];
			$boxId = $box['Box']['id'];
			$results[$pageContainerId][$boxId] = $box;
			$boxIds[] = $boxId;

			//findBoxByIdからボックスデータを取得するために保持しておく
			$this->__boxMaps[$boxId] = [
				'box_id' => $boxId,
				'page_id' => $box['Box']['page_id'],
				'container_type' => $box['Box']['container_type'],
				'page_container_id' => $pageContainerId,
			];
		}

		//Frameデータ取得
		$framesEachBoxId = $this->CurrentLibFrame->findFramesByBoxIds($boxIds);
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
			$page = $this->findTopPage();
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
 * @param string|int $roomId ルームID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByRoomId($roomId) {
		$room = $this->CurrentLibRoom->findRoomById($roomId);
		if ($room) {
			return $room['Room']['page_id_top'];
		} else {
			return null;
		}
	}

/**
 * block_idからルームのトップページIDを取得
 *
 * @param string|int $roomId ルームID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByBlockId($blockId) {
		$block = $this->CurrentLibBlock->findBlockById($blockId);
		if (! $block) {
			return null;
		}

		$roomId = $block['Block']['room_id'];
		return $this->__getPageIdByRoomId($roomId);
	}

/**
 * frame_idからルームのトップページIDを取得
 *
 * @param string|int $roomId ルームID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByFrameId($frameId) {
		$frame = $this->CurrentLibFrame->findFrameById($frameId);
		if (! $frame) {
			return null;
		}

		$roomId = $frame['Frame']['room_id'];
		return $this->__getPageIdByRoomId($roomId);
	}

/**
 * プライベートルームのトップページIDを取得
 *
 * @param string|int $userId ユーザID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByPrivateRoom($userId) {
		$room = $this->CurrentLibRoom->findPrivateRoom($userId);
		if ($room) {
			return $room['Room']['page_id_top'];
		} else {
			return null;
		}
	}

/**
 * ボックスデータを取得する
 *
 * @param string|int $boxId ボックスID
 * @return array
 */
	public function findBoxById($boxId) {
		if (! $this->__page || ! isset($this->__boxMaps[$boxId])) {
			return [];
		}

		$pageContainerId = $this->__boxMaps[$boxId]['page_container_id'];
		if (isset($this->__page[$pageContainerId]['Boxes'][$boxId])) {
			return $this->__page[$pageContainerId]['Boxes'][$boxId];
		} else {
			return [];
		}
	}

}
