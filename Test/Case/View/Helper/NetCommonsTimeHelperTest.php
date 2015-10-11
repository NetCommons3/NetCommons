<?php
/**
 * NetCommonsTimeHelper Test Case
 *
* @author Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link http://www.netcommons.org NetCommons Project
* @license http://www.netcommons.org/license.txt NetCommons License
 */

// TODO TimeHelperTestのようにwrapしてるだけのメソッドはMockを使って狙ったメソッドが呼び出されてるかだけをTestする。
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('NetCommonsTimeHelper', 'NetCommons.View/Helper');

class NetCommonsTimeHelperTesting extends NetCommonsTimeHelper {
	public function attach($mock) {
		$this->NetCommonsTime = $mock;
	}
}
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
 * testToUserDatetime method
 *
 * @return void
 */
	public function testWrapMethods() {
		$methods = [
			'toUserDatetime',
		];

		// NetCommonsTimeHelperで使うNetCommonsTimeをモックにさしかえる
		$netCommonsTimeMock = $this->getMock('NetCommonsTime', $methods);

		$property = new ReflectionProperty($this->NetCommonsTime, 'NetCommonsTime');
		$property->setAccessible(true);
		$property->setValue($this->NetCommonsTime, $netCommonsTimeMock);

		// NetCommonsTimeMockで同じ名前のメソッドが呼び出されているかテスト
		foreach($methods as $method){
			$netCommonsTimeMock->expects($this->at(0))->method($method);
			$this->NetCommonsTime->{$method}('who', 'what', 'when', 'where', 'how');
		}

	}

}
