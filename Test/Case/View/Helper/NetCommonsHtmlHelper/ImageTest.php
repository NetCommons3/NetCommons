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
class NetCommonsHtmlHelperImageTest extends NetCommonsHelperTestCase {

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
		if ($this->getName() === 'testImageTagWithTheme') {
			$this->loadHelper('NetCommons.NetCommonsHtml', [], [], [], [], [], ['theme' => 'test_theme']);
		} else {
			$this->loadHelper('NetCommons.NetCommonsHtml');
		}
		$this->NetCommonsHtml->request->webroot = '';
	}

/**
 * testImageTag method
 *
 * @return void
 */
	public function testImageTag() {
		$result = $this->NetCommonsHtml->image('test.gif');
		$this->assertTags($result, array('img' => array('src' => 'img/test.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('http://google.com/logo.gif');
		$this->assertTags($result, array('img' => array('src' => 'http://google.com/logo.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('//google.com/logo.gif');
		$this->assertTags($result, array('img' => array('src' => '//google.com/logo.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image(array('controller' => 'test', 'action' => 'view', 1, 'ext' => 'gif'));
		$this->assertTags($result, array('img' => array('src' => '/net_commons/test/view/1.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('/test/view/1.gif');
		$this->assertTags($result, array('img' => array('src' => '/test/view/1.gif', 'alt' => '')));
	}

/**
 * Test image() with query strings.
 *
 * @return void
 */
	public function testImageQueryString() {
		$result = $this->NetCommonsHtml->image('test.gif?one=two&three=four');
		$this->assertTags($result, array('img' => array('src' => 'img/test.gif?one=two&amp;three=four', 'alt' => '')));

		$result = $this->NetCommonsHtml->image(array(
			'controller' => 'images',
			'action' => 'display',
			'test',
			'?' => array('one' => 'two', 'three' => 'four')
		));
		$this->assertTags($result, array('img' => array('src' => '/net_commons/images/display/test?one=two&amp;three=four', 'alt' => '')));
	}

/**
 * Test that image works with pathPrefix.
 *
 * @return void
 */
	public function testImagePathPrefix() {
		$result = $this->NetCommonsHtml->image('test.gif', array('pathPrefix' => '/my/custom/path/'));
		$this->assertTags($result, array('img' => array('src' => '/my/custom/path/test.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('test.gif', array('pathPrefix' => 'https://cakephp.org/assets/img/'));
		$this->assertTags($result, array('img' => array('src' => 'https://cakephp.org/assets/img/test.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('test.gif', array('pathPrefix' => '//cakephp.org/assets/img/'));
		$this->assertTags($result, array('img' => array('src' => '//cakephp.org/assets/img/test.gif', 'alt' => '')));

		$previousConfig = Configure::read('App.imageBaseUrl');
		Configure::write('App.imageBaseUrl', '//cdn.cakephp.org/img/');
		$result = $this->NetCommonsHtml->image('test.gif');
		$this->assertTags($result, array('img' => array('src' => '//cdn.cakephp.org/img/test.gif', 'alt' => '')));
		Configure::write('App.imageBaseUrl', $previousConfig);
	}

/**
 * Test that image() works with fullBase and a webroot not equal to /
 *
 * @return void
 */
	public function testImageWithFullBase() {
		$result = $this->NetCommonsHtml->image('test.gif', array('fullBase' => true));
		$here = $this->NetCommonsHtml->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/test.gif', 'alt' => '')));

		$result = $this->NetCommonsHtml->image('sub/test.gif', array('fullBase' => true));
		$here = $this->NetCommonsHtml->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/sub/test.gif', 'alt' => '')));

		$request = $this->NetCommonsHtml->request;
		$request->webroot = '/myproject/';
		$request->base = '/myproject';
		Router::setRequestInfo($request);

		$result = $this->NetCommonsHtml->image('sub/test.gif', array('fullBase' => true));
		$here = $this->NetCommonsHtml->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/sub/test.gif', 'alt' => '')));
	}

/**
 * test image() with Asset.timestamp
 *
 * @return void
 */
	public function testImageWithTimestampping() {
		Configure::write('Asset.timestamp', 'force');

		$this->NetCommonsHtml->request->webroot = '/';
		$result = $this->NetCommonsHtml->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');

		$result = $this->NetCommonsHtml->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		$this->NetCommonsHtml->request->webroot = '/testing/longer/';
		$result = $this->NetCommonsHtml->image('cake.icon.png');
		$expected = array(
			'img' => array('src' => 'preg:/\/testing\/longer\/img\/cake\.icon\.png\?[0-9]+/', 'alt' => '')
		);
		$this->assertTags($result, $expected);
	}

/**
 * Tests creation of an image tag using a theme and asset timestamping
 *
 * @return void
 */
	public function testImageTagWithTheme() {
		$this->skipIf(!is_writable(WWW_ROOT), 'Cannot write to webroot.');
		$themeExists = is_dir(WWW_ROOT . 'theme');

		App::uses('File', 'Utility');

		$testfile = WWW_ROOT . 'theme' . DS . 'test_theme' . DS . 'img' . DS . '__cake_test_image.gif';
		new File($testfile, true);

		App::build(array(
			'View' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'View' . DS)
		));
		Configure::write('Asset.timestamp', true);
		Configure::write('debug', 1);

		$this->NetCommonsHtml->request->webroot = '/';
		$this->NetCommonsHtml->theme = 'test_theme';
		$result = $this->NetCommonsHtml->image('__cake_test_image.gif');
		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));

		$this->NetCommonsHtml->request->webroot = '/testing/';
		$result = $this->NetCommonsHtml->image('__cake_test_image.gif');

		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/testing\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));

		$dir = new Folder(WWW_ROOT . 'theme' . DS . 'test_theme');
		$dir->delete();
		if (!$themeExists) {
			$dir = new Folder(WWW_ROOT . 'theme');
			$dir->delete();
		}
	}

/**
 * testBase64ImageTag method
 *
 * @return void
 */
	//public function testBase64ImageTag() {
	//	$this->NetCommonsHtml->request->webroot = '';
	//
	//	$result = $this->NetCommonsHtml->image('cake.icon.png', array('base64' => true));
	//	$this->assertTags($result, array(
	//		'img' => array(
	//			'src' => 'preg:/data:image\/png;base64,(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{4})/',
	//			'alt' => ''
	//		)));
	//
	//	$result = $this->NetCommonsHtml->image('/img/cake.icon.png', array('base64' => true));
	//	$this->assertTags($result, array(
	//		'img' => array(
	//			'src' => 'preg:/data:image\/png;base64,(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{4})/',
	//			'alt' => ''
	//		)));
	//}

/**
 * testLoadConfigWrongFile method
 *
 * @return void
 * @expectedException InvalidArgumentException
 */
	//public function testBase64InvalidArgumentException() {
	//	$this->NetCommonsHtml->request->webroot = '';
	//	$this->NetCommonsHtml->image('non-existent-image.png', array('base64' => true));
	//}

}
