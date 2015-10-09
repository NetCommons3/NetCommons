<?php
/**
 * SingletonViewBlockHtmlHelper Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SingletonViewBlockHtmlHelperTestBase', 'NetCommons.Test/Case/View/Helper/SingletonViewBlockHtml');

/**
 * Summary for TokenHelper Test Case
 *
 */
class SingletonViewBlockHtmlHelperTest extends SingletonViewBlockHtmlHelperTestBase {

/**
 * testSameViewInstance method
 *
 * @return void
 */
	public function testSameViewInstance() {
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertEquals(get_class(self::$_ViewBlock), get_class($viewBlock));
	}

/**
 * testAnotherViewInstance method
 *
 * @return void
 */
	public function testAnotherViewInstance() {
		$view = new View();
		$svbhHelper = new SingletonViewBlockHtmlHelper($view);
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($svbhHelper, '__staticViewBlock');

		$this->assertEquals(get_class($view->Blocks), get_class($viewBlock));
	}

/**
 * testCopyBlock method
 *
 * @return void
 */
	public function testCopyBlock() {
		$view = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '_View');
		$this->assertEquals('appendTestValue', $view->Blocks->get('appendTest'));
	}

/**
 * testNotCopyBlock method
 *
 * @return void
 */
	public function testNotCopyBlock() {
		$view = new View();
		$view->append('notCopyTest', 'notCopyTestValue');
		$svbhHelper = new SingletonViewBlockHtmlHelper($view);

		$view = PHPUnit_Framework_Assert::readAttribute($svbhHelper, '_View');
		$this->assertEquals('notCopyTestValue', $view->Blocks->get('notCopyTest'));
		$this->assertEmpty($view->Blocks->get('appendTest'));
	}

}
