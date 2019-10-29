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
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Permission Component
 *
 * リクエストされたController、もしくは、actionのアクセス許可を、<br>
 * [Currentオブジェクト](./Current.html)
 * の権限から判定します。<br>
 * チェックタイプと許可アクションリストを指定してください。
 *
 * [チェックタイプ](#property_type)<br>
 * [許可アクションリスト](#property_allow)
 *
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
	const CHECK_TYPE_GENERAL_PLUGIN = 'general_plugin',
			CHECK_TYPE_CONTROL_PANEL = 'control_panel',
			CHECK_TYPE_SYSTEM_PLUGIN = 'system_plugin',
			CHECK_TYPE_NOCHECK_PLUGIN = 'no_check';

/**
 * チェックタイプ
 *
 * * CHECK_TYEP_GENERAL_PLUGIN<br>
 * ページに配置するプラグインの場合に指定します。（デフォルト）<br>
 * 許可アクションリストに指定された権限から判定します。
 *
 * * CHECK_TYEP_CONTROL_PANEL<br>
 * コントロールパネルを表示する際に指定します。<br>
 * コントロールパネルで動作するプラグインの有無で判定します。
 *
 * * CHECK_TYEP_SYSTEM_PLUGIN<br>
 * 管理プラグインを表示・設定する際に指定します。<br>
 * ユーザーが使用できる管理プラグインか否かで判定します。
 *
 * * CHECK_TYEP_NOCHECK_PLUGIN<br>
 * チェックをスキップする。主にusersプラグインで使用する。
 *
 * @var string
 */
	public $type = self::CHECK_TYPE_GENERAL_PLUGIN;

/**
 * 許可アクションリスト
 *
 * チェックタイプがCHECK_TYEP_GENERAL_PLUGINの場合に使用される判定リストです。<br>
 * アクション名 => 権限名の形式で指定してください。<br>
 * デフォルトでは、indexアクション、viewアクションを許可しています。
 * #### サンプルコード
 * ##### Controller
 * ```
 * public $components = array(
 * 	'NetCommons.Permission' => array(
 * 		'allow' => array(
 * 			'add,edit,delete' => 'content_creatable',
 * 			'reply' => 'content_comment_creatable',
 * 			'approve' => 'content_comment_publishable',
 * 		)
 * 	)
 * )
 * ```
 *
 * アクション名に'＊'を指定するとコントローラ内すべてのアクションが対象になります。
 * ```
 * public $components = array(
 * 	'NetCommons.Permission' => array(
 * 		'allow' => array(
 * 			'*' => 'content_creatable'
 * 		)
 * 	)
 * )
 * ```
 *
 * 権限名にnullを指定するとアクセスが許可されます。
 * ```
 * public $components = array(
 * 	'NetCommons.Permission' => array(
 * 		'allow' => array(
 * 			'add,edit,delete' => 'null'
 * 		)
 * 	)
 * )
 * ```
 *
 * @var array
 */
	public $allow = array('index,view' => null);

/**
 * SpaceComponent
 *
 * @var string|object
 */
	public $SpaceComponent = null;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$allowActions = [];
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
			case self::CHECK_TYPE_SYSTEM_PLUGIN:
				if (Current::allowSystemPlugin($controller->params['plugin'])) {
					return;
				}
				break;
			case self::CHECK_TYPE_CONTROL_PANEL:
				if (Current::hasControlPanel()) {
					return;
				}
				break;
			case self::CHECK_TYPE_GENERAL_PLUGIN:
				if (! $this->checkSpaceAccess($controller)) {
					break;
				}
				if (! $this->__allowAction($controller)) {
					break;
				}
				return;
			case self::CHECK_TYPE_NOCHECK_PLUGIN:
				return;
		}

		//if ($controller->Auth->user('id')) {
			throw new ForbiddenException();
		//} else {
		//	return $controller->redirect($controller->Auth->redirect());
		//}
	}

/**
 * アクションの許可チェック
 *
 * @param Controller $controller Controller with components to startup
 * @return bool
 */
	private function __allowAction(Controller $controller) {
		if (! isset($this->allow[$controller->params['action']])) {
			return true;
		}
		foreach ($this->allow[$controller->params['action']] as $action) {
			if (Current::permission($action)) {
				return true;
			}
		}

		return false;
	}

/**
 * スペースへのアクセスチェック
 *
 * @param Controller $controller Controller with components to startup
 * @return bool
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function checkSpaceAccess(Controller $controller) {
		$Space = ClassRegistry::init('Rooms.Space');
		$getSpaces = $Space->getSpaces();
		$spaces = array();
		foreach ($getSpaces as $space) {
			$spaces[$space['Space']['id']] = $space;
		}
		$curRoom = Current::read('Room');
		if ($spaces && $curRoom) {
			if (empty($this->SpaceComponent)) {
				if (isset($controller->params['space_id'])) {
					//paramsは、Routerでセットされるものなので、
					//その値が入ってるときは、そっちを優先してチェックする。
					//NC3では使用していないが、NC3をカスタマイズした大規模システムの時に使用する場合がある。
					$spaceId = $controller->params['space_id'];
				} else {
					$spaceId = $curRoom['space_id'];
				}
				if (isset($spaces[$spaceId])) {
					$space = $spaces[$spaceId];
					$plugin = Inflector::camelize($space['Space']['plugin_key']);
				} else {
					$plugin = 'PublicSpace';
				}
				$this->SpaceComponent = $controller->Components->load($plugin . '.' . $plugin);
			} elseif (is_string($this->SpaceComponent)) {
				$this->SpaceComponent = $controller->Components->load($this->SpaceComponent);
			}
			$this->SpaceComponent->initialize($controller);
			$this->SpaceComponent->startup($controller);
			if (! method_exists($this->SpaceComponent, 'accessCheck')) {
				return true;
			}
			if (! $this->SpaceComponent->accessCheck($controller)) {
				return false;
			}
		}

		if (! $this->checkBlockAccess($controller)) {
			if (! empty($controller->request->params['requested'])) {
				//フレーム等、setActionから実行された場合、空値を戻すため、return trueとする。
				$controller->setAction('emptyRender');
				return true;
			} else {
				return false;
			}
		}

		return true;
	}

/**
 * ブロックへのアクセスチェック
 *
 * @param Controller $controller Controller with components to startup
 * @return bool
 */
	public function checkBlockAccess(Controller $controller) {
		App::uses('Block', 'Blocks.Model');

		//ブロックがない場合、trueとする
		if (! Current::read('Block')) {
			return true;
		}
		//ブロック編集権限があるか、公開ならTrue
		if (Current::permission('block_editable') ||
				Current::read('Block.public_type') === Block::TYPE_PUBLIC) {
			return true;
		}

		//非公開ならFalse
		if (Current::read('Block.public_type') === Block::TYPE_PRIVATE) {
			return false;
		}

		$now = (new NetCommonsTime())->getNowDatetime();
		if (Current::read('Block.publish_start', '0000-00-00 00:00:00') <= $now &&
				$now < Current::read('Block.publish_end', '9999-99-99 99:99:99')) {
			return true;
		} else {
			return false;
		}
	}

}
