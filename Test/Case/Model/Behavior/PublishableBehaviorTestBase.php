<?php
/**
 * PublishableModel test case base
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Model', 'Model');

/**
 * PublishableModel for test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class PublishableModel extends Model {

/**
 * Table name
 * @var string
 */
	public $useTable = 'publishables';

/**
 * List of behaviors
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Publishable',
	);
}

/**
 * Base class of PublishableBehavior test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class PublishableBehaviorTestBase extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.publishable',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Publishable = ClassRegistry::init('PublishableModel');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Publishable);
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
