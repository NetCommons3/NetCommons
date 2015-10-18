<?php
/**
 * NetCommonsTimeHelper
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Class NetCommonsTimeHelper
 */
class NetCommonsTimeHelper extends AppHelper {

/**
 * @var NetCommonsTime NetCommonsTimeのインスタンス
 */
	protected $_netCommonsTime = null;

/**
 * コンストラクタ
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 * @return NetCommonsTimeHelper
 */
	public function __construct(View $View, $settings = array()) {
		$this->_netCommonsTime = new NetCommonsTime();
		parent::__construct($View, $settings);
	}

/**
 * NetCommonsTime ラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array(& $this->_netCommonsTime, $method), $params);
	}

}