<?php
/**
 * NetCommonsFormHelper::input()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('NetCommonsForm', 'NetCommons.View/Helper');

/**
 * NetCommonsFormHelper::input()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\NetCommonsFormHelper
 */
class NetCommonsFormHelperInputTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.NetCommonsForm', $viewVars, $requestData, $params);
	}

/**
 * input() type=datetimeのテスト
 *
 * @return void
 */
	public function testInputDatetime() {
		//データ生成
		$fieldName = 'publish_start';
		$options = array(
			'type' => 'datetime'
		);

		//テスト実施
		$this->NetCommonsForm->create('TestModel');
		$result = $this->NetCommonsForm->input($fieldName, $options);
		// $resultにinputタグがあること
		$this->assertContains('<input', $result);
		// $resultのinputタグに属性datetimepickerがあること
		$this->assertRegExp('/<input.*?datetimepicker.*?>/', $result);

		$ngModelName = 'NetCommonsFormDatetimePickerModel_TestModel_' . $fieldName;

		// ng-modelチェック
		$this->assertRegExp('/ng-model="' . $ngModelName . '"/', $result);

		// ng-initのチェック
		$this->assertRegExp('/ng-init="' . $ngModelName . '=/', $result);
	}
}
