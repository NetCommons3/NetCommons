<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/10/09
 * Time: 13:00
 */

//App::uses('CakeTime', 'Utility');

/**
 * Class NetCommonsTime
 *
 * ## テストで時刻を差し替えたいときのサンプルコード
 * ```
 *	$nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
 *	$nowProperty->setAccessible(true);
 *	$nowProperty->setValue(strtotime('2000-01-01 00:00:00'));
 * ```
 */
class NetCommonsTime {

	static protected $_now = null;

	protected function _getSiteTimezone() {
		static $siteTimezone = null;
		if ( $siteTimezone === null) {
			$SiteSetting = ClassRegistry::init('NetCommons.SiteSetting');
			$siteTimezone = $SiteSetting->getSiteTimezone();
		}
		return $siteTimezone;
	}

	// TODO 指定したタイムゾーンに変換するタイプもいる
	public function toUserDatetime($serverDatetime) {
		$userTimezone = Current::read('User.timezone');

		if ($userTimezone === null) {
			$userTimezone = $this->_getSiteTimezone();
		}
		$date = new DateTime($serverDatetime, new DateTimeZone('UTC'));

		$date->setTimezone(new DateTimeZone($userTimezone));
		return $date->format('Y-m-d H:i:s');
	}

	public function toServerDatetime($userDatetime) {
		$userTimezone = Current::read('User.timezone');

		if ($userTimezone === null) {
			$userTimezone = $this->_getSiteTimezone();
		}
		$date = new DateTime($userDatetime, new DateTimeZone($userTimezone));

		$date->setTimezone(new DateTimeZone('UTC'));
		return $date->format('Y-m-d H:i:s');
	}

	public function getNowDatetime() {
		if (self::$_now === null) {
			self::$_now = time();
		}
		return date('Y-m-d H:i:s', self::$_now);
	}
}