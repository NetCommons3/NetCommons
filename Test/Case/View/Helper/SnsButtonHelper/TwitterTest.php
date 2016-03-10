<?php
/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * SnsButtonHelper::twitter()のテスト
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\SnsButtonHelper
 */
class SnsButtonHelperTwitterTest extends NetCommonsHelperTestCase {

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
 * twitter()のテスト
 *
 * @return void
 */
	public function testTwitter() {
		//データ生成
		$permLink = 'http://www.netcommons.org';

		//テスト実施
		$result = $this->SnsButton->twitter($permLink);

		//チェック
		$this->assertContains(sprintf('data-url="%s"', $permLink), $result);
		$this->assertContains('twitter-share-button', $result);
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
		$this->SnsButton->twitter($permLink);

		// 2回目はスクリプトセットされない
		$htmlHelperMock->expects($this->never())
			->method('scriptBlock');
		$this->SnsButton->twitter($permLink);
	}

}
