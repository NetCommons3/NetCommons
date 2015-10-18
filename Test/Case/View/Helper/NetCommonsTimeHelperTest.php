<?php
/**
 * NetCommonsTimeHelper Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('NetCommonsTimeHelper', 'NetCommons.View/Helper');

/**
 * Summary for NetCommonsTimeHelper Test Case
 */
class NetCommonsTimeHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->NetCommonsTime = new NetCommonsTimeHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->NetCommonsTime);

		parent::tearDown();
	}

/**
 * NetCommonsTimeHelperでNetCommonsTimeをwrapできてるかのテスト
 *
 * @return void
 */
	public function testWrapMethods() {
		$methods = [
			'toUserDatetime',
			'toServerDatetime',
		];

		// NetCommonsTimeHelperで使うNetCommonsTimeをモックにさしかえる
		$netCommonsTimeMock = $this->getMock('NetCommonsTime', $methods);

		$property = new ReflectionProperty($this->NetCommonsTime, '_netCommonsTime');
		$property->setAccessible(true);
		$property->setValue($this->NetCommonsTime, $netCommonsTimeMock);

		// NetCommonsTimeMockで同じ名前のメソッドが呼び出されているかテスト
		foreach ($methods as $method) {
			$netCommonsTimeMock->expects($this->at(0))->method($method);
			$this->NetCommonsTime->{$method}('who', 'what', 'when', 'where', 'how');
		}
	}
}
