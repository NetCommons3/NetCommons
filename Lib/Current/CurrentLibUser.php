<?php
/**
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');
App::uses('AuthComponent', 'Controller/Component');

/**
 * NetCommonsの機能に必要な情報(システム系)を取得する内容をまとめたUtility
 *
 * @property string $_lang 言語ID
 * @property Controller $_controller コントローラ
 * @property Language $Language Languageモデル
 * @property PluginsRole $PluginsRole PluginsRoleモデル
 * @property Plugin $Plugin Pluginモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibUser extends LibAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'User' => 'Users.User'
	];

/**
 * 一度取得したユーザデータを保持
 *
 * @var array|null
 */
	private $__user = null;

/**
 * コンストラクター
 *
 * @param Controller|null $controller コントローラ
 * @return void
 */
	public function __construct($controller = null) {
		parent::__construct($controller);

		if (! $this->_controller->Components->loaded('Session')) {
			$this->_controller->Components->load('Session');
		}

		$this->__user = $this->_controller->Session->read(AuthComponent::$sessionKey);
	}

/**
 * インスタンスの取得
 *
 * @param Controller|null $controller コントローラ
 * @return CurrentLibUser
 */
	public static function getInstance($controller = null) {
		return parent::_getInstance(__CLASS__, $controller);
	}

/**
 * ログイン情報が変わっているか否か
 *
 * @return bool
 */
	public function isLoginChanged() {
		$sessionUser = $this->_controller->Session->read(AuthComponent::$sessionKey);
		if (! $sessionUser) {
			return false;
		}
		if (isset($this->__user) &&
				($this->__user['modified']) !== $sessionUser['modified']) {
			return true;
		} else {
			return false;
		}
	}

/**
 * セッションのログイン情報を再登録する
 *
 * @return void
 */
	public function renewSessionUser() {
		$sessionUser = $this->_controller->Session->read(AuthComponent::$sessionKey);
		$changeUser = $this->User->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'User.id' => $sessionUser['id'],
				'User.modified !=' => $sessionUser['modified'],
			),
		));
		if ($changeUser) {
			$sessionUser = $changeUser['User'];
			unset($changeUser['User']);
			foreach ($changeUser as $key => $value) {
				$this->_controller->Session->write(AuthComponent::$sessionKey . '.' . $key, $value);
			}
		}
		$this->__user = $this->_controller->Session->read(AuthComponent::$sessionKey);
	}

/**
 * ログイン情報の取得
 *
 * @return void
 */
	public function getLoginUser() {
		return $this->__user;
	}

/**
 * ログインしているか否か
 *
 * @return bool
 */
	public function isLogined() {
		return isset($this->__user['id']);
	}

}
