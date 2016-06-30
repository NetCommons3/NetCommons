<?php
/**
 * BackToHelper::linkButton()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * BackToHelper::linkButton()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\BackToHelper
 */
class BackToHelperLinkButtonTest extends NetCommonsHelperTestCase {

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

		//Helperロード
		$this->loadHelper('NetCommons.BackTo', $viewVars, $requestData);
	}

/**
 * linkButton()のテスト(タイトルテスト)
 *
 * ### 戻り値
 *  - title タイトル
 *
 * @return array データ
 */
	public function dataProviderTitle() {
		return array(
			array('title' => ''),
			array('title' => 'Input Title')
		);
	}

/**
 * linkButton()のテスト(タイトルテスト)
 *
 * @param string $title タイトル
 * @dataProvider dataProviderTitle
 * @return void
 */
	public function testLinkButtonWithTitle($title) {
		//データ生成
		$url = array('action' => 'edit');
		$options = array();

		//テスト実施
		$result = $this->BackTo->linkButton($title, $url, $options);

		//チェック
		$expected = '<a href="/edit" class="btn btn-default">' .
						'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' . $title .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * linkButton()のテスト(アイコンテスト)
 *
 * ### 戻り値
 *  - icon タイトル
 *
 * @return array データ
 */
	public function dataProviderIcon() {
		return array(
			array('icon' => null),
			array('icon' => false),
			array('icon' => 'edit')
		);
	}

/**
 * linkButton()のテスト(アイコンテスト)
 *
 * @param string $icon アイコン
 * @dataProvider dataProviderIcon
 * @return void
 */
	public function testLinkButtonWithIcon($icon) {
		//データ生成
		$title = '';
		$url = array('action' => 'edit');
		if (isset($icon)) {
			$options = array('icon' => $icon);
		} else {
			$options = array();
			$icon = 'remove';
		}

		//テスト実施
		$result = $this->BackTo->linkButton($title, $url, $options);

		//チェック
		if ($icon) {
			$expected = '<a href="/edit" class="btn btn-default"><span class="glyphicon glyphicon-' . $icon . '" aria-hidden="true"></span> </a>';
		} else {
			$expected = '<a href="/edit" class="btn btn-default"></a>';
		}
		$this->assertEquals($expected, $result);
	}

/**
 * linkButton()のテスト(iconSizeのテスト)のDataProvider
 *
 * ### 戻り値
 *  - iconSize タイトル
 *
 * @return array データ
 */
	public function dataProviderIconSize() {
		return array(
			array('iconSize' => ''),
			array('iconSize' => 'xs')
		);
	}

/**
 * linkButton()のテスト(iconSizeのテスト)
 *
 * @param string $iconSize アイコンサイズ
 * @dataProvider dataProviderIconSize
 * @return void
 */
	public function testLinkButtonWithIconSize($iconSize) {
		//データ生成
		$title = '';
		$url = array('action' => 'edit');
		if (isset($iconSize)) {
			$options = array('iconSize' => $iconSize);
		}

		//テスト実施
		$result = $this->BackTo->linkButton($title, $url, $options);

		//チェック
		if ($iconSize) {
			$expectedIconSize = ' ' . 'btn-' . $iconSize;
		} else {
			$expectedIconSize = '';
		}
		$expected = '<a href="/edit" class="btn btn-default' . $expectedIconSize . '">' .
						'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * linkButton()のテスト(タイトルのエスケープテスト)のDataProvider
 *
 * ### 戻り値
 *  - title タイトル
 *  - escapeTitle タイトルをエスケープするか
 *  - expectedTitle 期待値のタイトル
 *
 * @return array データ
 */
	public function dataProviderEscapeTitle() {
		return array(
			array('title' => '<Input Title>', 'escapeTitle' => true, '&lt;Input Title&gt;'),
			array('title' => '<Input Title>', 'escapeTitle' => false, '<Input Title>')
		);
	}

/**
 * linkButton()のテスト(タイトルのエスケープテスト)
 *
 * @param string $title タイトル
 * @param bool $escapeTitle タイトルをエスケープするか
 * @param string $expectedTitle 期待値のタイトル
 * @dataProvider dataProviderEscapeTitle
 * @return void
 */
	public function testLinkButtonWithEscapeTitle($title, $escapeTitle, $expectedTitle) {
		//データ生成
		$url = array('action' => 'edit');
		$options = array('escapeTitle' => $escapeTitle);

		//テスト実施
		$result = $this->BackTo->linkButton($title, $url, $options);

		//チェック
		$expected = '<a href="/edit" class="btn btn-default">' .
						'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' . $expectedTitle .
					'</a>';
		$this->assertEquals($expected, $result);
	}

}
