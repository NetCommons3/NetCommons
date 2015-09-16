<?php
/**
 * NetCommonsModelTestCase class
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsModelTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 */
class NetCommonsModelTestCase extends NetCommonsCakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$models = array_keys($this->models);
		foreach ($models as $model) {
			//Tracableビヘイビアの削除
			$this->$model->Behaviors->unload('NetCommons.Trackable');
			$this->$model->unbindModel(array('belongsTo' => array('TrackableCreator', 'TrackableUpdater')), false);
		}
	}

}
