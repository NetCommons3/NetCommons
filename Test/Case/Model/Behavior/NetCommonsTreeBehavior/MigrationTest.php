<?php
/**
 * NetCommonsTreeBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTreeBehaviorCase', 'NetCommons.TestSuite');
App::uses('NetCommonsTreeModelFixture', 'NetCommons.Test/Fixture');

/**
 * NetCommonsTreeBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Model\Behavior\NetCommonsTreeBehavior
 */
class NetCommonsTreeBehaviorMigrationTest extends NetCommonsTreeBehaviorCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.cake_tree_migration_model',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestNetCommons');
		$this->TestModel = ClassRegistry::init('TestNetCommons.TestNetCommonsTreeMigrationModel');
	}

/**
 * migration()のテスト
 *
 * @return void
 */
	public function testMigration() {
		$result = $this->TestModel->migration();
		$this->assertTrue($result);

		$results = $this->TestModel->find('all', [
			'recursive' => -1,
			'fields' => [
				'id', 'parent_id', 'tree_name', 'weight', 'sort_key', 'child_count'
			],
			'order' => [
				'id' => 'asc'
			],
		]);

		$expected = (new NetCommonsTreeModelFixture())->records;
		foreach ($results as $i => $result) {
			$this->assertEquals($expected[$i], $result[$this->TestModel->alias]);
		}
	}

}
