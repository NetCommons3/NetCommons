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
class DatetimePickerHelperLoadJsFileTest extends NetCommonsHelperTestCase {

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
	public function testRenderScript() {
		// HtmlHelper::script()がコールされる
		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['script'], [$view, array()]);
		$this->DatetimePicker->Html = $htmlHelperMock;
		//テスト実施
		// HtmlHelper::script()がコールされる
		$htmlHelperMock->expects($this->once())
			->method('script')
			->with(
				$this->stringContains('/net_commons/js/datetime_picker_from_to_link.js'),
				$this->isType('array')
			);

		$loadJsFileMethod = new ReflectionMethod($this->DatetimePicker, '_loadJsFile');
		$loadJsFileMethod->setAccessible(true);
		$loadJsFileMethod->invoke($this->DatetimePicker);
	}

}
