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
		$defaultPermissions =
				$this->DefaultRolePermission->findAllByRoleKey('visitor');
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
 * @param int $userId users.id
 * @return bool true is success, false is error.
 */
	public function setView(Controller $controller, $userId = 0) {
		if (! $userId) {
			$userId = CakeSession::read('Auth.User.id');
		}
		if (! $userId) {
			return true;
		}

		$roleRoomUser =
				$this->RolesRoomsUser->findByUserId($userId);
		if (! $roleRoomUser) {
			return false;
		}

		$roomRolePermissions =
				$this->RoomRolePermission->findAllByRolesRoomId($roleRoomUser['RolesRoom']['id']);
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
