<?php
/**
 * SingletonViewBlockHtmlHelper test case base
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('View', 'View');
App::uses('SingletonViewBlockHtmlHelper', 'NetCommons.View/Helper');

/**
 * Summary for SingletonViewBlockHtmlHelperTestBase test case base
 *
 */
class SingletonViewBlockHtmlHelperTestBase extends CakeTestCase {

/**
 * ViewBlock for test
 *
 * @var ViewBlock
 */
	protected static $_ViewBlock = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$view = new View();
		$view->append('appendTest', 'appendTestValue');
		$view->request = new CakeRequest(null, false);
		$view->request->params['requested'] = 1;
		$this->SingletonViewBlockHtml = new SingletonViewBlockHtmlHelper($view);

		if (!isset(self::$_ViewBlock)) {
			self::$_ViewBlock = $view->Blocks;
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SingletonViewBlockHtml);

		parent::tearDown();
	}

}
