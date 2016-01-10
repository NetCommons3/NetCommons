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
class NetCommonsDeleteTest extends NetCommonsModelTestCase {

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
 * @param array $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行前のチェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertNotEquals(0, $count);

		if ($associationModels) {
			foreach ($associationModels as $assocModel => $conditions) {
				$count = $this->$model->$assocModel->find('count', array(
					'recursive' => -1,
					'conditions' => $conditions,
				));
				$this->assertNotEquals(0, $count);
			}
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertEquals(0, $count);

		if ($associationModels) {
			foreach ($associationModels as $assocModel => $conditions) {
				$count = $this->$model->$assocModel->find('count', array(
					'recursive' => -1,
					'conditions' => $conditions,
				));
				$this->assertEquals(0, $count);
			}
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
