<?php
/**
 * DatetimePickerHelper::setLinkFieldName()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * DatetimePickerHelper::setLinkFieldName()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperSetLinkFieldNameTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.DatetimePicker', $viewVars, $requestData, $params);
	}

/**
 * setLinkFieldName()のテスト
 *
 * @param string $fieldName フィールド名
 * @param array $options オプション
 * @param array $result _datetimeLink期待値
 * @return void
 * @dataProvider dataProvider4TestSetLinkFieldName
 */
	public function testSetLinkFieldName($fieldName, $options, $result) {
		//データ生成
		//$fieldName = null;
		//$options = null;

		//テスト実施
		$this->_testReflectionMethod($this->DatetimePicker, '_setLinkFieldName', [$fieldName, $options]);

		$datetimeLinkProperty = new ReflectionProperty($this->DatetimePicker, '_datetimeLink');
		$datetimeLinkProperty->setAccessible(true);

		$this->assertEquals($result, $datetimeLinkProperty->getValue($this->DatetimePicker));
	}

/**
 * dataProvider4TestSetLinkFieldName
 *
 * @return array
 */
	public function dataProvider4TestSetLinkFieldName() {
		return [
			// fieldName, options, _datetimeLink result
			['publish_start', ['datetimepicker' => 1], ['publish' => ['from' => 'publish_start']]],
			['publish_from', ['datetimepicker' => 1], ['publish' => ['from' => 'publish_from']]],
			['publish_end', ['datetimepicker' => 1], ['publish' => ['to' => 'publish_end']]],
			['publish_to', ['datetimepicker' => 1], ['publish' => ['to' => 'publish_to']]],
			//['publish_to', [], []], // datetimepickerオプションが指定されてなければFromTo制約候補にならない
			['publish_datetime', ['datetimepicker'], []], // *_from, *_to, *_start, *_end以外のフィールド名ではFromTo制約の候補にはならない

		];
	}

}
