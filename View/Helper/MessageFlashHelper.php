<?php
/**
 * MessageFlash Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * MessageFlash Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class MessageFlashHelper extends AppHelper {

/**
 * ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsHtml'
	);

/**
 * 画面説明の出力
 *
 * @param string $message メッセージ
 * @param array $options オプション配列
 * @return string HTML出力
 */
	public function description($message, $options = array()) {
		return $this->NetCommonsHtml->div('alert alert-info', $message, $options);
	}

}
