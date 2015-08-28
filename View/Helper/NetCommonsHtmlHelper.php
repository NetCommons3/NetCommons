<?php
/**
 * NetCommonsFormHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('HtmlHelper', 'View/Helper');

/**
 * NetCommonsFormHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class NetCommonsHtmlHelper extends HtmlHelper {

/**
 * Other helpers used by HtmlHelper
 *
 * @var array
 */
	public $helpers = array('Html');

/**
 * Overwrite HtmlHelper::script()
 *
 * @param string|array $url String or array of javascript files to include
 * @param array|bool $options Array of options, and html attributes see above. If boolean sets $options['inline'] = value
 * @return mixed String of `<script />` tags or null if $inline is false or if $once is true and the file has been
 *   included before.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::script
 */
	public function script($url, $options = array()) {
		$defaultOptions = array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		);

		return $this->Html->script($url, Hash::merge($defaultOptions, $options));
	}

/**
 * Overwrite HtmlHelper::css()
 *
 * @param string|array $path The name of a CSS style sheet or an array containing names of
 *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
 *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
 * @param array $options Array of options and HTML arguments.
 * @return string CSS <link /> or <style /> tag, depending on the type of link.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::css
 */
	public function css($path, $options = array()) {
		$defaultOptions = array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		);

		return $this->Html->css($path, Hash::merge($defaultOptions, $options));
	}

}
