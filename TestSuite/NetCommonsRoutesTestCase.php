<?php
/**
 * NetCommonsRoutesTestCase class
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsRoutesTestCase class
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsRoutesTestCase extends NetCommonsCakeTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Router::reload();
		Current::isSettingMode(false);
		parent::tearDown();
	}

/**
 * ルーティングのテスト
 *
 * @param string $url URL
 * @param bool|array $expected 期待値
 * @param bool $settingMode セッティングモード
 * @dataProvider dataProvider
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function testRoutes($url, $expected, $settingMode = false) {
		$expected = Hash::merge(array('pass' => [], 'named' => []), $expected);
		Current::isSettingMode($settingMode);

		//テスト実施
		$params = Router::parse($url);
		$params = Hash::remove($params, 'setting');
		if (isset($params['pagePermalink']) && ! isset($expected['pagePermalink'])) {
			$expected['pagePermalink'] = array();
		}
		//チェック
		if (in_array($expected['action'], ['emptyRender', 'throwBadRequest'], true)) {
			$this->assertEquals($expected['action'], $params['action']);
		} else {
			$this->assertEquals($expected, $params);
		}
	}

}
