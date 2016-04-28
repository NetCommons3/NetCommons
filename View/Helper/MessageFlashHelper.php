<?php
/**
 * メッセージ表示のためのHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * メッセージ表示のためのHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class MessageFlashHelper extends AppHelper {

/**
 * 使用するHelpers
 *
 * - [NetCommons.NetCommonsHtmlHelper](../../NetCommons/classes/NetCommonsHtmlHelper.html)
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
 * ##### return サンプル
 * - 入力
 * ```
 * echo $this->MessageFlash->description('メッセージ内容');
 * ```
 * - 出力
 * ```
 * <div class="alert alert-info">
 * 		メッセージ内容
 * </div>
 * ```
 */
	public function description($message, $options = array('class' => 'alert alert-info')) {
		if ($message) {
			return $this->NetCommonsHtml->div(null, $message, $options);
		} else {
			return '';
		}
	}

}
