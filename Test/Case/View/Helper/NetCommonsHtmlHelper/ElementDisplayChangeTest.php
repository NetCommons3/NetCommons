<?php
/**
 * NetCommonsHtmlHelper::elementDisplayChange()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsHtmlHelper::elementDisplayChange()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\NetCommonsHtmlHelper
 */
class NetCommonsHtmlHelperElementDisplayChangeTest extends NetCommonsHelperTestCase {

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
		// $viewVarsの値は本来の値ではなく、テストを通すための適当な値です
		$viewVars = array(
			'options' => array(
				'topics' => ''
			),
			'current' => 'topics',
			'url' => array('http://example/'),
		);
		$requestData = array();
		$params = array(
			// composer.jsonで参照している他プラグインでテスト
			'plugin' => 'topics',
			'controller' => 'topics',
			// 本来 select_status というアクションはtopicsプラグインにないけど、アクションからElementを参照してるので、存在するElement名をセット
			'action' => 'select_status',
		);

		//Helperロード
		$this->loadHelper('NetCommons.NetCommonsHtml', $viewVars, $requestData, $params);
	}

/**
 * elementDisplayChange()のテスト
 *
 * @return void
 */
	public function testElementDisplayChange() {
		//データ生成
		$displayType = null;

		//テスト実施
		$result = $this->NetCommonsHtml->elementDisplayChange($displayType);

		//チェック
		//var_export($result);
		$this->assertNotEmpty($result);
	}

}
