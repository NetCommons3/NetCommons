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
 * コンテンツReadableの定数
 *
 * @var string
 */
	const READABLE_PERMISSION = 'content_readable';

/**
 * チェックタイプの定数
 *
 * @var string
 */
	const CHECK_TYEP_GENERAL_PLUGIN = 'general_plugin',
			CHECK_TYEP_CONTROL_PANEL = 'control_panel',
			CHECK_TYEP_USER_PLUGIN = 'user_plugin',
			CHECK_TYEP_ROOM_PLUGIN = 'room_plugin',
			CHECK_TYEP_SYSTEM_PLUGIN = 'system_plugin';

/**
 * チェックタイプ
 *
 * @var string
 */
	public $type = self::CHECK_TYEP_GENERAL_PLUGIN;

/**
 * コントローラのアクセス許可リスト
 *
 * #### 設定方法
 *   array('action1' => 'permission', 'action2' => 'permission', 'action3' => 'permission' ...)
 *     or
 *   array('action1,action2,action3 ...' => 'permission')
 *     or
 *   array('*' => 'permission')
 *
 *   Null: ログインなし
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
		foreach ($this->allow as $allow => $permission) {
			if (isset($permission) && ! is_array($permission)) {
				$permission = array($permission);
			}

			if ($allow === '*') {
				$allow = implode(',', $controller->methods);
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

				if (count($allowActions[$action]) === 0) {
					$allowActions[$action] = array(self::READABLE_PERMISSION);
				}
			}
		}
		//$allowActionKeys = array_keys($allowActions);
		//foreach ($allowActionKeys as $action) {
		//	if (! isset($allowActions[$action])) {
		//		break;
		//	}
		//	if (count($allowActions[$action]) === 0) {
		//		$allowActions[$action] = array(self::READABLE_PERMISSION);
		//	}
		//}
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
		switch ($this->type) {
			case self::CHECK_TYEP_SYSTEM_PLUGIN:
				if (Current::allowSystemPlugin($controller->params['plugin'])) {
					return;
				}
				break;
			case self::CHECK_TYEP_CONTROL_PANEL:
				if (Current::hasControlPanel()) {
					return;
				}
				break;
			case self::CHECK_TYEP_GENERAL_PLUGIN:
				if (! isset($this->allow[$controller->params['action']])) {
					return;
				}
				if (Current::permission($this->allow[$controller->params['action']])) {
					return;
				}
				break;
		}

		throw new ForbiddenException(__d('net_commons', 'Permission denied'));
	}
}
