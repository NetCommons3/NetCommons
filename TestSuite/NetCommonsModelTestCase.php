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
 * @codeCoverageIgnore
 */
class NetCommonsModelTestCase extends NetCommonsCakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Current::$current['Language']['id'] = '2';

		$models = array_keys($this->models);
		foreach ($models as $model) {
			//Tracableビヘイビアの削除
			$this->$model->Behaviors->unload('NetCommons.Trackable');
			$this->$model->unbindModel(array('belongsTo' => array('TrackableCreator', 'TrackableUpdater')), false);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = null;
		parent::tearDown();
	}

/**
 * ExceptionErrorのMockセット
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @return void
 */
	protected function _mockForReturnFalse($model, $mockModel, $mockMethod) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		if ($mockModel === $model) {
			$this->$model = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
			$this->$model->expects($this->once())
				->method($mockMethod)
				->will($this->returnValue(false));
		} else {
			$this->$model->$mockModel = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
			$this->$model->$mockModel->expects($this->once())
				->method($mockMethod)
				->will($this->returnValue(false));
		}
	}

}
