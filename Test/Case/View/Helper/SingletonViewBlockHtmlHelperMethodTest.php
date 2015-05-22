<?php
/**
 * SingletonViewBlockHtmlHelper Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SingletonViewBlockHtmlHelperTestBase', 'NetCommons.Test/Case/View/Helper');

/**
 * Summary for TokenHelper Test Case
 *
 */
class SingletonViewBlockHtmlHelperMethodTest extends SingletonViewBlockHtmlHelperTestBase {

/**
 * testMeta method
 *
 * @return void
 */
	public function testMeta() {
		$expected = '<meta name="keywords" content="these, are, some, meta, keywords" />';
		$actual = $this->SingletonViewBlockHtml->meta('keywords', 'these, are, some, meta, keywords');
		$this->assertEquals($expected, $actual);

		$needle = $expected;
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('meta'));
	}

/**
 * testMetaWithBlock method
 *
 * @return void
 */
	public function testMetaWithBlock() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->meta(array('name' => 'ROBOTS', 'content' => 'ALL'), null, $options);
		$this->assertNull($actual);

		$needle = '<meta name="ROBOTS" content="ALL" />';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertContains($needle, $viewBlock->get('meta'));
	}

/**
 * testCss method
 *
 * @return void
 */
	public function testCss() {
		$expected = '/<link rel="stylesheet" type="text\/css" href=".*\/css\/cssFile\.css" \/>/';
		$actual = $this->SingletonViewBlockHtml->css('cssFile');
		$this->assertRegExp($expected, $actual);

		$needle = '/css/cssFile.css';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('css'));

		//If CakePHP version is over 2.6.0, the _includedScripts name chenge to _includedAssets
		//$expected = array('cssFile' => true);
		//$this->assertEquals($expected, PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticIncludedAssets'));
	}

/**
 * testCssWithBlockSamePath method
 *
 * @return void
 */
	public function testCssWithBlockSamePath() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->css('cssFile', $options);
		$this->assertNull($actual);

		$needle = '/css/cssFile.css';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertContains($needle, $viewBlock->get('css'));
		//If CakePHP version is over 2.6.0, the _includedScripts name chenge to _includedAssets
		//$this->assertNotContains($needle, $viewBlock->get('css'));
	}

/**
 * testCssWithBlockAnotherPath method
 *
 * Unnecessary if under 2.6.0
 *
 * @return void
 */
	public function testCssWithBlockAnotherPath() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->css('cssFileAnother', $options);
		$this->assertNull($actual);

		$needle = '/css/cssFileAnother.css';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertContains($needle, $viewBlock->get('css'));
	}

/**
 * testScript method
 *
 * @return void
 */
	public function testScript() {
		$expected = '/<script type="text\/javascript" src=".*\/js\/scriptFile\.js"><\/script>/';
		$actual = $this->SingletonViewBlockHtml->script('scriptFile');
		$this->assertRegExp($expected, $actual);

		$needle = $expected;
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('script'));

		$expected = array('scriptFile' => true);
		$this->assertEquals($expected, PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticIncludedAssets'));
	}

/**
 * testScriptWithBlockSameUrl method
 *
 * @return void
 */
	public function testScriptWithBlockSameUrl() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->script('scriptFile', $options);
		$this->assertNull($actual);

		$needle = '/js/scriptFile.js';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('script'));
	}

/**
 * testScriptWithBlockAnotherUrl method
 *
 * @return void
 */
	public function testScriptWithBlockAnotherUrl() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->script('scriptFileAnother', $options);
		$this->assertNull($actual);

		$needle = '/js/scriptFileAnother.js';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertContains($needle, $viewBlock->get('script'));
	}

/**
 * testScriptBlock method
 *
 * @return void
 */
	public function testScriptBlock() {
		$expected = 'window.foo = 2';
		$actual = $this->SingletonViewBlockHtml->scriptBlock('window.foo = 2;');
		$this->assertContains($expected, $actual);

		$needle = $expected;
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('script'));
	}

/**
 * testMetaReturnWithBlock method
 *
 * @return void
 */
	public function testScriptBlockWithBlock() {
		$options = array('inline' => false);
		$actual = $this->SingletonViewBlockHtml->scriptBlock('window.foo = 3;', $options);
		$this->assertNull($actual);

		$needle = '<script>window.foo = 3</script>';
		$viewBlock = PHPUnit_Framework_Assert::readAttribute($this->SingletonViewBlockHtml, '__staticViewBlock');
		$this->assertNotContains($needle, $viewBlock->get('script'));
	}

}
