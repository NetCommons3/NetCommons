<?php
/**
 * NetCommonsFrame Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * NetCommonsFrame Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsRoomRoleComponent extends Component {

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		//model class registry
		$models = array(
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission'
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//デフォルトロールパーミッションの設定
		$controller->set('roomRoleKey', 'visitor');
		$controller->set('rolesRoomId', 0);

		$userId = CakeSession::read('Auth.User.id');
		if ($userId) {
			$roleRoomUser =
					$this->RolesRoomsUser->findByUserId($userId);
			if (! $roleRoomUser) {
				return false;
			}
			if (isset($roleRoomUser['RolesRoom'])) {
				$controller->set('roomRoleKey', $roleRoomUser['RolesRoom']['role_key']);
				$controller->set('rolesRoomId', $roleRoomUser['RolesRoom']['id']);
			}
		}

		$defaultPermissions =
				$this->DefaultRolePermission->findAllByRoleKey($controller->viewVars['roomRoleKey']);
		if (! $defaultPermissions) {
			return false;
		}
		foreach ($defaultPermissions as $defaultPermission) {
			$key = Inflector::variable($defaultPermission['DefaultRolePermission']['permission']);
			$value = $defaultPermission['DefaultRolePermission']['value'];

			$controller->set($key, $value);
		}
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return bool true is success, false is error.
 */
	public function setView(Controller $controller) {
		$userId = CakeSession::read('Auth.User.id');
		if (! $userId) {
			return true;
		}

		$roomRolePermissions =
				$this->RoomRolePermission->findAllByRolesRoomId($controller->viewVars['rolesRoomId']);
		if (! $roomRolePermissions) {
			return false;
		}

		foreach ($roomRolePermissions as $roomRolePermission) {
			$key = Inflector::variable($roomRolePermission['RoomRolePermission']['permission']);
			$value = $roomRolePermission['RoomRolePermission']['value'];

			$controller->set($key, $value);
		}

		return true;
	}
}
