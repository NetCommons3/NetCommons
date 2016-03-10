<?php
/**
 * DatetimePickerHelper::render()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * DatetimePickerHelper::render()のテスト
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\DatetimePickerHelper
 */
class DatetimePickerHelperBeforeFormEndTest extends NetCommonsHelperTestCase {

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
 * beforeFormEnd()のテスト FromTo制約候補が一切無いケース
 *
 * @return void
 */
	public function testBeforeFormEndNoLink() {
		$datetimeLinkProperty = new ReflectionProperty($this->DatetimePicker, '_datetimeLink');
		$datetimeLinkProperty->setAccessible(true);

		// _datetimeLink datetimepicker でfrom or toが一切無いケース -> scriptBlockはコールされない
		$datetimeLinkProperty->setValue($this->DatetimePicker, array());

		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['scriptBlock'], [$view, array()]);
		// scriptBlockはコールされないはず
		$htmlHelperMock->expects($this->never())
			->method('scriptBlock');
		$this->DatetimePicker->Html = $htmlHelperMock;

		//テスト実施

		$this->DatetimePicker->beforeFormEnd();
	}

/**
 * beforeFormEnd()のテスト FromTo制約候補にfrom or to一方しかないケース
 *
 * @return void
 */
	public function testBeforeFormEndFromOrToOnly() {
		$datetimeLinkProperty = new ReflectionProperty($this->DatetimePicker, '_datetimeLink');
		$datetimeLinkProperty->setAccessible(true);

		// _datetimeLink datetimepicker でfrom しかないケース -> scriptBlockはコールされない
		$datetimeLinkProperty->setValue($this->DatetimePicker, array('publish' => ['from' => 'publish_start']));

		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['scriptBlock'], [$view, array()]);
		// scriptBlockはコールされないはず
		$htmlHelperMock->expects($this->never())
			->method('scriptBlock');
		$this->DatetimePicker->Html = $htmlHelperMock;

		//テスト実施
		$this->DatetimePicker->beforeFormEnd();

		// toだけあるケース
		$datetimeLinkProperty->setValue($this->DatetimePicker, array('publish' => ['tod' => 'publish_end']));

		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['scriptBlock'], [$view, array()]);
		// scriptBlockはコールされないはず
		$htmlHelperMock->expects($this->never())
			->method('scriptBlock');
		$this->DatetimePicker->Html = $htmlHelperMock;

		//テスト実施
		$this->DatetimePicker->beforeFormEnd();
	}

/**
 * beforeFormEnd()のテスト FromTo制約候補にfrom toのペアがあるケース
 *
 * @return void
 */
	public function testBeforeFormEndFromAndTo() {
		$datetimeLinkProperty = new ReflectionProperty($this->DatetimePicker, '_datetimeLink');
		$datetimeLinkProperty->setAccessible(true);

		// _datetimeLink datetimepicker でfrom or toがペアがある -> scriptBlockがコールされる
		$datetimeLinkProperty->setValue($this->DatetimePicker, array('publish' => ['from' => 'publish_start', 'to' => 'publish_end']));

		$view = new View();
		$htmlHelperMock = $this->getMock('HtmlHelper', ['scriptBlock'], [$view, array()]);
		// scriptBlockは1回だけコールされる
		$htmlHelperMock->expects($this->once())
			->method('scriptBlock')
			->with(
				$this->stringContains('PublishStart'),
				$this->equalTo(['inline' => false])
			);

		$this->DatetimePicker->Html = $htmlHelperMock;

		$this->DatetimePicker->Form->create('BlogEntry');
		//テスト実施
		$this->DatetimePicker->beforeFormEnd();
	}

}
