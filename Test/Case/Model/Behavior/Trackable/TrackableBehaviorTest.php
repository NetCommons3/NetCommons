<?php
/**
 * TrackableBehavior test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TrackableBehaviorTestBase', 'NetCommons.Test/Case/Model/Behavior/Trackable');

/**
 * TrackableBehaviorTest
 */
class TrackableBehaviorTest extends TrackableBehaviorTestBase {

/**
 * testFieldPopulation
 *
 * @param string $authCallback authentication callback method name
 * @return void
 */
	protected function _testFieldPopulation($authCallback) {
		$this->{$authCallback}();

		$this->model->create(array('id' => 1, 'title' => 'foobar'));
		$result = $this->model->save();
		$data = $result['TestModel'];
		$this->assertNotEmpty($data['created_user']);
		$this->assertEquals($data['created_user'], $data['modified_user']);

		unset($data['created_user']);
		unset($data['created']);
		unset($data['modified_user']);
		unset($data['modified']);

		$this->{$authCallback}('id', 2);

		$data['title'] = 'spameggs';
		$this->model->save($data);

		$result = $this->model->findById(1);

		$data = $result['TestModel'];
		$this->assertTrue(array_key_exists('TrackableCreator', $result));
		$this->assertTrue(array_key_exists('TrackableUpdater', $result));
		$this->assertEquals(1, $data['created_user']);
		$this->assertEquals(2, $data['modified_user']);
	}

/**
 * Test model operation using session auth data
 */
	public function testUserDataFromSession() {
		$this->_testFieldPopulation('_authSession');
	}

/**
 * Test model operation using manually setup auth data
 */
	public function testUserDataFromTrackable() {
		$this->_testFieldPopulation('_authTrackable');
	}

/**
 * Test auth data override
 */
	public function testAuthDataOverride() {
		$this->_authTrackable('id', '1');
		$this->_authSession('id', '3');

		$this->model->create(array('id' => 1, 'title' => 'foobar'));
		$this->model->save();
		$result = $this->model->findById(1);
		$data = $result['TestModel'];

		$this->assertNotEmpty($data['created_user']);
		$this->assertEquals($data['created_user'], $data['modified_user']);
		$this->assertEquals('Lorem ipsum dolor sit amet', $result['TrackableCreator']['username']);
	}

/**
 * Test with uncommon/inherited User model
 */
	public function testUncommonInheritedUserModel() {
		$User = ClassRegistry::init('TrackableUserModel');

		$user = $User->findById(1);
		$this->assertTrue(isset($user['TrackableCreator']));
		$this->assertTrue(isset($user['TrackableUpdater']));

		$this->_authTrackable('id', '3');
		$User->save($user);

		$user = $User->findById(1);
		$this->assertEquals('3', $user['TrackableUserModel']['modified_user']);
		$this->assertEquals('3', $user['TrackableUpdater']['id']);
	}

/**
 * Test Trackable saveField
 */
	public function testTrackableSaveField() {
		$User = ClassRegistry::init('TrackableUserModel');

		$user = $User->findById(1);
		$this->assertTrue(isset($user['TrackableCreator']));
		$this->assertTrue(isset($user['TrackableUpdater']));

		$this->_authTrackable('id', 3);
		$User->id = $user['TrackableUserModel']['id'];
		$User->saveField('username', 'Rockstar');
		$user = $User->findById(1);

		$this->assertEquals('Rockstar', $user['TrackableUserModel']['username']);
		$this->assertEquals('3', $user['TrackableUserModel']['modified_user']);
		$this->assertEquals('3', $user['TrackableUpdater']['id']);
	}

}
