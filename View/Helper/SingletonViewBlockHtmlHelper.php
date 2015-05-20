<?php
/**
 * Singleton ViewBlock Html Helper class file.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('HtmlHelper', 'View/Helper');

/**
 * SingletonViewBlockHtmlHelper
 *
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class SingletonViewBlockHtmlHelper extends HtmlHelper {

/**
 * The same ViewBlock instance this helper is attached to
 *
 * @var View
 */
	private static $__staticViewBlock = null;

/**
 * Names of script & css files that have been included once
 * If CakePHP less than 2.6.0, css is not implemented
 *
 * @var array
 */
	private static $__staticIncludedAssets = array();

/**
 * Constructor
 *
 * Set static View instance and _includedAssets property after parent::__construct
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		if (!isset(self::$__staticViewBlock)) {
			self::$__staticViewBlock = $this->_View->Blocks;
		}

		if (!empty($this->request->params['requested'])) {
			$this->__copyBlockValue(self::$__staticViewBlock, $this->_View->Blocks);

			//If CakePHP version is over 2.6.0, the _includedScripts name chenge to _includedAssets
			$this->_includedScripts = self::$__staticIncludedAssets;
		}
	}

/**
 * Copy block value
 *
 * @param ViewBlock $sourceBlock Source of copy block
 * @param ViewBlock $destinationBlock Destination of copy block
 * @param array|string $blockKeys Copy key
 * @return void
 */
	private function __copyBlockValue(ViewBlock $sourceBlock, ViewBlock $destinationBlock, $blockKeys = array()) {
		if (!is_array($blockKeys)) {
			$blockKeys = array($blockKeys);
		}
		if (empty($blockKeys)) {
			// Change to Helper option, if customize
			$blockKeys = array(
				'meta',
				'css',
				'script'
			);
		}

		foreach ($blockKeys as $name) {
			$destinationBlock->set($name, $sourceBlock->get($name));
		}
	}

/**
 * View object changed to static View instance for used same BlockView instance
 *
 * @param string $type The title of the external resource
 * @param string|array $url The address of the external resource or string for content attribute
 * @param array $options Other attributes for the generated tag. If the type attribute is html,
 *    rss, atom, or icon, the mime-type is returned.
 * @return string A completed `<link />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::meta
 */
	public function meta($type, $url = null, $options = array()) {
		$out = parent::meta($type, $url, $options);
		if (strlen($out) > 0) {
			return $out;
		}
		$this->__copyBlockValue($this->_View->Blocks, self::$__staticViewBlock, 'meta');
	}

/**
 * View object changed to static View instance for used same BlockView instance
 *
 * @param string|array $path The name of a CSS style sheet or an array containing names of
 *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
 *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
 * @param array $options Array of options and HTML arguments.
 * @return string CSS <link /> or <style /> tag, depending on the type of link.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::css
 */
	public function css($path, $options = array()) {
		$out = parent::css($path, $options);

		//If CakePHP version is over 2.6.0, the _includedScripts name chenge to _includedAssets
		//self::$__staticIncludedAssets = array_merge(self::$__staticIncludedAssets, $this->_includedAssets);

		if (strlen($out) > 0) {
			return $out;
		}
		$this->__copyBlockValue($this->_View->Blocks, self::$__staticViewBlock, 'css');
	}

/**
 * View object changed to static View instance for used same BlockView instance
 *
 * @param string|array $url String or array of javascript files to include
 * @param array|bool $options Array of options, and html attributes see above. If boolean sets $options['inline'] = value
 * @return mixed String of `<script />` tags or null if $inline is false or if $once is true and the file has been
 *   included before.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::script
 */
	public function script($url, $options = array()) {
		$out = parent::script($url, $options);

		//If CakePHP version is over 2.6.0, the _includedScripts name chenge to _includedAssets
		self::$__staticIncludedAssets = array_merge(self::$__staticIncludedAssets, $this->_includedScripts);

		if (strlen($out) > 0) {
			return $out;
		}
		$this->__copyBlockValue($this->_View->Blocks, self::$__staticViewBlock, 'script');
	}

/**
 * View object changed to static View instance for used same BlockView instance
 *
 * @param string $script The script to wrap
 * @param array $options The options to use. Options not listed above will be
 *    treated as HTML attributes.
 * @return mixed string or null depending on the value of `$options['block']`
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::scriptBlock
 */
	public function scriptBlock($script, $options = array()) {
		$out = parent::scriptBlock($script, $options);
		if (strlen($out) > 0) {
			return $out;
		}
		$this->__copyBlockValue($this->_View->Blocks, self::$__staticViewBlock, 'script');
	}
}
