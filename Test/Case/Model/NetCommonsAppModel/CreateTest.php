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
		'plugin.net_commons.create_default_value',
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

/**
 * create()でデフォルト値のセットテスト
 *
 * @return void
 */
	public function testCreateDefaultValue() {
		//事前準備
		$Model = ClassRegistry::init('TestNetCommons.TestCreateDefaultValue');

		//テストデータ
		Current::write('Room.id', '1');
		Current::write('Language.id', '2');
		Current::write('Block.id', '3');
		Current::write('Block.key', 'block_key1');
		Current::write('Frame.id', '6');
		Current::write('Frame.key', 'frame_key1');

		$data = array('name' => 'foo');

		//テスト実施
		$newData = $Model->create($data);

		$expected = array(
			'TestCreateDefaultValue' => array(
				'room_id' => '1',
				'language_id' => '2',
				'block_id' => '3',
				'block_key' => 'block_key1',
				'frame_id' => '6',
				'frame_key' => 'frame_key1',
				'plugin_key' => 'test_net_commons',
				'name' => 'foo',
				'created_user' => null,
				'created' => null,
				'modified_user' => null,
				'modified' => null,
			)
		);
		$this->assertEquals($newData, $expected);
	}

/**
 * useTableがfalseの場合、デフォルト値をセットしないテスト
 *
 * @return void
 */
	public function testCreateWOTable() {
		//事前準備
		$Model = ClassRegistry::init('TestNetCommons.TestCreateNotTable');

		//テストデータ
		Current::write('Room.id', '1');
		Current::write('Language.id', '2');
		Current::write('Block.id', '3');
		Current::write('Block.key', 'block_key1');
		Current::write('Frame.id', '6');
		Current::write('Frame.key', 'frame_key1');

		$data = array('name' => 'foo');

		//テスト実施
		$newData = $Model->create($data);

		$expected = array(
			'TestCreateNotTable' => array(
				'name' => 'foo',
			)
		);
		$this->assertEquals($newData, $expected);
	}

}
