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
abstract class NetCommonsSaveTest extends NetCommonsModelTestCase {

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
 * Key Alias
 *
 * @var array
 */
	protected $_keyAlias = '';

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
		if (! $this->_keyAlias) {
			$this->_keyAlias = $this->$model->alias;
		}

		if (array_key_exists('block_id', $data[$this->$model->alias]) && ! isset($data['Block'])) {
			$this->Block = ClassRegistry::init('Blocks.Block');
			$data['Block'] = $this->Block->find('first', [
				'recursive' => -1,
				'conditions' => ['id' => $data[$this->$model->alias]['block_id']]
			]);
		}

		$created = !isset($data[$this->$model->alias]['id']);

		//チェック用データ取得
		if (! $created) {
			$before = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => $data[$this->$model->alias]['id']),
			));
		} else {
			$max = $this->$model->find('first', array(
				'recursive' => -1,
				'fields' => array('id'),
				'order' => array('id' => 'desc'),
			));
			$before[$this->$model->alias] = array();
		}

		//テスト実行
		$result = $this->$model->$method($data);
		// バリデーションエラー時、出力
		if (!empty($this->$model->validationErrors)) {
			var_export($this->$model->validationErrors);
		}
		$this->assertNotEmpty($result);

		//idのチェック
		if (isset($data[$this->$model->alias]['id'])) {
			$id = $data[$this->$model->alias]['id'];
		} elseif ($max) {
			$id = (string)($max[$this->$model->alias]['id'] + 1);
		} else {
			$id = $this->$model->getLastInsertID();
		}

		//チェック
		$actual = $this->_getActual($id, $created);
		$expected = $this->_getExpected($id, $data, $before, $created);
		$this->assertEquals($expected, $actual);
	}

/**
 * 結果データ取得
 *
 * @param int $id ID
 * @param bool $created 作成かどうか
 * @return array
 */
	protected function _getActual($id, $created) {
		$model = $this->_modelName;

		//登録データ取得
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $id),
		));

		if ($created) {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created_user');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		} else {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		}

		return $actual;
	}

/**
 * 期待値の取得
 *
 * @param int $id ID
 * @param array $data 登録データ
 * @param array $before 登録前データ
 * @param bool $created 作成かどうか
 * @return array
 */
	protected function _getExpected($id, $data, $before, $created) {
		$model = $this->_modelName;

		if ($created && $this->$model->hasField('key')) {
			$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey(
				$this->_keyAlias, $this->$model->useDbConfig
			);
		}

		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias]
		);
		$expected[$this->$model->alias]['id'] = $id;
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');

		if ($this->$model->hasField('is_origin') && ! isset($data[$this->$model->alias]['is_origin'])) {
			$expected[$this->$model->alias]['is_origin'] = true;
			$expected[$this->$model->alias]['is_translation'] = false;
			if ($this->$model->hasField('is_original_copy')) {
				$expected[$this->$model->alias]['is_original_copy'] = false;
			}
		}

		if ($this->$model->hasField('language_id') &&
				! isset($data[$this->$model->alias]['language_id'])) {
			$expected[$this->$model->alias]['language_id'] = '2';
		}

		return $expected;
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
		// バリデーションエラー時、出力。
		// 例外を想定しているのにバリデーションエラーが出来るのは、他クラスの変更が影響している事が多いため、
		// エラー解決のヒントとして表示
		if (!empty($this->$model->validationErrors)) {
			var_export($this->$model->validationErrors);
		}
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
