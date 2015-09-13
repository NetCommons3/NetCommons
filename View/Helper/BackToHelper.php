<?php
/**
 * BackTo Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * BackTo Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\View\Helper
 */
class BackToHelper extends AppHelper {

/**
 * Other helpers used by HtmlHelper
 *
 * @var array
 */
	public $helpers = array('Html', 'Form');

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 *   `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 *   `url` - The url in onclick attribute
 *	 `icon` - Icon to be displayed on the button (only to specify the last keyword of gliphs of bootstrap components)
 *	 `iconSize` - '' is the default size : lg / sm / xs
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string $url The url in onclick attribute
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function button($title, $url, $options = array()) {
		//iconの有無
		$iconElement = '';
		if (! isset($options['icon'])) {
			$options['icon'] = 'remove';
		}
		if ($options['icon'] !== '') {
			$iconElement = '<span class="glyphicon glyphicon-' . h($options['icon']) . '"></span> ';
			unset($options['icon']);
		}
		//ボタンサイズ
		$sizeAttr = '';
		if (isset($options['iconSize']) && $options['iconSize'] !== '') {
			$sizeAttr = h('btn-' . $options['iconSize']);
			unset($options['iconSize']);
		}

		$defaultOptions = array(
			'type' => 'button',
			'class' => 'btn btn-default btn-workflow',
			'ng-disabled' => 'sending',
		);
		if ($url) {
			$defaultOptions = Hash::merge($defaultOptions, array(
				'ng-click' => 'sending=true',
				'onclick' => 'location.href = \'' . $this->Html->url($url) . '\''
			));
		}
		$inputOptions = Hash::merge($defaultOptions, $options);

		return $this->Form->button($iconElement . $title, $inputOptions);
	}

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *
 * @param string $title Title string to be displayed on the button
 * @param array $options Array of options and HTML attributes.
 * @return string
 */
	public function pageButton($title, $options = array()) {
		$url = NetCommonsUrl::backToPageUrl();
		return $this->Button($title, $url, $options);
	}

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *
 * @param string $title Title string to be displayed on the button
 * @param string $defaultField Plugin table's default action field. The value is "default_action" or "default_setting_action"
 * @param array $options Array of options and HTML attributes.
 * @return string
 */
	public function indexButton($title, $defaultField = 'default_action', $options = array()) {
		$url = NetCommonsUrl::backToIndexUrl($defaultField);
		return $this->linkButton($title, $url, $options);
	}

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *   #### Original options
 *	   `icon` - Icon to be displayed on the button (only to specify the last keyword of gliphs of bootstrap components)
 *	   `iconSize` - '' is the default size : lg / sm / xs
 *
 * @param string $title Title string to be displayed on the button
 * @param mixed $url Link url
 * @param array $options Array of options and HTML arguments.
 * @return string
 */
	public function linkButton($title, $url, $options = array()) {
		//iconの有無
		$iconElement = '';
		if (! isset($options['icon'])) {
			$options['icon'] = 'remove';
		}
		if ($options['icon'] !== '') {
			$iconElement = '<span class="glyphicon glyphicon-' . h($options['icon']) . '"></span> ';
			unset($options['icon']);
		}
		//ボタンサイズ
		$sizeAttr = '';
		if (isset($options['iconSize']) && $options['iconSize'] !== '') {
			$sizeAttr = h('btn-' . $options['iconSize']);
			unset($options['iconSize']);
		}

		$inputOptions = Hash::merge(array(
			'escapeTitle' => false,
			'class' => 'btn btn-default ' . $sizeAttr
		), $options);

		if (! $inputOptions['escapeTitle']) {
			$title = h($title);
		}
		return $this->Html->link($iconElement . $title, $url, $inputOptions);
	}

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *
 * @param string $title Title string to be displayed on the button
 * @param array $options Array of options and HTML arguments.
 * @return string
 */
	public function pageLinkButton($title, $options = array()) {
		$url = NetCommonsUrl::backToPageUrl();
		return $this->linkButton($title, $url, $options);
	}

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *
 * @param string $title Title string to be displayed on the button
 * @param string $defaultField Plugin table's default action field. The value is "default_action" or "default_setting_action"
 * @param array $options Array of options and HTML attributes.
 * @return string
 */
	public function indexLinkButton($title, $defaultField = 'default_action', $options = array()) {
		$url = NetCommonsUrl::backToIndexUrl($defaultField);
		return $this->linkButton($title, $url, $options);
	}

}
