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
class LibAppObject {

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
 * ロードしているか否か
 *
 * @var bool
 */
	protected $_loaded = false;

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [];

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [];

/**
 * コンストラクター
 *
 * @return void
 */
	public function __construct() {
	}

/**
 * ライブラリのロード
 *
 * @param array $libs ロードするライブラリ群
 * @return void
 */
	protected static function _loadLibs($libs) {
		$newClasses = [];
		foreach ($libs as $class => $path) {
			if (! isset(self::$_instances[$class])) {
				App::uses($class, $path);
				self::$_instances[$class] = self::_getInstance($class);
			}
		}
	}

/**
 * インスタンスの取得
 *
 * @param string|null $className クラス名
 * @return object
 */
	protected static function _getInstance($className = null) {
		if (! $className) {
			return null;
		}
		if (! isset(self::$_instances[$className])) {
			self::$_instances[$className] = new $className();
			self::_loadLibs(self::$_instances[$className]->libs);
			self::$_instances[$className]->load();
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
			$assosiateClasses = array_keys(self::$_instances[$className]->libs);
			foreach ($assosiateClasses as $assosiateClass) {
				if (isset(self::$_instances[$assosiateClass])) {
					self::$_instances[$assosiateClass]->resetInstance();
				}
			}
		}
		if (isset(self::$_instances[$className])) {
			unset(self::$_instances[$className]);
		}
	}

/**
 * ライブラリのロード
 *
 * @return void
 */
	public function load() {
		if ($this->_loaded) {
			return;
		}
		foreach ($this->uses as $class => $classPath) {
			$this->$class = ClassRegistry::init($classPath);
			ClassRegistry::removeObject($class);
		}
		$libs = array_keys($this->libs);
		foreach ($libs as $class) {
			$this->$class = self::$_instances[$class];
		}

		$this->_loaded = true;
	}

/**
 * コントローラのイニシャライズ
 *
 * @param Controller|null $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		$this->_controller = $controller;
	}

}
