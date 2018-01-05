<?php
/**
 * LinkButtonHelper::add()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * LinkButtonHelper::add()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\LinkButtonHelper
 */
class LinkButtonHelperAddTest extends NetCommonsHelperTestCase {

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
		$params = array('controller' => 'net_commons_ctrl');

		//Helperロード
		$this->loadHelper('NetCommons.LinkButton', $viewVars, $requestData, $params);
	}

/**
 * add()のテスト(タイトルテスト)
 *
 * ### 戻り値
 *  - title タイトル
 *  - expectedTitle 期待値のタイトル
 *
 * @return array データ
 */
	public function dataProviderTitle() {
		return array(
			array('title' => '', 'expectedTitle' => __d('net_commons', 'Add')),
			array('title' => 'Input Title', 'expectedTitle' => 'Input Title')
		);
	}

/**
 * add()のテスト
 *
 * @param string $title タイトル
 * @param string $expectedTitle 期待値のタイトル
 * @dataProvider dataProviderTitle
 * @return void
 */
	public function testAddWithTitle($title, $expectedTitle) {
		//データ生成
		$url = null;
		$options = array();

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * add()のテスト(タイトルのエスケープテスト)のDataProvider
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
 * add()のテスト(タイトルのエスケープテスト)
 *
 * @param string $title タイトル
 * @param bool $escapeTitle タイトルをエスケープするか
 * @param string $expectedTitle 期待値のタイトル
 * @dataProvider dataProviderEscapeTitle
 * @return void
 */
	public function testAddWithEscapeTitle($title, $escapeTitle, $expectedTitle) {
		//データ生成
		$url = null;
		$options = array('escapeTitle' => $escapeTitle);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEqual($expected, $result);
	}

/**
 * add()のテスト(アイコンテスト)
 *
 * @return void
 */
	public function testAddWithIcon() {
		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$icon = 'edit';
		$options = array('icon' => $icon);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-' . $icon . '" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEquals($expected, $result);
	}

/**
 * add()のテスト(iconSizeのテスト)
 *
 * @return void
 */
	public function testAddWithIconSize() {
		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$iconSize = 'btn-xs';
		$options = array('iconSize' => $iconSize);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		if ($iconSize) {
			$expectedIconSize = ' ' . $iconSize;
		} else {
			$expectedIconSize = '';
		}
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style' . $expectedIconSize . '">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEqual($expected, $result);
	}

/**
 * add()のテスト(addActionController指定)
 *
 * @return void
 */
	public function testAddWithAddController() {
		//Helperロード
		$viewVars = array(
			'addActionController' => 'add_net_commons_ctrl'
		);
		$requestData = array();
		$params = array('controller' => 'net_commons_ctrl');
		$this->loadHelper('NetCommons.LinkButton', $viewVars, $requestData, $params);

		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$options = array();

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/add_net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEqual($expected, $result);
	}

/**
 * add()のテスト(hiddenTitle=falseのテスト)
 *
 * @return void
 */
	public function testAddWithHiddenTitleFalse() {
		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$options = array('hiddenTitle' => false);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						$expectedTitle .
					'</a>';
		$this->assertEqual($expected, $result);
	}

/**
 * add()のテスト(hiddenTitle=trueのテスト)
 *
 * @return void
 */
	public function testAddWithHiddenTitleTrue() {
		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$options = array('hiddenTitle' => true);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEqual($expected, $result);
	}

/**
 * add()のテスト(hiddenTitle=trueのテスト)
 *
 * @return void
 */
	public function testAddWithHiddenTitleNull() {
		//データ生成
		$title = '';
		$expectedTitle = __d('net_commons', 'Add');
		$url = null;
		$options = array('hiddenTitle' => null);

		//テスト実施
		$result = $this->LinkButton->add($title, $url, $options);

		//チェック
		$expected = '<a href="/net_commons/net_commons_ctrl/add" class="btn btn-success nc-btn-style">' .
						'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' .
						'<span class="hidden-xs">' . $expectedTitle . '</span>' .
					'</a>';
		$this->assertEqual($expected, $result);
	}

}
