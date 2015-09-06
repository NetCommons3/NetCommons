<?php
/**
 * Permission Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Permission Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class PermissionComponent extends Component {

/**
 * redable permission
 *
 * @var string
 */
	const READABLE_PERMISSION = 'content_readable';

/**
 * Controller actions for which user validation is required.
 *
 * ####
 *   array('action1' => 'permission', 'action2' => 'permission', 'action3' => 'permission' ...)
 *     or
 *   array('action1,action2,action3 ...' => 'permission')
 *     or
 *   array('*' => 'permission')
 *
 *   Null, it without a login
 *
 * @var array
 */
	public $allow = array('index,view' => null);

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;

		foreach ($this->allow as $allow => $permission) {
			if (isset($permission) && ! is_array($permission)) {
				$permission = array($permission);
			}

			if ($allow === '*') {
				$allow = implode(',', $this->controller->methods);
			}

			$actions = explode(',', $allow);
			foreach ($actions as $action) {
				if (! isset($permission)) {
					$allowActions[$action] = $permission;
					break;
				}

				if (! isset($allowActions[$action])) {
					$allowActions[$action] = array();
				}
				$allowActions[$action] = Hash::merge($allowActions[$action], $permission);
			}
		}
		$allowActionKeys = array_keys($allowActions);
		foreach ($allowActionKeys as $action) {
			if (! isset($allowActions[$action])) {
				break;
			}
			if (count($allowActions[$action]) === 0) {
				$allowActions[$action] = array(self::READABLE_PERMISSION);
			}
		}
		$this->allow = $allowActions;
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		if (! isset($this->allow[$this->controller->params['action']])) {
			return;
		}

		if (Current::permission($this->allow[$this->controller->params['action']])) {
			return;
		}

		throw new ForbiddenException(__d('net_commons', 'Permission denied'));
	}
}
