<?php
/**
 * TitleIconHelper::_getTitleIconPickerOpenTag()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * TitleIconHelper::_getTitleIconPickerOpenTag()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\TitleIconHelper
 */
class TitleIconHelperGetTitleIconPickerOpenTagTest extends NetCommonsHelperTestCase {

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
 * _getTitleIconPickerOpenTag()のテスト
 *
 * @return void
 */
	public function testGetTitleIconPickerOpenTag() {
		$getTestMethod = new ReflectionMethod($this->TitleIcon, '_getTitleIconPickerOpenTag');
		$getTestMethod->setAccessible(true);
		$result = $getTestMethod->invoke($this->TitleIcon, '/net_commons/img/title_icon/10_010_new.svg');
		$this->assertTextContains('ncTitleIconPickerCtrl', $result);
		$this->assertTextContains('<nc-title-icon-picker', $result);
		$this->assertTextContains('/net_commons/img/title_icon/10_010_new.svg', $result);
	}

}
