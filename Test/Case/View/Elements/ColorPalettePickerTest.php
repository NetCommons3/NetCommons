<?php
/**
 * View/Elements/NetCommons/color_palette_pickerのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/NetCommons/color_palette_pickerのテスト
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\View\Elements\NetCommons\RenderHeader
 */
class NetCommonsViewElementsColorPalettePickerTest extends NetCommonsControllerTestCase {

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');
		//テストコントローラ生成
		$this->generateNc('TestPlugin.TestPlugin');
	}

/**
 * View/Elements/color_palette_pickerのテスト
 *
 * @return void
 */
	public function testColorPalettePicker() {
		//テスト実行
		$this->_testGetAction('/test_plugin/test_plugin/color_palette_picker',
			array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/color_palette_picker', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains('#F00000', $this->view);
		$this->assertTextContains('#00000F', $this->view);
		$this->assertTextContains('testNgModel', $this->view);
		$this->assertTextContains('testName', $this->view);
	}

}
