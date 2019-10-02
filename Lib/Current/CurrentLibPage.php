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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity) 別ファイルにすると分かりにくくなるため
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
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
		'Page',
		'PagesLanguage',
		'PageContainer',
		'Room',
		'RoomsLanguage',
		'Box',
		'BoxesPageContainer',
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
	private $__currentPage = null;

/**
 * 一度取得したページデータを保持
 *
 * @var array
 */
	private $__pages = [];

/**
 * 一度取得したページコンテナーデータを保持
 *
 * @var array|null
 */
	private $__curPageContainer = null;

/**
 * 言語IDを保持
 *
 * @var string 数値の文字列
 */
	private $__langId = null;

/**
 * $__currentPageに保持したボックスデータを取得するための情報保持
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
		self::$__privateRooms = [];
		parent::_resetInstance(__CLASS__);
	}

/**
 * プライベートルームとするプラグインの追加
 *
 * @param string $plugin 追加するプラグイン
 * @return void
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
			$this->__cache[$this->Page->alias] =
					new NetCommonsCache($cacheName, $isTest, 'netcommons_model');
		}

		$this->__langId = $this->CurrentLibLanguage->getLangId();
	}

/**
 * フレームデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __makePageFields() {
		$fields = [
			'Page.id',
			'Page.room_id',
			'Page.root_id',
			'Page.parent_id',
			'Page.weight',
			'Page.sort_key',
			'Page.child_count',
			'Page.permalink',
			'Page.slug',
			'Page.is_container_fluid',
			'Page.theme',
		];

		return $fields;
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
				'fields' => ['weight'],
				'recursive' => -1,
				'conditions' => [
					'Page.id' => $cacheTopPageId,
				],
				'callbacks' => false,
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
				'Page.parent_id NOT' => null,
				'Room.space_id' => Space::PUBLIC_SPACE_ID,
			],
			'order' => ['Page.sort_key' => 'asc'],
			'callbacks' => false,
		]);

		//@codeCoverageIgnoreStart
		if (empty($topPageId['Page']['id'])) {
			//トップページのデータが存在しないことは通常あり得ないがが、UnitTestではあり得るので、
			//その場合、空で抜ける。
			return [];
		}
		//@codeCoverageIgnoreEnd

		$this->__cache[$this->Page->alias]->write($topPageId['Page']['id'], 'current', 'top_page_id');

		$topPage = $this->Page->find('first', [
			'recursive' => -1,
			'fields' => $this->__makePageFields(),
			'conditions' => [
				'Page.id' => $topPageId['Page']['id'],
			],
			'callbacks' => false,
		]);

		$this->__cache[$this->Page->alias]->write($topPage, 'current', 'top_page');
		$this->__topPage = $topPage;
		return $this->__topPage;
	}

/**
 * トップページのページIDか否かチェックする
 *
 * @param string|int $pageId ページID
 * @return bool
 */
	public function isTopPageId($pageId) {
		$topPage = $this->findTopPage();
		//@codeCoverageIgnoreStart
		if (! $topPage) {
			//トップページのデータが存在しないことは通常あり得ないがが、UnitTestではあり得るので、
			//その場合、空で抜ける。
			return false;
		}
		//@codeCoverageIgnoreEnd
		return $topPage['Page']['id'] == $pageId;
	}

/**
 * ページデータを取得する
 *
 * @return array
 */
	public function findCurrentPage() {
		if (! $this->__currentPage) {
			$pageId = $this->__getCurrentPageId();
			$this->__currentPage = $this->findPage($pageId);
		}
		return $this->__currentPage;
	}

/**
 * ページデータをセットする
 *
 * @param array $page ページデータ
 * @return array
 */
	public function setCurrentPage($page) {
		if (isset($this->__currentPage['Page']['id'])) {
			$isChangePage = $this->__currentPage['Page']['id'] !== $page['Page']['id'];
		} else {
			$isChangePage = true;
		}
		if ($isChangePage) {
			$this->__currentPage = $page;
			if (isset($this->__curPageContainer)) {
				//既にコンテナーが取得されている場合、再取得を行う
				$this->__curPageContainer = null;
				$this->findCurrentPageContainer();
			}
		}
	}

/**
 * ページデータを取得する
 *
 * @param string|int $pageId ページID
 * @return array
 */
	public function findPage($pageId) {
		if (isset($this->__pages[$pageId])) {
			return $this->__pages[$pageId];
		}

		$topPage = $this->findTopPage();
		//@codeCoverageIgnoreStart
		if (! $topPage) {
			//トップページのデータが存在しないことは通常あり得ないがが、UnitTestではあり得るので、
			//その場合、空で抜ける。
			return [];
		}
		//@codeCoverageIgnoreEnd

		if (! $pageId || $pageId === $topPage['Page']['id']) {
			$page = $topPage;
		} else {
			$page = $this->Page->find('first', [
				'recursive' => -1,
				'fields' => $this->__makePageFields(),
				'conditions' => [
					'Page.id' => $pageId,
				],
				'callbacks' => false,
			]);
			//ページ情報がなかった場合、トップページで表示する
			if (! $page) {
				$page = $topPage;
			}
		}

		//full_permalinkの設定
		$page['Page']['full_permalink'] = $this->__makeFullPermalink(
			$page['Page']['room_id'],
			$page['Page']['id'],
			$page['Page']['permalink']
		);

		//ページ言語データ取得
		$page += $this->__findPagesLanguage($page['Page']['id']);

		$this->__pages[$pageId] = $page;
		return $page;
	}

