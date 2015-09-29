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
 * data
 *
 * @var array
 */
	public $data = null;

/**
 * Test case of notBlank
 *
 * @var array
 */
	public $validateNotBlank = array(
		null, '', false,
	);

/**
 * Test case of boolean
 *
 * @var array
 */
	public $validateBoolean = array(
		null, '', 'a', '99', 'false', 'true'
	);

/**
 * Test case of numeric
 *
 * @var array
 */
	public $validateNumeric = array(
		null, '', 'abcde', false, true, '123abcd', 'false', 'true'
	);

/**
 * Test case of workflow status
 *
 * @var array
 */
	public $validateWfStatus = array(
		null, '', -1, 0, 5, 9999, 'abcde', false,
	);

/**
 * Test case of postal
 *
 * @var array
 */
	public $validatePostal = array(
		'9999-999', 'abc-defg', 'abcdefg', '9999999'
	);

/**
 * Test case of prefecture
 *
 * @var array
 */
	public $validatePrefecture = array(
		'00', '48', '9999', 'ab', 'abcd', '--'
	);

/**
 * Test case of phone
 *
 * @var array
 */
	public $validatePhone = array(
		'0123456789', 'abcdefghij',
		'99-9999-9999', 'ab-cdef-ghij',
		'99(9999)9999', 'ab(cdef)ghij', '01(2345)6789', '  (    )    ',
		'+08-01-2345-6789',
	);

/**
 * Test case of email
 *
 * @var array
 */
	public $validateEmail = array(
		'abcdefghij', '9999999',
		'@example.com', 'test@',
		'  @example.com', 'test@    ', 'test@    .com',
	);

/**
 * Test case of url
 *
 * @var array
 */
	public $validateUrl = array(
		'http:', 'https:', 'ftp:', 'javascript:',
		'http:/', 'https:/', 'ftp:/', 'javascript:/',
		'http://', 'https://', 'ftp://', 'javascript://',
		'http://test', 'https://test', 'ftp://test', 'javascript:test', 'abc://exapmle.com',
	);

/**
 * Test case of date
 *
 * @var array
 */
	public $validateDate = array(
		'201405', 'abcdef', '20140512', '2014/05/12', '0000/00', '9999/99',
	);

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
 * Assert data
 *
 * @param array $expected Expected data
 * @param array $result Result data
 * @param array $fields Out of target fields
 * @return void
 */
	protected function _assertData($expected, $result, $fields = ['created', 'created_user', 'modified', 'modified_user']) {
		foreach ($fields as $field) {
			if (is_array($result)) {
				$result = Hash::remove($result, $field);
				$result = Hash::remove($result, '{n}.' . $field);
				$result = Hash::remove($result, '{s}.' . $field);
				$result = Hash::remove($result, '{n}.{n}.' . $field);
				$result = Hash::remove($result, '{n}.{s}.' . $field);
				$result = Hash::remove($result, '{s}.{n}.' . $field);
				$result = Hash::remove($result, '{s}.{s}.' . $field);
			}

			if (is_array($expected)) {
				$expected = Hash::remove($expected, $field);
				$expected = Hash::remove($expected, '{n}.' . $field);
				$expected = Hash::remove($expected, '{s}.' . $field);
				$expected = Hash::remove($expected, '{n}.{n}.' . $field);
				$expected = Hash::remove($expected, '{n}.{s}.' . $field);
				$expected = Hash::remove($expected, '{s}.{n}.' . $field);
				$expected = Hash::remove($expected, '{s}.{s}.' . $field);
			}
		}

		$this->assertEquals($expected, $result);
	}

/**
 * Assert validation
 *
 * @param string $type Validation type
 * @param string $model Model name
 * @param string $field Field name
 * @param bool $unset Field unset
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	protected function _assertValidation($type, $model, $field, $unset = false) {
		if ($type === 'workflowStatus') {
			$type = 'wfStatus';
		}

		$validateName = 'validate' . Inflector::classify($type);

		list($alias, $field) = pluginSplit($field);
		if (! $alias) {
			$alias = $model;
		}

		if ($unset) {
			$data = $this->data;
			unset($data[$alias][$field]);

			//validate処理実行
			$this->__assertValidation($model, $field, $data);
		}

		//テスト実施
		if ($type === 'wfStatus') {
			Current::$current['Permission']['content_publishable']['value'] = false;
			$this->$validateName = Hash::merge($this->$validateName, array(
				WorkflowComponent::STATUS_PUBLISHED,
				WorkflowComponent::STATUS_DISAPPROVED
			));
		}
		foreach ($this->$validateName as $check) {
			$data = $this->data;
			$data[$alias][$field] = $check;

			//validate処理実行
			$this->__assertValidation($model, $field, $data);
		}

		if ($type === 'wfStatus') {
			$currentData = $this->data;

			Current::$current['Permission']['content_publishable']['value'] = true;
			$this->data[$alias][$field] = WorkflowComponent::STATUS_DISAPPROVED;
			$this->_assertValidation('notBlank', $model, 'Comment.comment', true);

			$this->data = $currentData;
		}
	}

/**
 * Assert validation
 *
 * @param string $model Model name
 * @param string $field Field name
 * @param array $data Target data
 * @return void
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 */
	private function __assertValidation($model, $field, $data) {
		//初期処理
		$this->setUp();

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();

		//戻り値チェック
		$expectMessage = '`' . $field . '` validation error: ' . print_r($data, true);
		$this->assertFalse($result, $expectMessage);
		$this->assertTrue(isset($this->$model->validationErrors[$field][0]), $expectMessage);

		//終了処理
		$this->tearDown();
	}

}
