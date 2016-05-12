<?php
/**
 * アクセス制御 Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');
App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('Current', 'NetCommons.Utility');

/**
 * アクセス制御 Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SiteManager\Controller\Component
 */
class AccessCtrlComponent extends Component {

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		parent::initialize($controller);
		$this->controller = $controller;
	}

/**
 * アクセスチェック
 *
 * @return void
 */
	public function allowAccess() {
		$controller = $this->controller;

		if (! Configure::read('NetCommons.installed')) {
			return true;
		}

		$allowUrls = array(
			['plugin' => 'auth', 'controller' => 'auth', 'action' => 'login'],
			['plugin' => 'auth_general', 'controller' => 'auth_general', 'action' => 'login'],
			['plugin' => 'net_commons', 'controller' => 'site_close', 'action' => 'index'],
		);

		foreach ($allowUrls as $url) {
			if ($controller->request->params['plugin'] === $url['plugin'] &&
					$controller->request->params['controller'] === $url['controller'] &&
					$controller->request->params['action'] === $url['action']) {

				return true;
			}
		}

		if (Current::allowSystemPlugin('site_manager')) {
			return true;
		}

		return !(bool)SiteSettingUtil::read('App.close_site');
	}

}
