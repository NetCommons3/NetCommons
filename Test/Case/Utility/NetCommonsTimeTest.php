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

	public function testNow() {
		$netCommonsTime = new NetCommonsTime();
		$start = $netCommonsTime->getNowDatetime();
		sleep(1);
		$after1secNow = $netCommonsTime->getNowDatetime();
		$this->assertEquals($start, $after1secNow);

		$netCommonsTime2 = new NetCommonsTime();
		$secondInstanceNow = $netCommonsTime2->getNowDatetime();

		$this->assertEquals($start, $secondInstanceNow);
	}

	public function testNowInjection() {
		$netCommonsTime = new NetCommonsTime();
		$now = $netCommonsTime->getNowDatetime();
		// NetCommonsTimeの現在時刻を差し替える
		$nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
		$nowProperty->setAccessible(true);
		$nowProperty->setValue(strtotime('2000-01-01 00:00:00'));

		$time = new NetCommonsTime();
		$sasikaeNowDatetime = $time->getNowDatetime();
		$this->assertEquals('2000-01-01 00:00:00', $sasikaeNowDatetime);
		// new NetCommonsTime()->getNowDatetime() が差し替えた時刻になることを確認
	}

	public function testToUserDatetimeArray() {
		$netCommonsTime = new NetCommonsTime();
		$data = [
			'BlogEntry' => [
				'title' => 'Title',
				'body1' => 'Body',
				'published_datetime' => '2000-01-01 00:00:00',
			]
		];
		Current::$current['User']['timezone'] = 'Asia/Tokyo';

		$userData = $netCommonsTime->toUserDatetimeArray($data, array('published_datetime'));
		$this->assertEquals('2000-01-01 09:00:00', $userData['BlogEntry']['published_datetime']);
	}

	public function testToServerDatetimeArray() {
		$netCommonsTime = new NetCommonsTime();
		$data = [
			'BlogEntry' => [
				'title' => 'Title',
				'body1' => 'Body',
				'published_datetime' => '2000-01-01 09:00:00',
			]
		];
		Current::$current['User']['timezone'] = 'Asia/Tokyo';

		$userData = $netCommonsTime->toServerDatetimeArray($data, array('published_datetime'));
		$this->assertEquals('2000-01-01 00:00:00', $userData['BlogEntry']['published_datetime']);
	}

}