/**
 * ページデータ(コンテナー付き)を取得する
 *
 * @return array
 */
	public function findCurrentPageContainer() {
		if (! isset($this->__curPageContainer)) {
			$page = $this->findCurrentPage();
			if ($page) {
				$this->__curPageContainer = $this->findPageContainer($page['Page']['id']);
			}
		}
		return $this->__curPageContainer;
	}

/**
 * ページデータ(コンテナー付き)を取得する
 *
 * @return array
 */
	public function findCurrentPageWithContainer() {
		$page = $this->findCurrentPage();
		$page['PageContainer'] = $this->findCurrentPageContainer();
		return $page;
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
			$pageId = $this->getPageIdByPermalink($permalink);
		} elseif (!empty($this->_controller->request->params['pageEdit'])) {
			//ページ編集するアクションの場合、URLのパスにpage_idが含まれている
			//※通常だと、NetCommons/Config/routes.phpでpass.0がblock_id、pass.1がcontent_keyとして
			//　扱われるため、Pages/Config/routes.phpでそうならないように設定する必要がる。
			if (isset($this->_controller->request->params['pass'][1])) {
				//URLのパスが、/:plugin/:controller/:action/(room_id)/(page_id)
				$pageId = $this->_controller->request->params['pass'][1];
			} else {
				//URLのパスが、/:plugin/:controller/:action/(room_id)の場合、ルームの先頭のpage_id
				$roomId = isset($this->_controller->request->params['pass'][0]) ?
					$this->_controller->request->params['pass'][0] : null;
				$pageId = $this->__getPageIdByRoomId($roomId);
			}
		} elseif (isset($this->_controller->request->query['page_id'])) {
			//リクエストパラメータにpage_idが含まれる
			$pageId = $this->_controller->request->query['page_id'];
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
		} else {
			//それ以外は、frame_idもしくはblock_idから取得する。取得できなかった場合、未設定として、nullとする
			$frameId = $this->CurrentLibFrame->getCurrentFrameId();
			$boxId = $this->CurrentLibFrame->getBoxIdByFrameInRequest();
			if ($frameId) {
				$pageId = $this->__getPageIdByFrameId($frameId);
			} elseif ($this->CurrentLibBlock->isBlockIdInRequest()) {
				$blockId = $this->CurrentLibBlock->getCurrentBlockId();
				$pageId = $this->__getPageIdByBlockId($blockId);
			} elseif ($boxId) {
				$pageId = $this->__getPageIdByBoxId($boxId);
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
			'fields' => [
				'id', 'language_id', 'page_id',
				//'is_origin', 'is_translation',
				'name',
				'meta_title', 'meta_description', 'meta_keywords', 'meta_robots'
			],
			'conditions' => [
				'PagesLanguage.page_id' => $pageId,
				'PagesLanguage.language_id' => $this->__langId,
			],
			'callbacks' => false,
		]);
		return $pageLanguage;
	}

/**
 * ページコンテナ―データの取得
 *
 * @param string|int $pageId ページID
 * @return array
 */
	public function findPageContainer($pageId) {
		$pageContainers = $this->PageContainer->find('all', array(
			'recursive' => -1,
			'fields' => [
				'id', 'page_id', 'container_type', 'is_published', 'is_configured'
			],
			'conditions' => array(
				'PageContainer.page_id' => $pageId,
			),
			//'order' => array('container_type' => 'asc'),
			'callbacks' => false,
		));

		$results = [];
		$pageContainerIds = [];
		foreach ($pageContainers as $container) {
			$pageContainerIds[] = $container['PageContainer']['id'];
			$results[$container['PageContainer']['id']] = $container['PageContainer'];
		}
		ksort($results);

		//ボックスデータ取得
		$boxesEachPageContId = $this->__findBoxes($pageContainerIds);
		foreach ($boxesEachPageContId as $pageContainerId => $boxes) {
			$results[$pageContainerId]['Box'] = $boxes;
		}

		return $results;
	}

/**
 * Boxデータを取得するカラムを生成する
 *
 * @return array
 */
	private function __getFieldsByBoxes() {
		$fields = [
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
		];
		return $fields;
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
			'fields' => $this->__getFieldsByBoxes(),
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
			'order' => [
				'BoxesPageContainer.page_container_id',
				'BoxesPageContainer.weight',
				//'BoxesPageContainer.box_id',
				//'BoxesPageContainer.is_published',
			],
			'callbacks' => false,
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
		foreach ($framesEachBoxId as $boxId => $frames) {
			$pageContainerId = $this->__boxMaps[$boxId]['page_container_id'];
			$results[$pageContainerId][$boxId]['Frame'] = $frames;
		}

		return $results;
	}

