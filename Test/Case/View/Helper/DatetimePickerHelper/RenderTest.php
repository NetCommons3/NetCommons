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

/**
 * DatetimePickerHelper::render()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperRenderTest extends NetCommonsHelperTestCase {

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
		//TODO:必要に応じてセットする
		$viewVars = array();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('NetCommons.DatetimePicker', $viewVars, $requestData, $params);
	}

/**
 * render()のテスト
 *
 * @return void
 */
	public function testRender() {
		//データ生成

		//テスト実施
		$result = $this->DatetimePicker->render();

		//チェック
		//TODO:assertを書く
		debug($result);
	}

}
