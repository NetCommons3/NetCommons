<?php
/**
 * TrackableBehavior test case base
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('User', 'Users.Model');

/**
 * TrackableUserModel for test case
 */
class TrackableUserModel extends User {

/**
 * Table name
 * @var string
 */
	public $useTable = 'users';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable' => array(
			'userModel' => 'TrackableUserModel',
		),
	);

/**
 * List of hasOne associations
 * @var array
 */
	public $hasOne = array();

/**
 * List of hasMany associations
 * @var array
 */
	public $hasMany = array();

/**
 * List of belongsTo associations
 * @var array
 */
	public $belongsTo = array();

/**
 * List of hasAndBelongsToMany associations
 * @var array
 */
	public $hasAndBelongsToMany = array();

/**
 * List of validation rules
 * @var array
 */
	public $validate = array();
}

/**
 * Base class of TrackableBehavior test case
 */
class TrackableBehaviorTestBase extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.trackable',
		/* 'plugin.net_commons.user' */
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->model = ClassRegistry::init(array(
			'class' => 'TestModel',
			'alias' => 'TestModel',
			'table' => 'trackables',
		));
		$this->model->Behaviors->load('NetCommons.Trackable');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Configure::delete('Trackable.Auth');
		CakeSession::delete('Auth.User');
	}

/**
 * Set user to congifure
 *
 * @param string $userIdField key name
 * @param int $userId useId
 * @return void
 */
	protected function _authTrackable($userIdField = 'id', $userId = 1) {
		Configure::write('Trackable.Auth.User', array($userIdField => $userId));
	}

/**
 * Set user to session
 *
 * @param string $userIdField key name
 * @param int $userId useId
 * @return void
 */
	protected function _authSession($userIdField = 'id', $userId = 1) {
		CakeSession::write('Auth.User', array($userIdField => $userId));
	}

}
