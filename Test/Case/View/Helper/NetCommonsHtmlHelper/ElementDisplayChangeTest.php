<?php
/**
 * NetCommonsHtmlHelper::elementDisplayChange()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsHtmlHelper::elementDisplayChange()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\NetCommonsHtmlHelper
 */
class NetCommonsHtmlHelperElementDisplayChangeTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 * @see MenuHelperRenderMainTest よりコピー
 */
	public $fixtures = array(
		'plugin.menus.menu_frame_setting',
		'plugin.menus.menu_frames_page',
		'plugin.menus.menu_frames_room',
		'plugin.menus.page4menu',
		'plugin.menus.pages_language4menu',
		'plugin.rooms.room4test',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * viewVarsのデータ取得
 *
 * @param int $pageId ページID
 * @return array
 * @see MenuHelperRenderMainTest よりコピー
 */
	private function __getViewVars($pageId) {
		$MenuFrameSetting = ClassRegistry::init('Menus.MenuFrameSetting');
		$MenuFramesRoom = ClassRegistry::init('Menus.MenuFramesRoom');
		$MenuFramesPage = ClassRegistry::init('Menus.MenuFramesPage');
		$Page = ClassRegistry::init('Pages.Page');

		$roomIds = array('2', '5', '6');
		Current::$current = Hash::insert(Current::$current, 'Page.id', $pageId);

		$viewVars = array();
		$viewVars['menus'] = $MenuFramesPage->getMenuData(array(
			'conditions' => array('Page.room_id' => $roomIds)
		));
		$viewVars['menuFrameSetting'] = $MenuFrameSetting->getMenuFrameSetting();
		$menuFrameRooms = $MenuFramesRoom->getMenuFrameRooms(array(
			'conditions' => array('Room.id' => $roomIds)
		));
		$viewVars['menuFrameRooms'] = Hash::combine($menuFrameRooms, '{n}.Room.id', '{n}');
		$viewVars['pageTreeList'] = $Page->generateTreeList(
			array('Page.room_id' => $roomIds), null, null, Page::$treeParser);
		$viewVars['treeList4Disp'] = $viewVars['pageTreeList'];
		$viewVars['pages'] = $Page->getPages($roomIds);
		$viewVars['parentPages'] = $Page->getPath(Current::read('Page.id'));

		return $viewVars;
	}

/**
 * elementDisplayChange()のテスト
 *
 * @return void
 */
	public function testElementDisplayChange() {
		//Helperロード
		$viewVars = $this->__getViewVars('2');
		$viewVars['parentPages'] = array();
		$requestData = array();
		$params = array(
			// composer.jsonで参照しているmenusプラグインでテスト
			'plugin' => 'menus',
			'controller' => 'menus',
			'action' => 'index',
		);
		$this->loadHelper('NetCommons.NetCommonsHtml', $viewVars, $requestData, $params);

		$this->NetCommonsHtml->_View->helpers[] = 'Menus.Menu';
		$this->NetCommonsHtml->_View->loadHelpers();

		//データ生成
		$displayType = 'major';

		//テスト実施
		$result = $this->NetCommonsHtml->elementDisplayChange($displayType);

		//チェック
		//var_export($result);
		$this->assertNotEmpty($result);
	}
}
