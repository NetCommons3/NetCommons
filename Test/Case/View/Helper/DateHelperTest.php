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

/**
 * Summary for DateHelper Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\NetCommons\Test\View\Helper
 */
class DateHelperTest extends CakeTestCase {

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
		$lastDate = date('Y-m-d H:i:s', strtotime("- 1 days"));
		$testDate = $this->Date->dateFormat($lastDate);

		$expected = date('m/d', strtotime($lastDate));

		$this->assertEquals($expected, $testDate);
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
