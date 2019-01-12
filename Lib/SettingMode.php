<?php
/**
 * Current Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NcPermission', 'NetCommons.Lib');

/**
 * SettingModeを操作するライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class SettingMode {

/**
 * セッティングモードのワード
 *
 * @var string
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * セッティングモードか否か
 *
 * @var bool
 */
	public $isSettingMode = null;

/**
 * ページのルームIDを保持する
 *
 * @var string ページのルームID(intの文字列)
 */
	public $pageRoomId = null;

/**
 * SettingModeインスタンス
 *
 * @var SettingMode
 */
	private static $__instance;

/**
 * コンストラクター
 *
 * @return void
 */
	public function __construct() {
		$this->pageRoomId = Current::read('Page.room_id');
	}

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @param string $className クラス名
 * @return CurrentGetPage
 */
	private static function __getInstance() {
		if (! self::$__instance) {
			$className = __CLASS__;
			self::$__instance = new $className();
		}
		return self::$__instance;
	}

/**
 * セッティングモードチェック
 *
 * @return bool
 */
	public static function isSettingMode() {
		$instance = self::__getInstance();

		if (isset($instance->isSettingMode)) {
			return $instance->isSettingMode;
		}

		$tmpSettingMode = CakeSession::read(self::SETTING_MODE_WORD);
		if ($tmpSettingMode !== null) {
			$instance->isSettingMode = $tmpSettingMode;
			return $instance->isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			$instance->isSettingMode = true;
		} else {
			$instance->isSettingMode = false;
		}
		CakeSession::write(Current::SETTING_MODE_WORD, $instance->isSettingMode);

		return $instance->isSettingMode;
	}

/**
 * セッティングモードチェック
 *
 * @param bool|null $settingMode セッティングモードの状態変更
 * @return bool
 */
	public static function setSettingMode($settingMode) {
		$instance = self::__getInstance();
		$instance->isSettingMode = $settingMode;
		CakeSession::write(Current::SETTING_MODE_WORD, $settingMode);
	}

/**
 * セッティングモードの有無
 *
 * @return bool
 */
	public static function hasSettingMode() {
		$instance = self::__getInstance();
		return NcPermission::permission('page_editable', $this->pageRoomId);
	}

}
