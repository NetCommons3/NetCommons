<?php
/**
 * ControlPanelを操作するライブラリ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NcPermission', 'NetCommons.Lib');

/**
 * ControlPanelを操作するライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class LibAppObject {

/**
 * インスタンス
 *
 * @var object
 */
	protected static $_instances;

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	protected $_controller;

/**
 * コンストラクター
 *
 * @return void
 */
	public function __construct() {
	}

/**
 * インスタンスの取得
 *
 * @param string $className クラス名
 * @return object
 */
	protected static function _getInstance($className) {
		if (! isset(self::$_instances[$className])) {
			self::$_instances[$className] = new $className();
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
