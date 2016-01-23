<?php
/**
 * NetCommonsApp Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * Summary for NetCommonsApp Test Case
 */
class NetCommonsAppModelCreateTest extends NetCommonsCakeTestCase {

/**
 * @var array fixture
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting',
		'plugin.net_commons.create_profile',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');

		Current::$current['Language']['id'] = '5';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = array();
		parent::tearDown();
	}

/**
 * createでnot nullカラムのデフォルトがnullにならないこと
 *
 * @see https://github.com/NetCommons3/NetCommons3/issues/7
 * @return void
 */
	public function testNotNullFieldDefaultIsNotNull() {
		$SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
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

		// nullを渡すと空が返る
		$newDataWithCurrent = $SiteSetting->create(null);
		$this->assertEmpty($newDataWithCurrent);

		// falseを渡すと空が返る
		$newDataWithCurrent = $SiteSetting->create(false);
		$this->assertEmpty($newDataWithCurrent);
	}

/**
 * create()でモデル名付きの配列を渡すとデフォルト値がセットされなかったバグの修正テスト
 * ```
 * var_dump($this->Announcement->create(array('Announcement' => array(
 * 	'id' => null,
 * ))));
 * var_dump($this->Announcement->create(array(
 * 	'id' => null,
 * )));
 * 上記の結果が同じになるように修正した
 * ```
 *
 * @return void
 */
	public function testCreateWithModelNameData() {
		$TestCreateProfile = ClassRegistry::init('TestNetCommons.TestCreateProfile');
		$data = [
			'name' => 'foo'
		];
		$newData = $TestCreateProfile->create($data);

		$dataWithModelName = [
			'TestCreateProfile' => [
				'name' => 'foo'
			]

		];
		$newDataWithModelName = $TestCreateProfile->create($dataWithModelName);

		$this->assertEquals($newData, $newDataWithModelName);
		$this->assertEquals(5, $newData['TestCreateProfile']['language_id']);
	}
}
