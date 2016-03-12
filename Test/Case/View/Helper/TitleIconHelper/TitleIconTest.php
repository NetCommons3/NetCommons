<?php
/**
 * TitleIconHelper::titleIcon()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * TitleIconHelper::titleIcon()のテスト
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\TitleIconHelper
 */
class TitleIconHelperTitleIconTest extends NetCommonsHelperTestCase {

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
 * titleIcon()のテスト
 *
 * @return void
 */
	public function testTitleIcon() {
		$result = $this->TitleIcon->titleIcon('/net_commons/img/title_icon/10_010_new.svg');
		$this->assertTextContains('<img', $result);
		$this->assertTextContains('/net_commons/img/title_icon/10_010_new.svg', $result);
		$this->assertTextContains('nc-title-icon', $result);
		$this->assertTextContains(__d('net_commons', 'new'), $result);
	}
/**
 * titleIcon()のテスト
 *
 * @return void
 */
	public function testTitleIconNoFile() {
		$result = $this->TitleIcon->titleIcon('');
		$this->assertTextEquals('', $result);
	}
/**
 * titleIcon()のテスト
 *
 * @return void
 */
	public function testTitleIconIllegalFile() {
		$result = $this->TitleIcon->titleIcon('aalalala');
		$this->assertTextEquals('', $result);
	}

}
