<?php
/**
 * NetCommonsの機能に必要な情報を取得する共通クラス
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * NetCommonsの機能に必要な情報を取得する共通クラス
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentAppObject {

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	protected $_controller;

/**
 * インスタンス
 *
 * @var object
 */
	protected static $_instances;

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [];

/**
 * コンストラクター
 *
 * @param Controller|null $controller コントローラ
 * @return void
 */
	public function __construct($controller = null) {
		$this->_controller = $controller;

		foreach ($this->_uses as $class => $classPath) {
			$this->$class = ClassRegistry::init($classPath);
		}
		$this->_langId = Current::read('Language.id');
	}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @param string $className クラス名
 * @return object
 */
	protected static function _getInstance($controller = null, $className = null) {
		if (! $className) {
			return null;
		}
		if (! isset(self::$_instances[$className])) {
			self::$_instances[$className] = new $className($controller);
		}
		if ($controller) {
			self::$_instances[$className]->setController($controller);
		}
		return self::$_instances[$className];
	}

/**
 * インスタンスのクリア
 *
 * @param string $className クラス名
 * @return void
 */
	protected static function _resetInstance($className) {
		if (isset(self::$_instances[$className])) {
			unset(self::$_instances[$className]);
			self::$_instances[$className] = null;
		}
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function setController($controller) {
		$this->_controller = $controller;
	}

}
