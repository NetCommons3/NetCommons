<?php
/**
 * NetCommons Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsAppController', 'NetCommons.Controller');
App::uses('SiteSettingUtil', 'SiteManager.Utility');

/**
 * NetCommons Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
class SiteCloseController extends NetCommonsAppController {

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//全てのコンポーネントを外す
		$components = array_keys($this->components);
		foreach ($components as $component) {
			$this->Components->unload($component);
		}
	}

/**
 * サイト閉鎖
 *
 * @return void
 */
	public function index() {
		if (! SiteSettingUtil::read('App.close_site')) {
			return $this->redirect('/');
		}

		$siteName = SiteSettingUtil::read('App.site_name');
		$siteClosingReason = SiteSettingUtil::read('App.site_closing_reason');
		$this->set('siteClosingReason', str_replace('{X-SITE_NAME}', $siteName, $siteClosingReason));
	}

}
