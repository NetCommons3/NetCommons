<?php
/**
 * TitleIconHelper::inputWithTitleIcon()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * TitleIconHelper::inputWithTitleIcon()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\TitleIconHelper
 */
class TitleIconHelperInputWithTitleIconTest extends NetCommonsHelperTestCase {

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
 * inputWithTitleIcon()のテスト
 *
 * @return void
 */
	public function testInputWithTitleIcon() {
		$result = $this->TitleIcon->inputWithTitleIcon('title', 'title_icon');
		$this->assertTextContains('name="data[title]"', $result);
		$this->assertTextContains('name="data[title_icon]"', $result);
		$this->assertTextContains('hidden', $result);
	}

}
