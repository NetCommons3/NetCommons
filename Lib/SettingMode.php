<?php
/**
 * SettingModeを操作するライブラリ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');
App::uses('CurrentLib', 'NetCommons.Lib');

/**
 * SettingModeを操作するライブラリ
 *
 * @property NcPermission $NcPermission NcPermissionライブラリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class SettingMode extends LibAppObject {

/**
 * セッティングモードのワード
 *
 * @var string
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * 使用するライブラリ
 *
 * @var array
 */
	public $libs = [
		'NcPermission' => 'NetCommons.Lib',
	];

/**
 * セッティングモードか否か
 *
 * @var bool
 */
	private $__isSettingMode = null;

/**
 * ページのルームIDを保持する
 *
 * @var string ページのルームID(intの文字列)
 */
	private $__pageRoomId = null;

/**
 * インスタンスの取得
 *
 * @return SettingMode
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
 * セッティングモードチェック
 *
 * @return bool
 */
	public function isSettingMode() {
		if (isset($this->__isSettingMode)) {
			return $this->__isSettingMode;
		}

		$tmpSettingMode = CakeSession::read(self::SETTING_MODE_WORD);
		if ($tmpSettingMode !== null) {
			$this->__isSettingMode = $tmpSettingMode;
			return $this->__isSettingMode;
		}

		$pattern = preg_quote('/' . self::SETTING_MODE_WORD . '/', '/');
		if (preg_match('/' . $pattern . '/', Router::url())) {
			$this->__isSettingMode = true;
		} else {
			$this->__isSettingMode = false;
		}
		CakeSession::write(self::SETTING_MODE_WORD, $this->__isSettingMode);

		return $this->__isSettingMode;
	}

/**
 * セッティングモードチェック
 *
 * @param bool|null $settingMode セッティングモードの状態変更
 * @return void
 */
	public function setSettingMode($settingMode) {
		$this->__isSettingMode = $settingMode;
		CakeSession::write(self::SETTING_MODE_WORD, $settingMode);
	}

/**
 * セッティングモードの有無
 *
 * @return bool
 */
	public function hasSettingMode() {
		return $this->NcPermission->read(CurrentLib::read('Page.room_id'), 'page_editable');
	}

}
