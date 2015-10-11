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
 */
class NetCommonsTime {

	protected function _getSiteTimezone() {
		$SiteSetting = ClassRegistry::init('NetCommons.SiteSetting');
		$siteTimezone = $SiteSetting->getSiteTimezone();
		return $siteTimezone;
	}

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
}