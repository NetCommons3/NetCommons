<?php

/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/10/09
 * Time: 14:33
 */

App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('CakeTime', 'Utility');
class NetCommonsTimeTest extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Time = new CakeTime();
		$this->_systemTimezoneIdentifier = date_default_timezone_get();
		Configure::write('Config.language', 'eng');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Time);
		$this->_restoreSystemTimezone();
	}

/**
 * Restored the original system timezone
 *
 * @param string $timezoneIdentifier Timezone string
 * @return void
 */
	protected function _restoreSystemTimezone() {
		date_default_timezone_set($this->_systemTimezoneIdentifier);
	}

	public function testCakeTimeOutOfUnixtime(){
		date_default_timezone_set('UTC');
		$serverDatetime = $this->Time->toServer('0001-01-01 00:00:00', 'Asia/Tokyo');
		debug($serverDatetime);
		$serverDatetime = $this->Time->toServer('2000-01-01 00:00:00', 'Asia/Tokyo');
		debug($serverDatetime);
		$serverDatetime = $this->Time->toServer('3000-01-01 00:00:00', 'Asia/Tokyo');
		debug($serverDatetime);
	}
}