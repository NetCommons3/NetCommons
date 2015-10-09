<?php
/**
 * SiteSettings Test Case
 *
* @author Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link http://www.netcommons.org NetCommons Project
* @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SiteSetting', 'NetCommons.Model');

/**
 * Summary for SiteSettings Test Case
 */
class SiteSettingTest extends CakeTestCase {

/**
 * @var array fixture
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
		$this->SiteSetting = ClassRegistry::init('NetCommons.SiteSetting');
		Configure::write('Config.language', 'ja');
		Current::$current['Language']['id'] = 2; // ja

	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SiteSetting);
		Configure::write('Config.language', null);

		parent::tearDown();
	}

/**
 * test getTimezone
 *
 * @return void
 */
	public function testGetTimezone() {
		$siteTimezone = $this->SiteSetting->getSiteTimezone();
		$this->assertEquals('Asia/Tokyo', $siteTimezone);
	}
}
