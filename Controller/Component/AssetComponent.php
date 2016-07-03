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
		$theme = null;
		if (empty($controller->request->params['requested'])) {
			if (Current::read('Page.theme')) {
				return Current::read('Page.theme');
			}

			$controller->Page = ClassRegistry::init('Pages.Page');
			if (Current::read('Page.id')) {
				$parentIds = $controller->Page->getPath(Current::read('Page.id'), array('id'));
				$page = $controller->Page->find('first', array(
					'recursive' => -1,
					'fields' => array('theme'),
					'conditions' => array('id' => Hash::extract($parentIds, '{n}.Page.id'), 'theme !=' => null),
					'order' => array('lft' => 'desc'),
				));
				$theme = Hash::get($page, 'Page.theme');
			}

			if ($theme) {
				return $theme;
			} else {
				$controller->SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
				$theme = $controller->SiteSetting->getSiteTheme();
			}
		}
		return $theme;
	}
}

