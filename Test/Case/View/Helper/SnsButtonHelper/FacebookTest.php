<?php
/**
 * SnsButtonHelper::facebook()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * SnsButtonHelper::facebook()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\SnsButtonHelper
 */
class SnsButtonHelperFacebookTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.SnsButton', $viewVars, $requestData, $params);
	}

/**
 * facebook()のテスト
 *
 * @return void
 */
	public function testFacebook() {
		//データ生成
		$permLink = 'http://www.netcommons.org';

		//テスト実施
		$result = $this->SnsButton->facebook($permLink);

		$this->assertContains(sprintf('data-href="%s"', $permLink), $result);
	}

/**
 * scriptセットは1回だけ
 *
 * @return void
 */
	public function testLoadScriptOnce() {
		//データ生成
		$permLink = 'http://www.netcommons.org';

		// 未ロード状態にする
		$loadedProperty = new ReflectionProperty($this->SnsButton, '_loaded');
		$loadedProperty->setAccessible(true);
		$loadedProperty->setValue($this->SnsButton, ['facebook' => false, 'twitter' => false]);

		// HtmlHelper::script()がコールされる
		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['scriptBlock'], [$view, array()]);
		$htmlHelperMock->expects($this->once())
			->method('scriptBlock');
		$this->SnsButton->Html = $htmlHelperMock;

		//テスト実施
		// 1回目はスクリプトセットされる
		$result = $this->SnsButton->facebook($permLink);
		// 1回目はfb-rootがある
		$this->assertContains('<div id="fb-root">', $result);

		// 2回目はスクリプトセットされない
		$htmlHelperMock->expects($this->never())
			->method('scriptBlock');
		$result = $this->SnsButton->facebook($permLink);
		$this->assertNotContains('<div id="fb-root">', $result);
	}

}
