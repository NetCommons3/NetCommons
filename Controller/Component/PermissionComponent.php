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
 * リクエストされたController、もしくは、actionのアクセス許可を、<br>
 * [Currentオブジェクト](https://github.com/NetCommons3/NetCommons3Docs/blob/master/phpdocMd/NetCommons/Current.md#current)
 * の権限から判定します。<br>
 * チェックタイプと許可アクションリストを指定してください。
 *
 * [チェックタイプ](#type)<br>
 * [許可アクションリスト](#allow)
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
	const CHECK_TYEP_GENERAL_PLUGIN = 'general_plugin',
			CHECK_TYEP_CONTROL_PANEL = 'control_panel',
			CHECK_TYEP_SYSTEM_PLUGIN = 'system_plugin';

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
 * @var string
 */
	public $type = self::CHECK_TYEP_GENERAL_PLUGIN;

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
				$Room = ClassRegistry::init('Rooms.Room');
				$spaces = $Room->getSpaces();
				if (! $spaces) {
					$space = Hash::get($spaces, Hash::get(Current::read('Room'), 'space_id'));
					$plugin = Inflector::camelize($space['Space']['plugin_key']);
					$this->SpaceComponent = $controller->Components->load($plugin . '.' . $plugin);
					if (! $this->SpaceComponent->accessCheck($controller)) {
						break;
					}
				}

				if ($this->__allowAction($controller)) {
					return;
				}
				break;
		}

		throw new ForbiddenException(__d('net_commons', 'Permission denied'));
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
}
