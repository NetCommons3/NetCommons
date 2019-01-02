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
class NetCommonsHtmlHelperLinkTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 * @see MenuHelperRenderMainTest よりコピー
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
		$this->loadHelper('NetCommons.NetCommonsHtml');
	}

/**
 * testLink method
 *
 * @return void
 */
	public function testLink() {
		Router::connect('/:controller/:action/*');

		$this->NetCommonsHtml->request->webroot = '';

		$result = $this->NetCommonsHtml->link('/home');
		$expected = array('a' => array('href' => '/home'), 'preg:/\/home/', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link(array('action' => 'login', '<[You]>'));
		$expected = array(
			'a' => array('href' => '/login/%3C%5BYou%5D%3E'),
			'preg:/\/login\/&lt;\[You\]&gt;/',
			'/a'
		);
		$this->assertTags($result, $expected);

		Router::reload();

		//$result = $this->NetCommonsHtml->link('Posts', array('controller' => 'posts', 'action' => 'index', 'full_base' => true));
		//$expected = array('a' => array('href' => Router::fullBaseUrl() . '/posts'), 'Posts', '/a');
		//$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Home', '/home', array('confirm' => 'Are you sure you want to do this?'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'if (confirm(&quot;Are you sure you want to do this?&quot;)) { return true; } return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Home', '/home', array('escape' => false, 'confirm' => 'Confirm\'s "nightmares"'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'if (confirm(&quot;Confirm&#039;s \&quot;nightmares\&quot;&quot;)) { return true; } return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Home', '/home', array('default' => false));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'event.returnValue = false; return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Home', '/home', array('default' => false, 'onclick' => 'someFunction();'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'someFunction(); event.returnValue = false; return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#');
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array('escape' => true));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array('escape' => 'utf-8'));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => false
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &#8230; or not escape?'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => true
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &amp;#8230; or not escape?'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Next >', '#', array(
			'title' => 'Next >',
			'escapeTitle' => false
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'Next &gt;'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('Original size', array(
			'controller' => 'images', 'action' => 'view', 3, '?' => array('height' => 100, 'width' => 200)
		));
		$expected = array(
			'a' => array('href' => '/net_commons/images/view/3?height=100&amp;width=200'),
			'Original size',
			'/a'
		);
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', false);

		$result = $this->NetCommonsHtml->link($this->NetCommonsHtml->image('test.gif'), '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link($this->NetCommonsHtml->image('test.gif'), '#', array(
			'title' => 'hey "howdy"',
			'escapeTitle' => false
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'hey &quot;howdy&quot;'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->image('test.gif', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link($this->NetCommonsHtml->image('../favicon.ico'), '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/../favicon.ico', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->image('../favicon.ico', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/../favicon.ico', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('http://www.example.org?param1=value1&param2=value2');
		$expected = array('a' => array('href' => 'http://www.example.org?param1=value1&amp;param2=value2'), 'http://www.example.org?param1=value1&amp;param2=value2', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('alert', 'javascript:alert(\'cakephp\');');
		$expected = array('a' => array('href' => 'javascript:alert(&#039;cakephp&#039;);'), 'alert', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('write me', 'mailto:example@cakephp.org');
		$expected = array('a' => array('href' => 'mailto:example@cakephp.org'), 'write me', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('call me on 0123465-798', 'tel:0123465-798');
		$expected = array('a' => array('href' => 'tel:0123465-798'), 'call me on 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('text me on 0123465-798', 'sms:0123465-798');
		$expected = array('a' => array('href' => 'sms:0123465-798'), 'text me on 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('say hello to 0123465-798', 'sms:0123465-798?body=hello there');
		$expected = array('a' => array('href' => 'sms:0123465-798?body=hello there'), 'say hello to 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->NetCommonsHtml->link('say hello to 0123465-798', 'sms:0123465-798?body=hello "cakephp"');
		$expected = array('a' => array('href' => 'sms:0123465-798?body=hello &quot;cakephp&quot;'), 'say hello to 0123465-798', '/a');
		$this->assertTags($result, $expected);
	}
}
