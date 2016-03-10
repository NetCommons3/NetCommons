<?php
/**
 * DatetimePickerHelper::render()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * DatetimePickerHelper::render()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperBeforeFormInputTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストデータ生成
		$viewVars = array();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('NetCommons.DatetimePicker', $viewVars, $requestData, $params);
	}

/**
 * datetimePickerがからまないときはoptionsをそのまま返すだけ
 *
 * @return void
 */
	public function testNoDatetimePicker() {
		$fieldName = 'foo';
		$options = array(
			'foo' => 'bar'
		);
		$returnOptions = $this->DatetimePicker->beforeFormInput($fieldName, $options);

		$this->assertEquals($options, $returnOptions);
	}

/**
 * type => datetime だったらdatetimepicker有効
 *
 * @return void
 */
	public function testTypeDatetime() {
		$fieldName = 'foo';
		$options = array(
			'type' => 'datetime'
		);
		$returnOptions = $this->DatetimePicker->beforeFormInput($fieldName, $options);

		$this->assertContains('datetimepicker', $returnOptions);
	}

/**
 * options = array('datetimepicker')でdatetimePickerの関連ファイルがロードされる
 *
 * @return void
 */
	public function testDatetimePickerOptionByValue() {
		$fieldName = 'foo';
		$options = array(
			'type' => 'text',
			'datetimepicker',
		);

		// $_loadedScript をfalseにしておく
		$loadedScriptProperty = new ReflectionProperty($this->DatetimePicker, '_loadedScript');
		$loadedScriptProperty->setAccessible(true);
		$loadedScriptProperty->setValue($this->DatetimePicker, false);

		$this->DatetimePicker->beforeFormInput($fieldName, $options);

		// _loadDatetimePicker()がコールされたことを_loadedScriptで確認
		$this->assertTrue($loadedScriptProperty->getValue($this->DatetimePicker));
	}

/**
 * options = array('datetimepicker' => 'something')でもdatetimePickerの関連ファイルがロードされる
 *
 * @return void
 */
	public function testDatetimePickerOptionByKey() {
		$fieldName = 'foo';
		$options = array(
			'type' => 'text',
			'datetimepicker' => 1,
		);

		// $_loadedScript をfalseにしておく
		$loadedScriptProperty = new ReflectionProperty($this->DatetimePicker, '_loadedScript');
		$loadedScriptProperty->setAccessible(true);
		$loadedScriptProperty->setValue($this->DatetimePicker, false);

		$this->DatetimePicker->beforeFormInput($fieldName, $options);

		// _loadDatetimePicker()がコールされたことを_loadedScriptで確認
		$this->assertTrue($loadedScriptProperty->getValue($this->DatetimePicker));
	}

}
