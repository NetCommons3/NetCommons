<?php
/**
 * DatetimePickerHelper::_loadJsFile()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * DatetimePickerHelper::renderScript()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperLoadDatetimePickerTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
 * renderScript()のテスト
 *
 * @return void
 */
	public function testLoadDatetimePicker() {
		// 1度だけelement読み込みが実行される

		// $_loadedScript をfalseにしておく
		$loadedScriptProperty = new ReflectionProperty($this->DatetimePicker, '_loadedScript');
		$loadedScriptProperty->setAccessible(true);
		$loadedScriptProperty->setValue($this->DatetimePicker, false);

		$viewMock = $this->getMock('View', ['element']);
		$viewMock->expects($this->once())
			->method('element')
			->with($this->equalTo('NetCommons.load_datetimepicker'));
		$viewProperty = new ReflectionProperty($this->DatetimePicker, '_View');
		$viewProperty->setAccessible(true);
		$viewProperty->setValue($this->DatetimePicker, $viewMock);

		// 1度 _loadDatetimePicker()をコール -> element呼ばれる
		$this->_testReflectionMethod($this->DatetimePicker, '_loadDatetimePicker');
		// 2回目の _loadDatetimePicker() -> element呼ばれない
		$this->_testReflectionMethod($this->DatetimePicker, '_loadDatetimePicker');
	}

}
