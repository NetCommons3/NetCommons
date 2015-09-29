<?php
/**
 * Test of PublishableBehavior
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PublishableBehaviorTestBase', 'NetCommons.Test/Case/Model/Behavior/Publishable');

/**
 * Test of PublishableBehavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class PublishableBehaviorTest extends PublishableBehaviorTestBase {

/**
 * Expect PublishableBehavior beforeSave() and afterSave()
 */
	public function testSave() {
		$data = array(
			'title' => 'test1',
			'key' => '',
			'origin_id' => 0
		);

		$this->Publishable->save($data, false);

		//チェック
		$this->assertNotEqual(0, $this->Publishable->find('count', array('recursive' => -1)));
	}

}
