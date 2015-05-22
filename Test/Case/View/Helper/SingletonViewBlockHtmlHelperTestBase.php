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
 * View for test
 *
 * @var View
 */
	protected static $_View = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		self::$_View = new View();
		self::$_View->append('appendTest', 'appendTestValue');
		self::$_View->request = new CakeRequest(null, false);
		self::$_View->request->params['requested'] = 1;
		$this->SingletonViewBlockHtml = new SingletonViewBlockHtmlHelper(self::$_View);
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
