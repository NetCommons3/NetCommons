<?php
/**
 * Button Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');

/**
 * Button Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class ButtonHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.BackTo',
		'NetCommons.NetCommonsHtml',
	);

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function addLink($title = '', $url = null, $options = array()) {
		$output = '';

		if (! is_string($url)) {
			//URLの設定
			$defaultUrl = array(
				'plugin' => $this->_View->request->params['plugin'],
				'controller' => $this->_View->request->params['controller'],
			);
			if (! isset($url)) {
				$url = array(
					'action' => 'add',
					'frame_id' => Current::read('Frame.id'),
				);
				if (isset($this->_View->viewVars['addActionController'])) {
					$url['controller'] = $this->_View->viewVars['addActionController'];
				}
			}
			$url = NetCommonsUrl::actionUrl(Hash::merge($defaultUrl, $url));
		}
		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'plus',
			'iconSize' => '',
			'escapeTitle' => false,
			'class' => 'btn btn-success',
		), $options);
		//$title = $inputOptions['escapeTitle'] ? h($title) : $title;
		if (! $inputOptions['escapeTitle']) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);
		//ボタンサイズ
		$inputOptions['class'] .= ' ' . h($inputOptions['iconSize']);
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		if (Hash::get($options, 'tooltip', false)) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Add');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}
		$output .= $this->Html->link($iconElement . $title, $url, $inputOptions);
		if (Hash::get($options, 'tooltip', false)) {
			$output .= '</span>';
		}
		return $output;
	}

/**
 * Creates a `<a>` tag for edit link link. The type attribute defaults
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function editLink($title = '', $url = null, $options = array()) {
		$output = '';

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'edit',
			'iconSize' => '',
			'escapeTitle' => false,
			'class' => 'btn btn-primary'
		), $options);

		if (! $inputOptions['escapeTitle']) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);

		//ボタンサイズ
		$inputOptions['class'] .= ' ' . h($inputOptions['iconSize']);
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		if (isset($options['tooltip']) && $options['tooltip']) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Edit');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}
		$output .= $this->NetCommonsHtml->editLink($iconElement . $title, $url, $inputOptions);
		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
		return $output;
	}

/**
 * 検索ボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function searchLink($title = '', $url = null, $options = array()) {
		$output = '';

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'search',
			'iconSize' => '',
			'escapeTitle' => false,
			'class' => 'btn btn-info'
		), $options);

		if (! $inputOptions['escapeTitle']) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);

		//ボタンサイズ
		$inputOptions['class'] .= ' ' . h($inputOptions['iconSize']);
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		if (isset($options['tooltip']) && $options['tooltip']) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Search');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$url = Hash::merge(array('action' => 'search'), $url);
		}
		$output .= $this->NetCommonsHtml->link($iconElement . $title, $url, $inputOptions);

		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `confirm` - Add javascript confirm in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string $confirm Confirm message by button click
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function delete($title, $confirm, $options = array()) {
		$output = '';

		$title = '<span class="glyphicon glyphicon-trash"> </span> ' . $title;

		$defaultOptions = array(
			'name' => 'delete',
			'class' => 'btn btn-danger',
			'onclick' => 'return confirm(\'' . $confirm . '\')',
			'ng-disabled' => 'sending'
		);

		if (isset($options['addClass'])) {
			if (is_string($options['addClass'])) {
				$options['addClass'] = array($options['addClass']);
			}
			foreach ($options['addClass'] as $class) {
				$defaultOptions['class'] .= ' ' . $class;
			}
			unset($options['addClass']);
		}

		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `confirm` - Add javascript confirm in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function save($title, $options = array()) {
		$output = '';

		$defaultOptions = array(
			'name' => 'save',
			'class' => 'btn btn-primary btn-workflow',
			'ng-disabled' => 'sending'
		);
		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

/**
 * Creates a `<button>` tag. The type attribute defaults to `type="submit"`
 * You can change it to a different value by using `$options['type']`.
 *
 * ### Options:
 *
 * - `escape` - HTML entity encode the $title of the button. Defaults to false.
 *
 * ### Original options
 * - `url` - The url in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param string $url The url in onclick attribute
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function cancel($title, $url, $options = array()) {
		$defaultOptions = array(
			'name' => 'cancel',
		);
		$inputOptions = Hash::merge($defaultOptions, $options);
		return $this->BackTo->button($title, $url, $inputOptions);
	}

/**
 * キャンセル、決定ボタン
 *
 * @param string $cancelTitle キャンセルボタンのラベル
 * @param string $saveTitle 決定ボタンのラベル
 * @param string $cancelUrl キャンセルボタン押下のURL
 * @param array $cancelOptions キャンセルボタンのオプション
 * @param array $saveOptions 決定ボタンのオプション
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function cancelAndSave($cancelTitle, $saveTitle, $cancelUrl = null, $cancelOptions = array(), $saveOptions = array()) {
		if (! isset($cancelUrl)) {
			$cancelUrl = NetCommonsUrl::backToPageUrl();
		}

		$output = '';
		$output .= $this->cancel($cancelTitle, $cancelUrl, $cancelOptions);
		$output .= $this->save($saveTitle, $saveOptions);
		return $output;
	}

/**
 * 検索ボタンの出力
 *
 * @param string $title タイトル
 * @param array $options button属性
 * @return string ボタンHTML.
 */
	public function search($title, $options = array()) {
		$output = '';

		$options['icon'] = Hash::get($options, 'icon', 'search');
		if ($options['icon'] !== '') {
			$iconElement = '<span class="glyphicon glyphicon-' . h($options['icon']) . '"></span> ';
			unset($options['icon']);
		} else {
			$iconElement = '';
		}

		$defaultOptions = array(
			'name' => 'search',
			'class' => 'btn btn-info btn-workflow',
		);
		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($iconElement . $title, $inputOptions);
		return $output;
	}

/**
 * 追加ボタンの出力
 *
 * @param string $title タイトル
 * @param array $options button属性
 * @return string ボタンHTML.
 */
	public function add($title, $options = array()) {
		$output = '';

		$options['icon'] = Hash::get($options, 'icon', 'plus');
		if ($options['icon'] !== '') {
			$iconElement = '<span class="glyphicon glyphicon-' . h($options['icon']) . '"></span> ';
			unset($options['icon']);
		} else {
			$iconElement = '';
		}

		$defaultOptions = array(
			'name' => 'add',
			'class' => 'btn btn-success ' . Hash::get($options, 'iconSize'),
		);
		$options = Hash::remove($options, 'iconSize');

		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($iconElement . $title, $inputOptions);
		return $output;
	}

}
