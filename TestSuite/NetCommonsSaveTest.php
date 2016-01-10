<?php
/**
 * NetCommonsSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsSaveTest extends NetCommonsModelTestCase {

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = '';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = '';

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//チェック用データ取得
		if (isset($data[$this->$model->alias]['id'])) {
			$before = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//idのチェック
		if (isset($data[$this->$model->alias]['id'])) {
			$id = $data[$this->$model->alias]['id'];
		} else {
			$id = $this->$model->getLastInsertID();
		}

		//登録データ取得
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $id),
		));

		if (isset($data[$this->$model->alias]['id'])) {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		} else {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created_user');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');

			if ($this->$model->hasField('key')) {
				$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey($this->$model->name, $this->$model->useDbConfig);
			}
			$before[$this->$model->alias] = array();
		}
		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias],
			array(
				'id' => $id,
			)
		);
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');

		$this->assertEquals($expected, $actual);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnValidationError
 * @return void
 */
	public function testSaveOnValidationError($data, $mockModel, $mockMethod = 'validates') {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);
		$result = $this->$model->$method($data);
		$this->assertFalse($result);
	}

}
