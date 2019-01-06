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

/**
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 * ※本来、ここに集約せずに各モデルに書く方が良い。
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
 * Set TopPage
 *
 * @return bool
 */
	public function getTopPage() {
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
				'Page.room_id = Room.id',
				'Room.space_id' => Space::PUBLIC_SPACE_ID,
				'Page.parent_id NOT' => null,
			],
			'order' => ['Page.sort_key' => 'asc'],
		]);

		$cacheTopPageId = $this->__cache[$this->Page->alias]->read('current', 'top_page_id');
		if ($cacheTopPageId === $topPageId['Page']['id']) {
			return $this->__cache[$this->Page->alias]->read('current', 'top_page');
		}

		$this->__cache[$this->Page->alias]->write($topPageId['Page']['id'], 'current', 'top_page_id');

		$topPage = $this->Page->find('first', [
			'recursive' => -1,
			'conditions' => [
				'id' => $topPageId['Page']['id'],
			],
		]);

		$this->__cache[$this->Page->alias]->write($topPage['Page'], 'current', 'top_page');

		return $topPage['Page'];
//		$this->Page = ClassRegistry::init('Pages.Page');
//		if (isset(Current::$current['TopPage'])) {
//			return;
//		}
//
//		$result = $this->__getPage(array(
//			//'recursive' => -1,
//			'recursive' => 0,
//			'conditions' => array(
//				// パブリックルームのトップページ取得は、パブリックルームが複数ありえるため、スペースIDを指定して取得する
//				//'Page.root_id' => Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID),
//				'Page.room_id = Room.id',
//				'Room.space_id' => Space::PUBLIC_SPACE_ID,
//				'Page.parent_id NOT' => null,
//			),
//			'order' => array('Page.sort_key' => 'asc')
//		));
//		if (isset($result['Page'])) {
//			Current::$current['TopPage'] = $result['Page'];
//		} else {
//			Current::$current['TopPage'] = null;
//		}
	}

}
