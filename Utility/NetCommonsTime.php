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
/**
 * CakeTime instance
 *
 * @var CakeTime
 */
	protected $_engine = null;

	public function __construct() {
		$this->_engine = new CakeTime();
	}

	public function toUserDatetime($serverDatetime) {
		$userTimezone = Current::read('User.timezone');

		if ($userTimezone === null) {
			$userTimezone = 'Asia/Tokyo'; // TODO Siteのデフォルトタイムゾーンを参照するように
		}
		$date = new DateTime($serverDatetime, new DateTimeZone('UTC'));

		$date->setTimezone(new DateTimeZone($userTimezone));
		return $date->format('Y-m-d H:i:s');
	}

	public function toServerDatetime($userDatetime) {
		$userTimezone = Current::read('User.timezone');

		if ($userTimezone === null) {
			$userTimezone = 'Asia/Tokyo'; // TODO Siteのデフォルトタイムゾーンを参照するように
		}
		$date = new DateTime($userDatetime, new DateTimeZone($userTimezone));

		$date->setTimezone(new DateTimeZone('UTC'));
		return $date->format('Y-m-d H:i:s');

	}
}