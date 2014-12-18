<?php
/**
 * TrackableBehavior association test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TrackableBehaviorTestBase', 'NetCommons.Test/Case/Model/Behavior');

/**
 * TrackableBehaviorAssocTest
 */
class TrackableBehaviorAssocTest extends TrackableBehaviorTestBase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.trackable',
		'plugin.net_commons.user',
		'plugin.net_commons.trackables_user'
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->_authTrackable('id', 5);
		$trackables = array(
			'id' => 1,
			'title' => 'foobar',
			'user_id' => 2
		);
		$this->model->create($trackables);
		$this->model->save();

		$this->_authTrackable('id', 6);
		$trackables = array(
			'id' => 2,
			'title' => 'foobar',
			'user_id' => 2
		);
		$this->model->create($trackables);
		$this->model->save();
	}

/**
 * Get user data bound to test model
 *
 * @param string $assocType association type
 * @return array user data
 */
	private function __getUserBoundTestModel($assocType) {
		$User = ClassRegistry::init('TrackableUserModel');
		$User->bindModel(
			array($assocType => array(
					'TestModel' => array(
						'className' => 'TestModel'
					)
				)
			)
		);
		$user = $User->findById(2);

		$this->assertTrue(isset($user['TrackableCreator']));
		$this->assertTrue(isset($user['TrackableUpdater']));
		$this->assertTrue(isset($user['TestModel']));

		return $user;
	}

/**
 * Assert hasMany data
 *
 * @param array $user user data
 * @return void
 */
	private function __assertHasMany($user) {
		$this->assertEquals('2', $user['TrackableCreator']['created_user']);
		$this->assertEquals('2', $user['TrackableUpdater']['modified_user']);
		$this->assertEquals('1', $user['TestModel'][0]['id']);
		$this->assertEquals('2', $user['TestModel'][0]['user_id']);
		$this->assertEquals('5', $user['TestModel'][0]['created_user']);
		$this->assertEquals('5', $user['TestModel'][0]['modified_user']);
		$this->assertEquals('2', $user['TestModel'][1]['id']);
		$this->assertEquals('2', $user['TestModel'][1]['user_id']);
		$this->assertEquals('6', $user['TestModel'][1]['created_user']);
		$this->assertEquals('6', $user['TestModel'][1]['modified_user']);
	}

/**
 * Test belongsTo
 */
	public function testBelongsTo() {
		$this->model->bindModel(
			array('belongsTo' => array(
					'TrackableUserModel' => array(
						'className' => 'TrackableUserModel',
						'foreignKey' => 'user_id'
					)
				)
			)
		);
		$trackables = $this->model->findById(1);

		$this->assertTrue(isset($trackables['TrackableCreator']));
		$this->assertTrue(isset($trackables['TrackableUpdater']));
		$this->assertTrue(isset($trackables['TrackableUserModel']));

		$this->assertEquals('5', $trackables['TrackableCreator']['created_user']);
		$this->assertEquals('5', $trackables['TrackableUpdater']['modified_user']);
		$this->assertEquals('2', $trackables['TrackableUserModel']['id']);
		$this->assertEquals('2', $trackables['TrackableUserModel']['id']);
		$this->assertEquals('2', $trackables['TrackableUserModel']['modified_user']);
	}

/**
 * Test hasOne
 */
	public function testHasOne() {
		$user = $this->__getUserBoundTestModel('hasOne');

		$this->assertEquals('2', $user['TrackableCreator']['created_user']);
		$this->assertEquals('2', $user['TrackableUpdater']['modified_user']);
		$this->assertEquals('1', $user['TestModel']['id']);
		$this->assertEquals('2', $user['TestModel']['user_id']);
		$this->assertEquals('5', $user['TestModel']['created_user']);
		$this->assertEquals('5', $user['TestModel']['modified_user']);
	}

/**
 * Test hasMany
 */
	public function testHasMany() {
		$user = $this->__getUserBoundTestModel('hasMany');
		$this->__asserthasMany($user);
	}

/**
 * Test hasAndBelongsToMany
 */
	public function testHasAndBelongsToMany() {
		$user = $this->__getUserBoundTestModel('hasAndBelongsToMany');
		$this->__asserthasMany($user);
	}

}
