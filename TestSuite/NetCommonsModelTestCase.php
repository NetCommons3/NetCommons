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
App::uses('CurrentControlPanel', 'NetCommons.Utility');

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
		(new CurrentControlPanel())->setLanguage();

		if ($this->_modelName) {
			$model = $this->_modelName;
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
		Current::$current = array();
		parent::tearDown();
	}

/**
 * Mockセット(戻り値：false)
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @return void
 */
	protected function _mockForReturnFalse($model, $mockModel, $mockMethod) {
		$this->_mockForReturn($model, $mockModel, $mockMethod, false);
	}

/**
 * Mockセット(戻り値：true)
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @return void
 */
	protected function _mockForReturnTrue($model, $mockModel, $mockMethod) {
		$this->_mockForReturn($model, $mockModel, $mockMethod, true);
	}

/**
 * Mockセット
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param bool $return 戻り値
 * @return void
 */
	protected function _mockForReturn($model, $mockModel, $mockMethod, $return) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		if ($mockModel === $model) {
			$this->$model = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
			$this->$model->expects($this->once())
				->method($mockMethod)
				->will($this->returnValue($return));
		} else {
			$this->$model->$mockModel = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
			$this->$model->$mockModel->expects($this->once())
				->method($mockMethod)
				->will($this->returnValue($return));
		}
	}

}
