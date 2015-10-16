<?php
/**
 * NetCommonsTimeComponent
 */

App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Class NetCommonsTimeComponent
 */
class NetCommonsTimeComponent extends Component {

	protected $_netCommonsTime;

/**
 * コントローラの beforeFilter メソッドの前に呼び出されます。
 *
 * @param Controller $controller コントローラ
 */
	public function initialize(Controller $controller) {
		$this->_netCommonsTime = new NetCommonsTime();
		// このタイミングではCurrentがとれない。ユーザタイムゾーンは不明な状態
		// POSTパラメータにユーザタイムゾーンが書いてあったらどうか？
		// NetCommonsForm::endとかで$this->Form->hidden('user_timezone','Asia/Tokyo')とか入れる
		// $controller->request->data['user_timezone']で変換
		// NetCommonsFormまで食い込むならdatetimeかどうかも分かるよね？-> 継承してるわけでなくラッパだったのでそこまで分からない。
		if (isset($controller->request->data['_NetCommonsTime']['user_timezone'])) {
			$userTimezone = $controller->request->data['_NetCommonsTime']['user_timezone'];
			$convertFields = explode(',', $controller->request->data['_NetCommonsTime']['convert_fields']);
			// TODO BlogEntry.publish_start って形式だとダメなので対応させる
			$controller->request->data = $this->_netCommonsTime->toServerDatetimeArray(
				$controller->request->data,
				$convertFields,
				$userTimezone
			);

		}
	}

/**
 * ラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array(& $this->_netCommonsTime, $method), $params);
	}


/**
 * コントローラの beforeFilter メソッドの後、コントローラの現在のアクションハンドラの前に 呼び出されます。
 *
 * @param Controller $controller コントローラ
 */
	public function startup(Controller $controller) {
		// このタイミングならCurrentでユーザタイムゾーンを取得出来る。
		// しかしbeforeFilter中は$controller->request->data を書き換えできない

	}
}
