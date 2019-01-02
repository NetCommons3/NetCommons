<?php
/**
 * NetCommonsHtmlHelper::link()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsHtmlHelper::link()のテスト
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\NetCommons\Test\Case\View\Helper\NetCommonsHtmlHelper
 */
class NetCommonsHtmlHelperUrlTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('NetCommons.NetCommonsHtml');
	}

/**
 * Ensure HTML escaping of URL params. So link addresses are valid and not exploited
 *
 * @return void
 */
	public function testUrl() {
		$result = $this->NetCommonsHtml->url('/controller/action/1');
		$this->assertEquals('/controller/action/1', $result);

		$result = $this->NetCommonsHtml->url('/controller/action/1?one=1&two=2');
		$this->assertEquals('/controller/action/1?one=1&amp;two=2', $result);

		$result = $this->NetCommonsHtml->url(array('controller' => 'posts', 'action' => 'index', 'page' => '1" onclick="alert(\'XSS\');"'));
		$this->assertEquals("/net_commons/posts/index/page:1%22%20onclick%3D%22alert%28%27XSS%27%29%3B%22", $result);

		$result = $this->NetCommonsHtml->url('/controller/action/1/param:this+one+more');
		$this->assertEquals('/controller/action/1/param:this+one+more', $result);

		$result = $this->NetCommonsHtml->url('/controller/action/1/param:this%20one%20more');
		$this->assertEquals('/controller/action/1/param:this%20one%20more', $result);

		$result = $this->NetCommonsHtml->url('/controller/action/1/param:%7Baround%20here%7D%5Bthings%5D%5Bare%5D%24%24');
		$this->assertEquals('/controller/action/1/param:%7Baround%20here%7D%5Bthings%5D%5Bare%5D%24%24', $result);

		$result = $this->NetCommonsHtml->url(array(
			'controller' => 'posts', 'action' => 'index', 'param' => '%7Baround%20here%7D%5Bthings%5D%5Bare%5D%24%24'
		));
		$this->assertEquals("/net_commons/posts/index/param:%257Baround%2520here%257D%255Bthings%255D%255Bare%255D%2524%2524", $result);

		$result = $this->NetCommonsHtml->url(array(
			'controller' => 'posts', 'action' => 'index', 'page' => '1',
			'?' => array('one' => 'value', 'two' => 'value', 'three' => 'purple')
		));
		$this->assertEquals("/net_commons/posts/index/page:1?one=value&amp;two=value&amp;three=purple", $result);
	}

}
