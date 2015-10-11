<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/10/09
 * Time: 13:13
 */
App::uses('AppHelper', 'View/Helper');
App::uses('NetCommonsTime', 'NetCommons.Utility');
/**
 * Class NetCommonsTimeHelper
 */
class NetCommonsTimeHelper extends AppHelper {

/**
 * @var NetCommonsTime
 */
	protected $NetCommonsTime = null;

/**
 * constructer
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 * @return void
 */
	public function __construct(View $View, $settings = array()) {
		$this->NetCommonsTime = new NetCommonsTime();
		parent::__construct($View, $settings);
	}

/**
 * サーバタイムゾーンの日時をユーザタイムゾーンに変換して返す
 *
 * @param string $serverDatetime datetime
 * @return string
 */
	public function toUserDatetime($serverDatetime) {
		return $this->NetCommonsTime->toUserDatetime($serverDatetime);
	}

}