<?php
/**
 * DatetimePickerHelper::input()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('DatetimePicker', 'NetCommons.View/Helper');

/**
 * DatetimePickerHelper::input()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperMakeDatetimeOptionsTest extends NetCommonsHelperTestCase {

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
 * @var ReflectionMethod _makeDatetimeOptions()
 */
	protected $_targetMethod;

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
		//$this->loadHelper('NetCommons.DatetimePicker', $viewVars, $requestData, $params);
		$this->loadHelper('NetCommons.DatetimePicker', $viewVars, $requestData, $params);

		//$this->DatetimePicker->create('TestModel');
		$this->DatetimePicker->Form->create('TestModel');
		$this->_targetMethod = new ReflectionMethod($this->DatetimePicker, '_makeDatetimeOptions');
		$this->_targetMethod->setAccessible(true);
	}

/**
 * test optionsにng-modelが指定されてるケース
 *
 * @return void
 */
	public function testNgModelOption() {
		$fieldName = 'publish_start';
		$options = [
			'type' => 'datetime',
			'ng-model' => 'model_publish_start'
		];
		$resultOptions = $this->_targetMethod->invoke($this->DatetimePicker, $fieldName, $options);

		$this->assertArrayHasKey('datetimepicker', $resultOptions);
		$this->assertArrayHasKey('ng-model', $resultOptions);
		$this->assertEquals('model_publish_start', $resultOptions['ng-model']);
		$this->assertArrayNotHasKey('ng-init', $resultOptions);
	}

/**
 * ng-model未指定時のテスト
 *
 * @param string $valueOption options['value']の値
 * @param string $requestData this->request->data[TestModel'][publish_start']の値
 * @param string $defaultOption options['default']の値
 * @param string $ngInitValue ng-initでngModelに渡される値
 * @return void
 * @dataProvider dataProvider4testNoNgModelOption
 */
	public function testNoNgModelOption($valueOption, $requestData, $defaultOption, $ngInitValue) {
		$fieldName = 'publish_start';
		$options = [
			'type' => 'datetime',
		];
		if ($valueOption) {
			$options['value'] = $valueOption;
		}
		if ($requestData) {
			$this->DatetimePicker->request->data['TestModel'][$fieldName] = $requestData;
		}
		if ($defaultOption) {
			$options['default'] = $defaultOption;
		}

		$resultOptions = $this->_targetMethod->invoke($this->DatetimePicker, $fieldName, $options);

		$this->assertArrayHasKey('datetimepicker', $resultOptions);
		$this->assertArrayHasKey('ng-model', $resultOptions);
		$this->assertEquals('NetCommonsFormDatetimePickerModel_TestModel_' . $fieldName, $resultOptions['ng-model']);
		$this->assertArrayHasKey('ng-init', $resultOptions);

		$expect = sprintf('NetCommonsFormDatetimePickerModel_TestModel_%s=\'%s\'',
			$fieldName,
			$ngInitValue
			);
		$this->assertEquals($expect, $resultOptions['ng-init']);
	}

/**
 * dataProvider for testNoNgModelOption
 *
 * @return array
 */
	public function dataProvider4testNoNgModelOption() {
		return [
			// value, request, default, ng-init value
			// ng-initにわたる値はサーバタイム（UTC）からユーザタイム（このテストでは日本時間）に変換されるので+9hになる
			['2016-01-01 00:00:00', null, null, '2016-01-01 09:00:00'], //日本時間になるので+9h
			['2016-01-01 00:00:00', '2016-01-01 01:00:00', '2016-01-01 02:00:00', '2016-01-01 09:00:00'], // valueオプションが一番優先される
			[null, '2016-01-01 01:00:00', '2016-01-01 02:00:00', '2016-01-01 10:00:00'], // valueがなければrequest->dataが優先される
			[null, null, '2016-01-01 02:00:00', '2016-01-01 11:00:00'], // valueオプションもrequest->dataもなければdefaultオプションが優先される
		];
	}
}
