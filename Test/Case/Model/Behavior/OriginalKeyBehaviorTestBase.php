<?php
/**
 * TrackableBehavior test case base
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Model', 'Model');

/**
 * TrackableUserModel for test case
 */
class OriginalKeyModel extends Model {

/**
 * Table name
 * @var string
 */
	public $useTable = 'original_keys';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);
}

/**
 * TrackableUserModel for test case
 */
class OriginalWithoutKeyModel extends Model {

/**
 * Table name
 * @var string
 */
	public $useTable = 'original_without_keys';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);
}

/**
 * Base class of TrackableBehavior test case
 */
class OriginalKeyBehaviorTestBase extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.original_key',
		'plugin.net_commons.original_without_key',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OriginalKey = ClassRegistry::init('OriginalKeyModel');
		$this->OriginalWithoutKey = ClassRegistry::init('OriginalWithoutKeyModel');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OriginalKey);
		unset($this->OriginalWithoutKey);
		parent::tearDown();
	}

/**
 * testTrue
 *
 * @return void
 */
	public function testTrue() {
	}
}
