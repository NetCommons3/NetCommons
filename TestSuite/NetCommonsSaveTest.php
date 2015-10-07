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
 * WorkflowSaveTest
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 */
class NetCommonsSaveTest extends NetCommonsModelTestCase {

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data, $model, $method) {
		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $model, $method, $mockModel, $mockMethod) {
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $method メソッド
 * @dataProvider dataProviderSaveOnValidationError
 * @return void
 */
	public function testSaveOnValidationError($data, $model, $method, $mockModel) {
		$this->_mockForReturnFalse($model, $mockModel, 'validates');
		$result = $this->$model->$method($data);
		$this->assertFalse($result);
	}

/**
 * Validatesのテスト
 *
 * @param array $data 登録データ
 * @param string $model モデル名
 * @param string $field フィールド名
 * @param string $value セットする値
 * @param string $message エラーメッセージ
 * @param array $overwrite 上書きするデータ
 * @dataProvider dataProviderValidationError
 * @return void
 */
	public function testValidationError($data, $model, $field, $value, $message, $overwrite = array()) {
		if (is_null($value)) {
			unset($data[$model][$field]);
		} else {
			$data[$model][$field] = $value;
		}
		$data = Hash::merge($data, $overwrite);

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		$this->assertEquals($this->$model->validationErrors[$field][0], $message);
	}

}
