<?php
/**
 * TestCreateAllProfile Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * TestCreateAllProfile Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\test_app\TestNetCommons\Controller
 */
class TestCreateProfile extends AppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'create_profiles';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TestCreateUser' => array(
			'className' => 'TestNetCommons.TestCreateUser',
			'foreignKey' => 'user_id',
		),
	);

}
