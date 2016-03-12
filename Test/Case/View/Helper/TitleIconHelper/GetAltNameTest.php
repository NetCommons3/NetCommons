<?php
/**
 * TitleIconHelper::_getAltName()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * TitleIconHelper::_getAltName()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\TitleIconHelper
 */
class TitleIconHelperGetAltNameTest extends NetCommonsHelperTestCase {

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
 * _getAltName()のテスト
 *
 * @return void
 */
	public function testGetAltName() {
		// HtmlHelper::script()がコールされる
		$getAltNameMethod = new ReflectionMethod($this->TitleIcon, '_getAltName');
		$getAltNameMethod->setAccessible(true);
		$result = $getAltNameMethod->invoke($this->TitleIcon, '25_001_test.svg');
		$this->assertTextEquals('test', $result);
		$result = $getAltNameMethod->invoke($this->TitleIcon, '20_017_thunders.svg');
		$this->assertTextEquals(__d('net_commons', 'thunders'), $result);
		$result = $getAltNameMethod->invoke($this->TitleIcon, 'test2.svg');
		$this->assertTextEquals('test2', $result);
	}

}
