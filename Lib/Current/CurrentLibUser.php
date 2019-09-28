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
App::uses('UserAttributeChoice', 'UserAttributes.Model');

/**
 * NetCommonsの機能に必要な情報(ユーザ)を取得する内容をまとめたUtility
 *
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
	public $uses = [
		'User' => 'Users.User'
	];

/**
 * 一度取得したユーザデータを保持
 *
 * @var array|null
 */
	private $__user = null;

/**
 * インスタンスの取得
 *
 * @return CurrentLibUser
 */
	public static function getInstance() {
		return parent::_getInstance(__CLASS__);
	}

/**
 * インスタンスのクリア
 *
 * @return void
 */
	public static function resetInstance() {
		parent::_resetInstance(__CLASS__);
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		parent::initialize($controller);

		$this->__user = $this->_controller->Auth->user();
		if ($this->isLoginChanged()) {
			$this->renewSessionUser();
		}
	}

/**
 * ログイン情報が変わっているか否か
 *
 * @return bool
 */
	public function isLoginChanged() {
		$sessionUser = $this->__user;
		if (! $sessionUser || !isset($sessionUser['modified'])) {
			return false;
		}

		$latestUser = $this->User->find('first', array(
			'recursive' => -1,
			'fields' => ['modified'],
			'conditions' => array(
				'User.id' => $sessionUser['id'],
			),
			'callbacks' => false,
		));

		if ($latestUser &&
				$latestUser[$this->User->alias]['modified'] !== $sessionUser['modified']) {
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
				//'User.modified !=' => $sessionUser['modified'],
			),
			'callbacks' => false,
		));
		if ($changeUser) {
			$status = (string)$changeUser['User']['status'];
			if ($status === UserAttributeChoice::STATUS_CODE_ACTIVE) {
				foreach ($changeUser['User'] as $key => $value) {
					$this->_controller->Session->write(AuthComponent::$sessionKey . '.' . $key, $value);
				}

				unset($changeUser['User']);
				foreach ($changeUser as $key => $value) {
					$this->_controller->Session->write(AuthComponent::$sessionKey . '.' . $key, $value);
				}
			} else {
				$this->_controller->Session->delete(AuthComponent::$sessionKey);
			}
		}
		$this->__user = $this->_controller->Session->read(AuthComponent::$sessionKey);
	}

/**
 * ログイン情報の取得
 *
 * @return array
 */
	public function getLoginUser() {
		return $this->__user;
	}

/**
 * ログインしているユーザIDの取得
 *
 * @return string|null 数値の文字列
 */
	public function getLoginUserId() {
		if (isset($this->__user['id'])) {
			return $this->__user['id'];
		} else {
			return null;
		}
	}

/**
 * ログインしているユーザのロールキーの取得
 *
 * @return string|null
 */
	public function getLoginUserRoleKey() {
		if (isset($this->__user['role_key'])) {
			return $this->__user['role_key'];
		} else {
			return null;
		}
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
