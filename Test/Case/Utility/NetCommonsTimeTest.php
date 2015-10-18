<?php
/**
 * NetCommonsTimeTest
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */


App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('CakeTime', 'Utility');
App::uses('Current', 'NetCommons.Utility');

/**
 * Class NetCommonsTimeTest
 */
class NetCommonsTimeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.site_setting',
		'plugin.users.user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Time = new CakeTime();
		$this->_systemTimezoneIdentifier = date_default_timezone_get();
		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = 2; // ja
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
 * @return void
 */
	protected function _restoreSystemTimezone() {
		date_default_timezone_set($this->_systemTimezoneIdentifier);
	}

/**
 * DateTimeクラスがUnixtime範囲外の日時でもタイムゾーン変換できることを確認
 *
 * @return void
 */
	public function testOutRangeUnixtimeConvert() {
		date_default_timezone_set('UTC');

		$outRange = new DateTime('0000-01-01 00:00:00', new DateTimeZone('UTC'));
		$outRange->setTimezone(new DateTimeZone('Asia/Tokyo'));
		$this->assertEquals('0000-01-01 09:00:00', $outRange->format('Y-m-d H:i:s'));

		$outRange = new DateTime('9999-01-01 00:00:00', new DateTimeZone('UTC'));
		$outRange->setTimezone(new DateTimeZone('Asia/Tokyo'));
		$this->assertEquals('9999-01-01 09:00:00', $outRange->format('Y-m-d H:i:s'));
	}

/**
 * 同一セッション中は別インスタンスでも同じ日時を返すことを確認
 *
 * @return void
 */
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

/**
 * テストのために現在日時を差し替えられることを確認
 *
 * @return void
 */
	public function testNowInjection() {
		$netCommonsTime = new NetCommonsTime();
		$now = $netCommonsTime->getNowDatetime();
		$this->assertNotEquals('2000-01-01 00:00:00', $now);

		// NetCommonsTimeの現在時刻を差し替える
		$nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
		$nowProperty->setAccessible(true);
		$nowProperty->setValue(strtotime('2000-01-01 00:00:00'));

		$time = new NetCommonsTime();
		$sasikaeNowDatetime = $time->getNowDatetime();
		$this->assertEquals('2000-01-01 00:00:00', $sasikaeNowDatetime);
		// new NetCommonsTime()->getNowDatetime() が差し替えた時刻になることを確認
		$nowProperty->setValue(null);
	}

/**
 * 配列中の指定されたキーの値をユーザタイムゾーンに変換するテスト
 *
 * @return void
 */
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

/**
 * 配列中の指定されたキーの値をサーバタイムゾーンに変換するテスト
 *
 * @return void
 */
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

/**
 * SiteTimezoneの取得テスト
 *
 * @return void
 */
	public function testGetSiteTimezone() {
		// NetCommonsTimeの現在時刻を差し替える
		$netCommonsTime = new NetCommonsTime();
		$method = new ReflectionMethod($netCommonsTime, '_getSiteTimezone');
		$method->setAccessible(true);

		$this->getMockForModel('NetCommons.SiteSetting', ['getSiteTimezone'])
			->expects($this->once())
			->method('getSiteTimezone')
			->will($this->returnValue('Asia/Tokyo'));

		$siteTimezone = $method->invoke($netCommonsTime);

		$this->assertEquals('Asia/Tokyo', $siteTimezone);
	}

/**
 * ゲストでUser.timezoneが取得できないときは、NetCommonsTime::_getSiteTimezone()でサイトタイムゾーンを得るのを確認
 *
 * @return void
 */
	public function testGuestConvertCallGetSiteTimezone() {
		Current::$current['User']['timezone'] = null;

		// NetCommonsTime::_getSiteTimezone()が2回呼ばれるはず
		$mock = $this->getMock('NetCommonsTime', ['_getSiteTimezone']);

		$mock->expects($this->exactly(2))
			->method('_getSiteTimezone')
			->will($this->returnValue('Asia/Tokyo'));

		$mock->toServerDatetime('2000-01-01 00:00:00');
		$mock->toUserDatetime('2000-01-01 00:00:00');
	}
}