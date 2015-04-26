<?php
/**
 * OriginalKeyBehavior test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('OriginalKeyBehaviorTestBase', 'NetCommons.Test/Case/Model/Behavior');

/**
 * OriginalKeyBehavior test case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class OriginalKeyBehaviorTest extends OriginalKeyBehaviorTestBase {

/**
 * Expect OriginalKeyBehavior beforeSave() and afterSave()
 */
	public function testSave() {
		$data = array(
			'title' => 'test1',
			'key' => '',
			'origin_id' => 0
		);

		$this->OriginalKey->save($data, false);

		//チェック
		$this->assertNotEqual(0, $this->OriginalKey->find('count', array('recursive' => -1)));

		$expected = $this->OriginalKey->find('first', array('recursive' => -1));
		$this->assertNotEmpty($expected[$this->OriginalKey->alias]['key']);
		$this->assertNotEmpty($expected[$this->OriginalKey->alias]['origin_id']);
	}

/**
 * Expect OriginalKeyBehavior on without key field
 */
	public function testSaveWithoutKey() {
		$data = array(
			'title' => 'test1',
			'origin_id' => 0
		);

		$this->OriginalWithoutKey->save($data, false);

		//チェック
		$this->assertNotEqual(0, $this->OriginalWithoutKey->find('count', array('recursive' => -1)));

		$expected = $this->OriginalWithoutKey->find('first', array('recursive' => -1));
		$this->assertNotEmpty($expected[$this->OriginalWithoutKey->alias]['origin_id']);
	}

}
