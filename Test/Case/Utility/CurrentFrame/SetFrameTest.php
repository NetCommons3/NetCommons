<?php
/**
 * CurrentFrame::setFrame()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCurrentUtilityBase', 'NetCommons.TestSuite');
App::uses('CurrentFrame', 'NetCommons.Utility');

/**
 * CurrentFrame::setFrame()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentFrame
 */
class NetCommonsUtilityCurrentFrameSetFrameTest extends NetCommonsCurrentUtilityBase {

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

		$this->CurrentFrame = new CurrentFrame();
	}

/**
 * データなし、リクエストなしのテスト
 *
 * @return void
 */
	public function testNoData() {
		//データ生成
		//$frameId = null;

		//テスト実施
		$this->CurrentFrame->setFrame();

		$expected = array();
		$this->assertEquals(Current::$current, $expected);
	}

/**
 * データなし、リクエストなしのテスト
 *
 * @return void
 */
	public function testPost() {
		//データ生成
		Current::$request->data['Frame']['id'] = '2';

		//テスト実施
		$this->CurrentFrame->setFrame();
var_export(Current::$current);

		$expected = array();
		$this->assertEquals(Current::$current, $expected);
	}

}
