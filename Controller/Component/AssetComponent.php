<?php
/**
 * AssetComponent Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Takako Miyagawa <nekoget@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for AssetComponent Component
 */
class AssetComponent extends Component {

/**
 * 何度も同じデータを取得しないようにキャッシュする
 *
 * @var bool
 */
	private static $__theme = null;

/**
 * cssの存在チェック
 *
 * @param Controller $controller controller object
 * @return bool
 */
	public function isThemeBootstrapMinCss(Controller $controller) {
		$filePath = App::themePath($controller->theme) . 'webroot/css/bootstrap.min.css';
		if (is_file(realpath($filePath))) {
			return true;
		}
		return false;
	}

/**
 * サイトテーマの取得
 *
 * @param Controller $controller controller object
 * @return mix null or array
 */
	public function getSiteTheme(Controller $controller) {
		if (self::$__theme) {
			return self::$__theme;
		}

		$theme = null;
		if (Current::read('Page.theme')) {
			self::$__theme = Current::read('Page.theme');
			return Current::read('Page.theme');
		}

		//@codeCoverageIgnoreStart
		if (empty($controller->Page)) {
			$controller->Page = ClassRegistry::init('Pages.Page');
		}
		//@codeCoverageIgnoreEnd
		if (Current::read('Page.id')) {
			$parentIds = $controller->Page->getPath(Current::read('Page.id'), array('id'));
			$page = $controller->Page->find('first', array(
				'recursive' => -1,
				'fields' => array('theme'),
				'conditions' => array('id' => Hash::extract($parentIds, '{n}.Page.id'), 'theme !=' => null),
				//'order' => array('lft' => 'desc'),
				'order' => array('sort_key' => 'desc'),
			));
			$theme = Hash::get($page, 'Page.theme');
			if ($theme) {
				self::$__theme = $theme;
				return $theme;
			}
		}

		if (! Current::read('Room.id')) {
			$controller->SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
			$theme = $controller->SiteSetting->getSiteTheme();
			self::$__theme = $theme;
			return $theme;
		}

		if (Current::read('Room.theme')) {
			$theme = Current::read('Room.theme');
			self::$__theme = $theme;
			return $theme;
		}

		//@codeCoverageIgnoreStart
		if (empty($controller->Room)) {
			$controller->Room = ClassRegistry::init('Rooms.Room');
		}
		//@codeCoverageIgnoreEnd
		$parentIds = $controller->Room->getPath(Current::read('Room.id'), array('id'));
		$room = $controller->Room->find('first', array(
			'recursive' => -1,
			'fields' => array('theme'),
			'conditions' => array('id' => Hash::extract($parentIds, '{n}.Room.id'), 'theme !=' => null),
			//'order' => array('lft' => 'desc'),
			'order' => array('sort_key' => 'desc'),
		));
		$theme = Hash::get($room, 'Room.theme');
		self::$__theme = $theme;
		return $theme;
	}
}

