<?php
/**
 * NetCommonsFormHelper::input()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsTime', 'NetCommons.Utility');
App::uses('NetCommonsForm', 'NetCommons.View/Helper');

/**
 * NetCommonsFormHelper::input()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\NetCommonsFormHelper
 */
class NetCommonsFormHelperNetCommonsTimeTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting',
	);

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
		$this->loadHelper('NetCommons.NetCommonsForm', $viewVars, $requestData, $params);
	}

/**
 * convert_fieldsにModelName.field_name形式で出力されるか
 *
 * @return void
 */
	public function testConvertFields() {
		//データ生成
		$fieldName = 'publish_start';
		$options = array(
			'type' => 'datetime'
		);

		//テスト実施
		$this->NetCommonsForm->create('TestModel');
		$this->NetCommonsForm->input($fieldName, $options); //フィールド名のみのケース
		$this->NetCommonsForm->input('ModelName.field_name', $options); // モデル名付き
		$result = $this->NetCommonsForm->end();
		$this->assertRegExp('/<input.*?name="data\[_NetCommonsTime]\[convert_fields]".*?value="TestModel\.publish_start,ModelName\.field_name"/', $result);
	}
}
