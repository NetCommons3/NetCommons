<?php
/**
 * ButtonHelper::cancelAndSaveAndSaveTemp()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * ButtonHelper::cancelAndSaveAndSaveTemp()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\ButtonHelper
 */
class ButtonHelperCancelAndSaveAndSaveTempTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.Button', $viewVars, $requestData, $params);
	}

/**
 * cancelAndSaveAndSaveTemp()のテスト用DataProvider
 *
 * ### 戻り値
 *  - cancelUrl キャンセルURL
 *  - backUrl 戻るURL
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('status' => null, 'contentPublishable' => true,
				'cancelUrl' => null, 'backUrl' => null),

			array('status' => null, 'contentPublishable' => false,
				'cancelUrl' => null, 'backUrl' => null),

			array('status' => '2', 'contentPublishable' => true,
				'cancelUrl' => null, 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => '/workflow/custom_ctrl/index', 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => null, 'backUrl' => null),

			array('status' => '1', 'contentPublishable' => true,
				'cancelUrl' => null, 'backUrl' => '/workflow/workflow_ctrl/back'),
		);
	}

/**
 * cancelAndSaveAndSaveTemp()のテスト
 *
 * @param int $status ステータス
 * @param bool $contentPublishable コンテンツの公開権限
 * @param string $cancelUrl キャンセルURL
 * @param string $backUrl 戻るURL
 * @dataProvider dataProvider
 * @return void
 */
	public function testCancelAndSaveAndSaveTemp($status, $contentPublishable, $cancelUrl, $backUrl) {
		//データ生成
		if ($contentPublishable && $status === '2') {
			$saveTempOptions = array(
				'label' => __d('net_commons', 'Disapproval'),
				'class' => 'btn btn-warning btn-workflow',
				'name' => 'save_4',
			);
		} else {
			$saveTempOptions = array();
		}
		if (! $contentPublishable) {
			$saveOptions = array(
				'label' => __d('net_commons', 'OK'),
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save_2',
			);
		} else {
			$saveOptions = array();
		}
		$cancelOptions = array();

		//テスト実施
		$result = $this->Button->cancelAndSaveAndSaveTemp($cancelUrl, $cancelOptions, $saveTempOptions, $saveOptions, $backUrl);

		//チェック
		if (! $cancelUrl) {
			$cancelUrl = '/';
		}
		$this->__assertButtons($result,
			$cancelUrl, $backUrl,
			($contentPublishable && $status === '2'),
			$contentPublishable
		);
	}

/**
 * cancelAndSaveAndSaveTemp()のチェック
 *
 * @param string $result 結果
 * @param string $cancelUrl キャンセルURL
 * @param string $backUrl 戻るURL
 * @param bool $disapproval 差し戻しかどうか
 * @param bool $approval 決定かどうか
 * @return void
 */
	private function __assertButtons($result, $cancelUrl, $backUrl, $disapproval, $approval) {
		//キャンセルのチェック
		$expected = '<a href="' . $cancelUrl . '" class="btn btn-default btn-workflow">' .
						'<span class="glyphicon glyphicon-remove"></span> ' . __d('net_commons', 'Cancel') .
					'</a>';
		$this->assertTextContains($expected, $result);

		//戻るのチェック
		if ($backUrl) {
			$expected = '<a href="' . $backUrl . '" class="btn btn-default btn-workflow">' .
							'<span class="glyphicon glyphicon-chevron-left"></span> ' . __d('net_commons', 'BACK') .
						'</a>';
			$this->assertTextContains($expected, $result);
		} else {
			$expected = '<span class="glyphicon glyphicon-chevron-left"></span>';
			$this->assertTextNotContains($expected, $result);
		}

		//一時保存のチェック
		$expected = '<button class="btn btn-info btn-workflow" name="save_3" type="submit">' .
						__d('net_commons', 'Save temporally') .
					'</button>';
		if ($disapproval) {
			$this->assertTextNotContains($expected, $result);
		} else {
			$this->assertTextContains($expected, $result);
		}

		//差し戻しのチェック
		$expected = '<button class="btn btn-warning btn-workflow" name="save_4" type="submit">' .
						__d('net_commons', 'Disapproval') .
					'</button>';
		if ($disapproval) {
			$this->assertTextContains($expected, $result);
		} else {
			$this->assertTextNotContains($expected, $result);
		}

		//公開のチェック
		$expected = '<button class="btn btn-primary btn-workflow" name="save_1" type="submit">' .
						__d('net_commons', 'OK') .
					'</button>';
		if ($approval) {
			$this->assertTextContains($expected, $result);
		} else {
			$this->assertTextNotContains($expected, $result);
		}

		//申請のチェック
		$expected = '<button class="btn btn-primary btn-workflow" name="save_2" type="submit">' .
						__d('net_commons', 'OK') .
					'</button>';
		if ($approval) {
			$this->assertTextNotContains($expected, $result);
		} else {
			$this->assertTextContains($expected, $result);
		}
	}

}
