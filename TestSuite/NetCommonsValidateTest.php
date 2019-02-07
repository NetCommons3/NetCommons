<?php
/**
 * NetCommonsValidateTest
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
abstract class NetCommonsValidateTest extends NetCommonsModelTestCase {

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
 * Validatesのテスト
 *
 * @param array $data 登録データ
 * @param string $field フィールド名
 * @param string $value セットする値
 * @param string $message エラーメッセージ
 * @param array $overwrite 上書きするデータ
 * @dataProvider dataProviderValidationError
 * @return void
 */
	public function testValidationError($data, $field, $value, $message, $overwrite = array()) {
		$model = $this->_modelName;

		if (is_null($value)) {
			unset($data[$model][$field]);
		} else {
			$data[$model][$field] = $value;
		}
		$data = Hash::merge($data, $overwrite);

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		if ($message === true) {
			// trueでvalidateエラーがあった場合、エラー内容をコンソール出力する。テスト修正のヒントになる
			if (!empty($this->$model->validationErrors)) {
				var_export($this->$model->validationErrors);
			}
			$this->assertTrue($result);
		} else {
			$this->assertFalse($result);
			if ($message) {
				$this->assertEquals($this->$model->validationErrors[$field][0], $message);
			}
		}
	}

}
