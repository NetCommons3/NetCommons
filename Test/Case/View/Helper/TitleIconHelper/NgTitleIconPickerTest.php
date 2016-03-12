<?php
/**
 * TitleIconHelper::ngTitleIconPicker()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * TitleIconHelper::ngTitleIconPicker()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\TitleIconHelper
 */
class TitleIconHelperNgTitleIconPickerTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.TitleIcon', $viewVars, $requestData, $params);
	}

/**
 * ngTitleIconPicker()のテスト
 *
 * @return void
 */
	public function testNgTitleIconPicker() {
		$result = $this->TitleIcon->ngTitleIconPicker('Test{{testIndex}}.title_icon', 'Test[testIndex].titleIcon', 'test.svg');
		$this->assertTextContains('ng-model="Test[testIndex].titleIcon"', $result);
		$this->assertTextContains('hidden" ng-attr-name="Test{{testIndex}}.title_icon"', $result);
	}

}
