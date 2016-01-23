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

App::uses('AppHelper', 'View/Helper');

/**
 * NetCommonsFormHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class NetCommonsHtmlHelper extends AppHelper {

/**
 * Other helpers used by HtmlHelper
 *
 * @var array
 */
	public $helpers = array('Html');

/**
 * HtmlHelperラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->Html, $method), $params);
	}

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

/**
 * Json CakePHP template.
 * It is better reference Google JSON Style Guid
 *
 * @param array $results results data
 * @param string $name message
 * @param int $status status code
 * @return string json format data
 */
	public function json($results = [], $name = 'OK', $status = 200) {
		//if (! $results) {
		//	$results = $this->_View->viewVars;
		//}
		$results = array_merge([
			'name' => $name,
			'code' => $status,
		], $results);

		$camelizeData = NetCommonsAppController::camelizeKeyRecursive($results);

		return json_encode($camelizeData);
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param string $title The anchor's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function editLink($title = '', $url = null, $options = array()) {
		//URLの設定
		if (! isset($url['plugin'])) {
			$url['plugin'] = $this->_View->request->params['plugin'];
		}
		if (! isset($url['controller'])) {
			if (! isset($this->_View->viewVars['editActionController'])) {
				$url['controller'] = $this->_View->request->params['controller'];
			} else {
				$url['controller'] = $this->_View->viewVars['editActionController'];
			}
		}
		if (! isset($url['action'])) {
			$url['action'] = 'edit';
		}
		if (! isset($url['block_id']) && Current::read('Block.id')) {
			$url['block_id'] = Current::read('Block.id');
		}
		if (! isset($url['frame_id']) && Current::read('Frame.id')) {
			$url['frame_id'] = Current::read('Frame.id');
		}
		$url = NetCommonsUrl::actionUrl($url);

		return $this->Html->link($title, $url, $options);
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param mixed $url Link url
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	private function __getUrl($url = null) {
		//URLの設定
		if (is_array($url)) {
			if (! isset($url['plugin'])) {
				$url['plugin'] = $this->_View->request->params['plugin'];
			}
			if (! isset($url['controller'])) {
				$url['controller'] = $this->_View->request->params['controller'];
			}
			if (! isset($url['action'])) {
				$url['action'] = $this->_View->request->params['action'];
			}
			if (! isset($url['block_id']) && Current::read('Block.id')) {
				$url['block_id'] = Current::read('Block.id');
			}
			if (! isset($url['frame_id']) && Current::read('Frame.id')) {
				$url['frame_id'] = Current::read('Frame.id');
			}
			$url = NetCommonsUrl::actionUrl($url);
		}
		return $url;
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function url($url = null, $options = array()) {
		//URLの設定
		$url = $this->__getUrl($url);
		$output = $this->Html->url($url, $options);
		return $output;
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param string $title The anchor's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function link($title = '', $url = null, $options = array()) {
		$url = $this->__getUrl($url);
		$output = $this->Html->link($title, $url, $options);
		return $output;
	}
/**
 * Creates a `<img>` tag for title icon.
 *
 * @param string $filePath The title icon's file path.
 * @return string img tag.
 */
	public function titleIcon($filePath) {
		$output = $this->Html->image($filePath, array('alt' => __d('net_commons', $filePath), 'class' => 'nc-title-icon'));
		return $output;
	}
}
