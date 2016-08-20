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
App::uses('NetCommonsSecurity', 'NetCommons.Utility');

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
 * @throws ForbiddenException
 * @throws BadRequestException
 */
	public function allowAccess() {
		$controller = $this->controller;

		if (! Configure::read('NetCommons.installed')) {
			return true;
		}

		$netCommonsSecurity = new NetCommonsSecurity();

		//不正IPアドレスチェック
		if (! $netCommonsSecurity->enableBadIps()) {
			throw new BadRequestException('Bad ip address');
		}

		//IP変動の禁止チェック
		if (! $netCommonsSecurity->denyIpMove()) {
			throw new BadRequestException('Bad ip address');
		}

		//サイト閉鎖のチェック
		if ($netCommonsSecurity->isCloseSite($controller->request)) {
			if ($controller->Auth->user()) {
				throw new ForbiddenException('Under maintenance');
			} else {
				$controller->redirect('/net_commons/site_close/index');
				return false;
			}
		}

		return true;
	}

}
