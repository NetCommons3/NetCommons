<?php
/**
 * 後で削除
 *
 * NetCommonsWorkflow Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * NetCommonsWorkflow Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsWorkflowComponent extends Component {

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	//public function initialize(Controller $controller) {
	//	$this->controller = $controller;
	//}

/**
 * Parse content status from request
 *
 * @throws BadRequestException
 * @return mixed status on success, false on error
 */
	//public function parseStatus() {
	//	if ($matches = preg_grep('/^save_\d/', array_keys($this->controller->data))) {
	//		list(, $status) = explode('_', array_shift($matches));
	//	} else {
	//		if ($this->controller->request->is('ajax')) {
	//			$this->controller->renderJson(
	//				['error' => ['validationErrors' => ['status' => __d('net_commons', 'Invalid request.')]]],
	//				__d('net_commons', 'Bad Request'), 400
	//			);
	//		} else {
	//			throw new BadRequestException(__d('net_commons', 'Bad Request'));
	//		}
	//		return false;
	//	}
	//
	//	return $status;
	//}
}
