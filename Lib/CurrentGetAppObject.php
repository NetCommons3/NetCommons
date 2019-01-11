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
class CurrentGetAppObject {

/**
 * クラス内で処理するコントローラを保持
 *
 * @var Controller
 */
	protected $_controller;

/**
 * CurrentGetPageインスタンス
 *
 * @var CurrentGetPage
 */
	protected static $_instance;

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [];

/**
 * コンストラクター
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function __construct(Controller $controller) {
		$this->_controller = $controller;

		foreach ($this->_uses as $variant => $className) {
			$this->$variant = ClassRegistry::init($className);
		}

		$this->_langId = Current::read('Language.id');
	}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @param string $className クラス名
 * @return CurrentGetPage
 */
	protected static function _getInstance(Controller $controller, $className) {
		if (! self::$_instance) {
			self::$_instance = new $className($controller);
		}
		return self::$_instance;
	}

}
