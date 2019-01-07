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

/**
 * NetCommonsの機能に必要な情報(ページ関連)を取得する内容をまとめたUtility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetPage {

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	private $__controller;

/**
 * CurrentGetPageインスタンス
 *
 * @var CurrentGetPage
 */
	private static $___instance;

/**
 * キャッシュクラスを保持する変数
 *
 * @var array
 */
	private $__cache;

/**
 * Pageモデル
 *
 * @var Page
 */
	public $Page;

/**
 * Roomモデル
 *
 * @var Room
 */
	public $Room;

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
		$this->__controller = $controller;

		$this->Page = ClassRegistry::init('Pages.Page');
		$cacheName = 'current_' .
				$this->Page->useDbConfig . '_' . $this->Page->tablePrefix . $this->Page->table;
		$isTest = ($this->Page->useDbConfig === 'test');
		$this->__cache[$this->Page->alias] = new NetCommonsCache($cacheName, $isTest, 'netcommons_model');

		$this->Room = ClassRegistry::init('Rooms.Room');

//		$this->PluginsRole = ClassRegistry::init('PluginManager.PluginsRole');
//		$this->Plugin = ClassRegistry::init('PluginManager.Plugin');
	}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetPage
 */
	public static function getInstance(Controller $controller) {
		if (! self::$___instance) {
			self::$___instance = new CurrentGetPage($controller);
		}
		return self::$___instance;
	}

/**
 * トップページのデータを取得する
 *
 * @return array
 */
	public function getTopPage() {
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

		$this->__cache[$this->Page->alias]->write($topPage['Page'], 'current', 'top_page');
		$this->__topPage = $topPage['Page'];
		return $this->__topPage;
	}

/**
 * ページデータを取得する
 *
 * @return array
 */
	public function getCurrentPage() {
		if ($this->__page) {
			return $this->__page;
		}

		$page = $this->Page->find('first', [
			'recursive' => -1,
			'conditions' => [
				'id' => $this->__getCurrentPageId(),
			],
		]);

		$this->__page = $page['Page'];
		return $this->__page;
	}

/**
 * ページIDの取得
 *
 * @return string ページID(intの文字列)
 */
	private function __getCurrentPageId() {
		$privateRoomPlugins = [Current::PLUGIN_USERS, Current::PLUGIN_GROUPS];

		if (isset($this->__controller->request->data['Page']['id'])) {
			$pageId = $this->__controller->request->data['Page']['id'];
		} elseif (!empty($this->__controller->request->params['pageView'])) {
			$permalink = implode('/', $this->__controller->request->params['pass']);
			$pageId = $this->__getPageIdByPermalink($permalink);
		} elseif (!empty($this->__controller->request->params['pageEdit'])) {
			if (isset($this->__controller->request->params['pass'][1])) {
				$pageId = $this->__controller->request->params['pass'][1];
			} else {
				$roomId = $this->__controller->request->params['pass'][0];
				$pageId = $this->__getPageIdByRoomId($roomId);
			}
		} elseif (isset($this->__controller->query['page_id'])) {
			$pageId = $this->__controller->query['page_id'];
		} elseif (isset($this->__controller->request->params['page_id'])) {
			$pageId = $this->__controller->request->params['page_id'];
		} elseif (in_array($this->__controller->request->params['plugin'], $privateRoomPlugins, true) &&
					! $this->__controller->request->is('ajax')) {
			$userId = Current::read('User.id');
			$pageId = $this->__getPageIdByPrivateRoom($userId);
		} elseif (isset($this->__controller->request->data['Room']['id'])) {
			$roomId = $this->__controller->request->data['Room']['id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} elseif (isset($this->__controller->query['room_id'])) {
			$roomId = $this->__controller->query['room_id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} elseif (isset($this->__controller->request->params['room_id'])) {
			$roomId = $this->__controller->request->params['room_id'];
			$pageId = $this->__getPageIdByRoomId($roomId);
		} else {
			$pageId = null;
		}

		return $pageId;
	}

/**
 * パーマリンクからページIDを取得
 *
 * @param string $permalink パーマリンク
 * @return string ページID(intの文字列)
 */
	private function __getPageIdByPermalink($permalink) {
		$permalink = implode('/', $this->__controller->request->params['pass']);
		if ($permalink === '') {
			$page['Page'] = $this->getTopPage();
		} else {
			if (isset($this->__controller->request->params['spaceId'])) {
				$spaceId = $this->__controller->request->params['spaceId'];
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
		$currentGetRoom = CurrentGetRoom::getInstance($this->__controller);
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
		$currentGetRoom = CurrentGetRoom::getInstance($this->__controller);
		$room = $currentGetRoom->getPrivateRoom($userId);
		if ($room) {
			return $room['page_id_top'];
		} else {
			return null;
		}
	}

}
