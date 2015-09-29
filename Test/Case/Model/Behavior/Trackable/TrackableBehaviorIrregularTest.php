<?php
/**
 * TrackableBehavior association test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TrackableBehaviorTestBase', 'NetCommons.Test/Case/Model/Behavior/Trackable');

/**
 * TrackableBehaviorAssocTest
 */
class TrackableBehaviorIrregularTest extends TrackableBehaviorTestBase {

/**
 * Test call more than once
 */
	public function testCallMoreThanOnce() {
		$this->model->Behaviors->load('NetCommons.Trackable');

		$this->assertTrue(isset($this->model->belongsTo['TrackableCreator']));
		$this->assertTrue(isset($this->model->belongsTo['TrackableUpdater']));
	}

/**
 * Test not has trackable field
 */
	public function testNotHasTrackableField() {
		$userMock = $this->getMockForModel('TrackableUserModel', array('hasField'));
		$userMock->expects($this->any())
			->method('hasField')
			->will($this->returnValue(false));

		$user = $userMock->findById(1);
		$this->assertFalse(isset($user['TrackableCreator']));
		$this->assertFalse(isset($user['TrackableUpdater']));

		$this->_authTrackable('id', '3');
		$userMock->save($user);

		$user = $userMock->findById(1);
		$this->assertEquals('1', $user['TrackableUserModel']['modified_user']);
	}

/**
 * Test not login
 */
	public function testNotLogin() {
		$this->model->create(array('id' => 1, 'title' => 'foobar'));
		$this->model->save();
		$result = $this->model->findById(1);
		$data = $result['TestModel'];

		$this->assertEmpty($data['created_user']);
		$this->assertEquals($data['created_user'], $data['modified_user']);
	}

}
