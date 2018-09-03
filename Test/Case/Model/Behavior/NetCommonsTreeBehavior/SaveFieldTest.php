<?php
/**
 * NetCommonsTreeBehavior::saveField()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsTreeBehavior::saveField()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorSaveFieldTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.net_commons_tree_model2',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsTreeModel2');
	}

/**
 * saveField()のテスト
 *
 * @return void
 */
	public function testSave() {
		//テスト実施
		$this->TestModel->id = '5004';
		$result = $this->TestModel->saveField('parent_id', '5002');
		$extected = [
			$this->TestModel->alias => [
				'id' => '5004',
				'parent_id' => '5002',
				'weight' => 1,
				'sort_key' => '~00000001-00001001-00000001',
			],
		];
		$this->assertEquals($extected, $result);

		$results = $this->TestModel->find('all', [
			'recursive' => -1,
			'conditions' => [
				'id' => ['5002', '5003', '5004', '5005']
			],
			'order' => 'sort_key'
		]);

		$extected = [
			0 => [
				$this->TestModel->alias => [
					'id' => '5002',
					'parent_id' => '4001',
					'tree_name' => 'Category 6-1001',
					'weight' => '1001',
					'sort_key' => '~00000001-00001001',
					'child_count' => '2',
				],
			],
			1 => [
				$this->TestModel->alias => [
					'id' => '5004',
					'parent_id' => '5002',
					'tree_name' => 'Category 7',
					'weight' => '1',
					'sort_key' => '~00000001-00001001-00000001',
					'child_count' => '1',
				],
			],
			2 => [
				$this->TestModel->alias => [
					'id' => '5005',
					'parent_id' => '5004',
					'tree_name' => 'Category 7-1',
					'weight' => '1',
					'sort_key' => '~00000001-00001001-00000001-00000001',
					'child_count' => '0',
				],
			],
			3 => [
				$this->TestModel->alias => [
					'id' => '5003',
					'parent_id' => '4001',
					'tree_name' => 'Category 6-1002',
					'weight' => '1002',
					'sort_key' => '~00000001-00001002',
					'child_count' => '0',
				],
			],
		];
	}

}