/**
 * パーマリンクからページIDを取得
 *
 * @param string $permalink パーマリンク
 * @param string|int|null $spaceId スペースID
 * @return string|int|false ページID
 */
	public function getPageIdByPermalink($permalink, $spaceId = null) {
		if ($permalink == '') {
			$page = $this->findTopPage();
			if ($page) {
				return $page['Page']['id'];
			} else {
				return false;
			}
		} else {
			if ($spaceId) {
				//引数にスペースIDがある場合は、そっちを優先する
			} elseif (isset($this->_controller->request->params['spaceId'])) {
				$spaceId = $this->_controller->request->params['spaceId'];
			} else {
				$spaceId = Space::PUBLIC_SPACE_ID;
			}
			$pages = $this->Page->find('all', [
				'recursive' => -1,
				'fields' => ['Page.id', 'Page.room_id', 'PagesLanguage.language_id'],
				'joins' => [
					[
						'type' => 'LEFT',
						'table' => $this->PagesLanguage->table,
						'alias' => $this->PagesLanguage->alias,
						'conditions' => [
							'PagesLanguage.page_id' . ' = ' . 'Page.id'
						],
					],
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
					'Page.permalink' => $permalink,
					'Room.space_id' => $spaceId,
				],
				'callbacks' => false,
			]);
			if (count($pages) > 1) {
				//２レコード取得できた場合、該当言語の方を表示させる
				foreach ($pages as $page) {
					if ($page['PagesLanguage']['language_id'] == $this->__langId) {
						return $page['Page']['id'];
					}
				}
				//ヒットしなければ、最初の方を返す。
				return $pages[0]['Page']['id'];
			} elseif (count($pages) === 1) {
				//１レコードしかヒットしなかった場合、そのページIDを返す
				return $pages[0]['Page']['id'];
			} else {
				return false;
			}
		}
	}

/**
 * 対象ルームのトップページのページIDを取得
 *
 * @param string|int $roomId ルームID
 * @return string|int|false ページID
 */
	public function getPageIdByRoomWeightTop($roomId) {
		$page = $this->Page->find('first', [
			'recursive' => -1,
			'fields' => ['Page.id'],
			'conditions' => [
				'Page.room_id' => $roomId,
				'Page.weight' => 1,
			],
			'callbacks' => false,
		]);

		if ($page) {
			return $page['Page']['id'];
		} else {
			return false;
		}
	}

/**
 * full_permalinkの生成
 *
 * @param string|int $roomId ルームID
 * @param string|int $pageId ページID
 * @param string $pagePermalink ページのパーマリンク
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __makeFullPermalink($roomId, $pageId, $pagePermalink) {
		$topPage = $this->findTopPage();
		$space = $this->CurrentLibRoom->findSpaceByRoomId($roomId);
		if ($space['permalink']) {
			$fullPermalink = $space['permalink'] . '/';
		} else {
			$fullPermalink = '';
		}
		if ($pageId !== $topPage['Page']['id']) {
			$fullPermalink .= $pagePermalink;
		} else {
			$fullPermalink = '';
		}

		return $fullPermalink;
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
 * @param string|int $blockId ブロックID
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
 * frame_idからページIDを取得
 *
 * @param string|int $frameId フレームID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByFrameId($frameId) {
		$frame = $this->CurrentLibFrame->findFrameById($frameId);
		if (! $frame) {
			return null;
		}

		$boxId = $frame['Frame']['box_id'];
		return $this->__getPageIdByBoxId($boxId);
	}

/**
 * box_idからページIDを取得
 *
 * @param string|int $boxId ボックスID
 * @return string|null ページID。該当するルームのページIDが存在しない場合、nullとする
 */
	private function __getPageIdByBoxId($boxId) {
		$box = $this->findBoxById($boxId);
		if (! $box) {
			return null;
		}

		if (!empty($box['Box']['page_id'])) {
			return $box['Box']['page_id'];
		} else {
			return $this->__getPageIdByRoomId($box['Box']['room_id']);
		}
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
		if ($this->__curPageContainer && isset($this->__boxMaps[$boxId])) {
			$pageContainerId = $this->__boxMaps[$boxId]['page_container_id'];
			if (isset($this->__curPageContainer[$pageContainerId]['Box'][$boxId])) {
				return $this->__curPageContainer[$pageContainerId]['Box'][$boxId];
			} else {
				return [];
			}
		} else {
			//ページデータ前に取得する場合に使用する。
			$box = $this->Box->find('first', [
				'recursive' => -1,
				'fields' => [
					'Box.id',
					//'Box.container_id',
					//'Box.type',
					'Box.space_id',
					'Box.room_id',
					'Box.page_id',
					//'Box.container_type',
					//'Box.weight',
				],
				'conditions' => [
					'Box.id' => $boxId,
				],
				'callbacks' => false,
			]);
			return $box;
		}
	}

}
