<?php
/**
 * DateHelper Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('View', 'View');
App::uses('DateHelper', 'NetCommons.View/Helper');
App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * Summary for DateHelper Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\NetCommons\Test\View\Helper
 */
class DateHelperTest extends NetCommonsCakeTestCase {

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

		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = 2; // ja

		$View = new View();
		$this->Date = new DateHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Date);

		parent::tearDown();
	}

/**
 * testDateFormat method
 *
 * @return void
 */
	public function testDateFormat() {
		$netCommonsTime = new NetCommonsTime();
		$today = $netCommonsTime->getNowDatetime();
		$todayUserDatetime = $netCommonsTime->toUserDatetime($today);

		$testDate = $this->Date->dateFormat($today);

		$expected = date('G:i', strtotime($todayUserDatetime));

		$this->assertEquals($expected, $testDate);
	}

/**
 * testDateFormatNotThisYear method
 *
 * @return void
 */
	public function testDateFormatNotThisYear() {
		$date = '2012-12-12 12:12:12';
		$testDate = $this->Date->dateFormat($date);

		$expected = date('Y/m/d', strtotime($testDate));

		$this->assertEquals($expected, $testDate);
	}

/**
 * testDateFormatLastDate method
 *
 * @return void
 */
	public function testDateFormatLastDate() {
		// 現在時刻を2016-01-02 00:00:00に設定
		$nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
		$nowProperty->setAccessible(true);
		$nowProperty->setValue(strtotime('2016-01-02 00:00:00'));

		// 同じ年なら月/日にフォーマットされる
		$netCommonsTime = new NetCommonsTime();
		$lastDate = '2016-01-01 10:00:00';
		$lastUserDatetime = $netCommonsTime->toUserDatetime($lastDate);

		$testDate = $this->Date->dateFormat($lastDate);

		$expected = date('m/d', strtotime($lastUserDatetime));

		$this->assertEquals($expected, $testDate);

		$nowProperty->setValue(null); // 現在日時変更が他のテストに影響を与えないようにnullに
	}

/**
 * testDateFormatIncrrectDate method
 *
 * @return void
 */
	public function testDateFormatIncrrectDate() {
		$testDate = $this->Date->dateFormat('incrrect date');
		$this->assertEquals(null, $testDate);
	}
}
