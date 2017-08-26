<?php
/**
 * NetCommonsDeleteTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsDeleteTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
abstract class NetCommonsDeleteTest extends NetCommonsModelTestCase {

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
 * Deleteのテスト
 *
 * @param array|string $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;
		if (! $associationModels) {
			$associationModels = array();
		}

		//テスト実行前のチェック
		if (isset($data[$this->$model->alias]['key'])) {
			$keyConditions = array('key' => $data[$this->$model->alias]['key']);
		} elseif (! is_array($data)) {
			$keyConditions = array('key' => $data);
		} else {
			$keyConditions = Hash::flatten($data);
		}
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => $keyConditions,
		));
		$this->assertNotEquals(0, $count);

		foreach ($associationModels as $assocModel => $conditions) {
			if (! is_object($this->$model->$assocModel)) {
				debug('Not defined association model "' . $assocModel . '".');
				continue;
			}
			$count = $this->$model->$assocModel->find('count', array(
				'recursive' => -1,
				'conditions' => $conditions,
			));
			$this->assertNotEquals(0, $count);
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => $keyConditions,
		));
		$this->assertEquals(0, $count);

		foreach ($associationModels as $assocModel => $conditions) {
			$count = $this->$model->$assocModel->find('count', array(
				'recursive' => -1,
				'conditions' => $conditions,
			));
			$this->assertEquals(0, $count);
		}
	}

/**
 * DeleteのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderDeleteOnExceptionError
 * @return void
 */
	public function testDeleteOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

}
