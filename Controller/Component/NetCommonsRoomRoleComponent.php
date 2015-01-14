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
 * redable permission
 *
 * @var string
 */
	const READABLE_PERMISSION = 'contentReadable';

/**
 * publishable permission
 *
 * @var string
 */
	const PUBLISHABLE_PERMISSION = 'contentPublishable';

/**
 * publishable behavior
 *
 * @var string
 */
	const PUBLISHABLE_BEHAVIOR = 'NetCommons.Publishable';

/**
 * default room_role_key
 *
 * @var string
 */
	const DEFAULT_ROOM_ROLE_KEY = 'visitor';

/**
 * auth allow permission
 *
 * @var string
 */
	const AUTH_ALLOW_PERMISSION = self::READABLE_PERMISSION;

/**
 * default permission
 *
 * @var int
 */
	const DEFAULT_PERMISSION = self::PUBLISHABLE_PERMISSION;

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock'
	);

/**
 * Controller actions for which user validation is required.
 *
 * @var array
 */
	public $allowedActions = array();

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		//model class registry
		$models = array(
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'BlockRolePermission' => 'Blocks.BlockRolePermission'
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}
		//デフォルトロールパーミッションの設定
		$controller->set('roomRoleKey', self::DEFAULT_ROOM_ROLE_KEY);
		$controller->set('rolesRoomId', 0);
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 */
	public function startup(Controller $controller) {
		//ログインなしでもアクセスできるアクションをセット
		$this->allowedActions[self::AUTH_ALLOW_PERMISSION] = $controller->Auth->allowedActions;

		//デフォルト(コンテンツの公開あり)パーミッションでアクセスできるアクションをセット
		if (! isset($this->allowedActions[self::DEFAULT_PERMISSION])) {
			$this->allowedActions[self::DEFAULT_PERMISSION] = $controller->methods;
		}

		//room_roleセット
		$this->setView($controller);

		//ModelにPublishableBehaviorがある場合、Behaviorに値をセットする
		if (is_array($controller->uses)) {
			foreach ($controller->uses as $modelClass) {
				list(, $modelClass) = pluginSplit($modelClass, true);
				if (! $controller->{$modelClass}->actsAs) {
					continue;
				}
				if (in_array(self::PUBLISHABLE_BEHAVIOR, $controller->{$modelClass}->actsAs) ||
						isset($controller->{$modelClass}->actsAs[self::PUBLISHABLE_BEHAVIOR])) {

					$alias = $controller->{$modelClass}->alias;
					$controller->{$modelClass}->Behaviors->Publishable
							->settings[$alias][self::PUBLISHABLE_PERMISSION] = $controller->viewVars[self::PUBLISHABLE_PERMISSION];
				}
			}
		}

		//アクション許可チェック
		$this->_isAllowed($controller);
	}

/**
 * Checks whether current action is accessible without authentication.
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return void
 * @throws ForbiddenException
 */
	protected function _isAllowed(Controller $controller) {
		$action = strtolower($controller->request->params['action']);
		foreach ($this->allowedActions as $permission => $allowedActions) {
			if (isset($controller->viewVars[$permission]) &&
					$controller->viewVars[$permission] &&
					in_array($action, array_map('strtolower', $allowedActions))) {

				return;
			}
		}

		throw new ForbiddenException(__d('net_commons', 'Permission denied'));
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return void
 * @throws InternalErrorException
 */
	public function setView(Controller $controller) {
		$userId = $controller->Auth->user('id');

		$this->__setViewRolesRoomsUser($controller, $userId);

		$this->__setViewDefaultRolePermission($controller);

		$this->__setViewRoomRolePermission($controller, $userId);

		$this->__setViewBlockRolePermission($controller);
	}

/**
 * __setViewRolesRoomsUser
 *
 * @param Controller $controller Instantiating controller
 * @param int $userId users.id
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewRolesRoomsUser($controller, $userId) {
		if (! $userId) {
			return;
		}

		$roleRoomUser =
				$this->RolesRoomsUser->findByUserId($userId);
		if (! $roleRoomUser) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		if (isset($roleRoomUser['RolesRoom'])) {
			$controller->set('roomRoleKey', $roleRoomUser['RolesRoom']['role_key']);
			$controller->set('rolesRoomId', $roleRoomUser['RolesRoom']['id']);
		}
	}

/**
 * __setViewRoomRolePermission
 *
 * @param Controller $controller Instantiating controller
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewDefaultRolePermission($controller) {
		$defaultPermissions =
				$this->DefaultRolePermission->findAllByRoleKey($controller->viewVars['roomRoleKey']);
		if (! $defaultPermissions) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		foreach ($defaultPermissions as $defaultPermission) {
			$key = Inflector::variable($defaultPermission['DefaultRolePermission']['permission']);
			$value = $defaultPermission['DefaultRolePermission']['value'];

			$controller->set($key, $value);
		}
	}

/**
 * __setViewRolesRoomsUser
 *
 * @param Controller $controller Instantiating controller
 * @param int $userId users.id
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewRoomRolePermission($controller, $userId) {
		if (! $userId) {
			return;
		}

		$roomRolePermissions =
				$this->RoomRolePermission->findAllByRolesRoomId($controller->viewVars['rolesRoomId']);
		if (! $roomRolePermissions) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		foreach ($roomRolePermissions as $roomRolePermission) {
			$key = Inflector::variable($roomRolePermission['RoomRolePermission']['permission']);
			$value = $roomRolePermission['RoomRolePermission']['value'];

			$controller->set($key, $value);
		}
	}

/**
 * __setViewBlockRolePermission
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	private function __setViewBlockRolePermission($controller) {
		if (! isset($controller->viewVars['blockKey'])) {
			return;
		}

		$options = array(
			'conditions' => array(
				'roles_room_id' => $controller->viewVars['rolesRoomId'],
				'block_key' => $controller->viewVars['blockKey'],
			)
		);
		$blockRolePermissions = $this->BlockRolePermission->find('all', $options);
		if (! $blockRolePermissions) {
			return;
		}

		foreach ($blockRolePermissions as $blockRolePermission) {
			$key = Inflector::variable($blockRolePermission['BlockRolePermission']['permission']);
			$value = $blockRolePermission['BlockRolePermission']['value'];

			$controller->set($key, $value);
		}
	}

}
