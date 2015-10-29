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
class NetCommonsAppModelCreateAllTest extends NetCommonsCakeTestCase {

/**
 * @var array fixture
 */
	public $fixtures = array(
		'plugin.net_commons.create_group',
		'plugin.net_commons.create_profile',
		'plugin.net_commons.create_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');

		Current::$current['Room']['id'] = '2';
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
 * createAllのassociation(hasOne)のテスト
 *
 * @param array $data createAllの引数
 * @dataProvider dataProviderCreateAllUser
 * @return void
 */
	public function testCreateAllUser($data = array()) {
		$TestCreateUser = ClassRegistry::init('TestNetCommons.TestCreateUser');
		$newData = $TestCreateUser->createAll($data);

		$this->assertNotEmpty($newData['TestCreateUser']);
		$this->assertNotEmpty($newData['TestCreateGroup']);
		$this->assertArrayNotHasKey('TrackableCreator', $newData);
		$this->assertArrayNotHasKey('TrackableUpdater', $newData);

		if (isset($data['TestCreateGroup']['room_id'])) {
			$expected = $data['TestCreateGroup']['room_id'];
		} else {
			$expected = Current::$current['Room']['id'];
		}

		$this->assertEquals($expected, $newData['TestCreateGroup']['room_id']);
	}

/**
 * createAllのassociation(belongTo)のテスト
 *
 * @param array $data createAllの引数
 * @dataProvider dataProviderCreateAllProfile
 * @return void
 */
	public function testCreateAllProfile($data = array()) {
		$TestCreateProfile = ClassRegistry::init('TestNetCommons.TestCreateProfile');
		$newData = $TestCreateProfile->createAll($data);

		$this->assertNotEmpty($newData['TestCreateUser']);
		$this->assertNotEmpty($newData['TestCreateProfile']);
		$this->assertArrayNotHasKey('TrackableCreator', $newData);
		$this->assertArrayNotHasKey('TrackableUpdater', $newData);

		if (isset($data['language_id'])) {
			$expected = $data['language_id'];
		} elseif (isset($data['TestCreateProfile']['language_id'])) {
			$expected = $data['TestCreateProfile']['language_id'];
		} else {
			$expected = Current::$current['Language']['id'];
		}

		$this->assertEquals($expected, $newData['TestCreateProfile']['language_id']);
	}

/**
 * createAllのassociation(hasOne)のDataProvider
 *
 * #### 戻り値
 *  - data createAllの引数
 *
 * @return void
 */
	public function dataProviderCreateAllUser() {
		return array(
			array(),
			array(array('TestCreateGroup' => array('room_id' => '3'))),
		);
	}

/**
 * createAllのassociation(hasOne)のDataProvider
 *
 * #### 戻り値
 *  - data createAllの引数
 *
 * @return void
 */
	public function dataProviderCreateAllProfile() {
		return array(
			array(),
			array(array('language_id' => '2')),
			array(array('TestCreateProfile' => array('language_id' => '4'))),
		);
	}

}
