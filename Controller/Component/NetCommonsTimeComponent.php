<?php
/**
 * NetCommonsTimeComponent
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Class NetCommonsTimeComponent
 *
 * NetCommonsFormHelper::input()で、typeをdatetimeに指定された項目の値を
 * サーバータイムゾーン（UTC）に変換します。
 *
 * #### サンプルコード(Viewテンプレート)
 * ```
 * <?php
 * 	echo $this->NetCommonsForm->input(
 * 		'publish_start',
 * 		array('type' => 'datetime')
 * 	);
 * ?>
 * ```
 *
 */
class NetCommonsTimeComponent extends Component {

/**
 * @var NetCommonsTime NetCommonsTimeのインスタンス
 */
	protected $_netCommonsTime;

/**
 * コントローラの beforeFilter メソッドの前に呼び出されます。
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->_netCommonsTime = new NetCommonsTime();
		$this->_convertTimezone($controller);
	}

/**
 * ラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->_netCommonsTime, $method), $params);
	}

/**
 * ユーザタイムゾーンからサーバータイムゾーンへの自動変換
 * NetCommonsFormと連携している
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	protected function _convertTimezone(Controller $controller) {
		if (isset($controller->request->data['_NetCommonsTime']['user_timezone'])) {
			$userTimezone = $controller->request->data['_NetCommonsTime']['user_timezone'];
			$convertFieldsString = isset($controller->request->data['_NetCommonsTime']['convert_fields']) ?
				$controller->request->data['_NetCommonsTime']['convert_fields'] :
				'';
			$convertFields = explode(',', $convertFieldsString);
			$controller->request->data = $this->_netCommonsTime->toServerDatetimeArray(
				$controller->request->data,
				$convertFields,
				$userTimezone
			);
		}
	}
}
