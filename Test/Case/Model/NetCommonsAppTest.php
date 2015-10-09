<?php
/**
 * NetCommonsApp Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsApp', 'NetCommons.Model');
App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * Summary for NetCommonsApp Test Case
 */
class NetCommonsAppTest extends NetCommonsCakeTestCase {

/**
 * @var array fixture
 */
	public $fixtures = array(
		'plugin.net_commons.site_setting',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		//$this->NetCommonsApp = ClassRegistry::init('NetCommons.NetCommonsApp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//unset($this->NetCommonsApp);

		parent::tearDown();
	}

/**
 * createでnot nullカラムのデフォルトがnullにならないこと
 *
 * @see https://github.com/NetCommons3/NetCommons3/issues/7
 * @return void
 */
	public function testNotNullFieldDefaultIsNotNull() {
		$SiteSetting = ClassRegistry::init('NetCommons.SiteSetting');
		$newData = $SiteSetting->create();

		// Tableでnot null なカラムにnullがセットされちゃダメ
		$this->assertNotNull($newData['SiteSetting']['key']);
		$this->assertNotNull($newData['SiteSetting']['label']);

		// CurrentがあればCurrentで上書きされる
		App::uses('Current', 'NetCommons.Utility');
		Current::$current['Language']['id'] = 5;
		$newDataWithCurrent = $SiteSetting->create();
		$this->assertEquals(5, $newDataWithCurrent['SiteSetting']['language_id']);

		// $data が渡れれば$dataを優先する
		$data = array();
		$data['SiteSetting']['language_id'] = 10;
		$newDataWithCurrent = $SiteSetting->create($data);
		$this->assertEquals(10, $newDataWithCurrent['SiteSetting']['language_id']);
	}

}
