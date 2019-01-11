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

App::uses('CurrentGetRoom', 'NetCommons.Utility');
App::uses('CurrentGetAppObject', 'NetCommons.Utility');

/**
 * NetCommonsの機能に必要な情報(ページ関連)を取得する内容をまとめたUtility
 *
 * @property Page $Page Pageモデル
 * @property PagesLanguage $PagesLanguage PagesLanguageモデル
 * @property PageContainer $PageContainer PageContainerモデル
 * @property Room $Room Roomモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetPage extends CurrentGetAppObject {

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
 * コンストラクター
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function __construct(Controller $controller) {
		parent::__construct($controller);

		$cacheName = 'current_' .
				$this->Page->useDbConfig . '_' . $this->Page->tablePrefix . $this->Page->table;
		$isTest = ($this->Page->useDbConfig === 'test');
		$this->__cache[$this->Page->alias] = new NetCommonsCache($cacheName, $isTest, 'netcommons_model');
}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetPage
 */
	public static function getInstance(Controller $controller) {
		return parent::_getInstance($controller, __CLASS__);
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

		$topPageId = $this->Page->find('first', [
			'recursive' => -1,
			'fields' => ['Page.id'],
			'joins' => [
				[
					'table' => $this->Room->table,
					'alias' => $this->Room->alias,
					'type' => 'INNER',
					'conditions' => [
						$this->Page->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
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

		$cacheTopPageId = $this->__cache[$this->Page->alias]->read('current', 'top_page_id');
		if ($cacheTopPageId === $topPageId['Page']['id']) {
			$this->__topPage = $this->__cache[$this->Page->alias]->read('current', 'top_page');
			return $this->__topPage;
		}

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
							$this->Page->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
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
		$currentGetRoom = CurrentGetRoom::getInstance($this->_controller);
		$room = $currentGetRoom->getRoom($roomId);
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
		$currentGetRoom = CurrentGetRoom::getInstance($this->_controller);
		$room = $currentGetRoom->getPrivateRoom($userId);
		if ($room) {
			return $room['page_id_top'];
		} else {
			return null;
		}
	}

}
