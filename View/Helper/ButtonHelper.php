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
		'NetCommons.LinkButton',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * LinkButtonHelperラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if (in_array($method, ['addLink', 'editLink', 'searchLink', 'sortLink'], true)) {
			$method = substr($method, 0, -4);
			return call_user_func_array(array($this->LinkButton, $method), $params);
		}
	}

/**
 * ボタンサイズ取得
 *
 * @return string A HTML button tag.
 */
	public function getButtonSize() {
		if ($this->_View->request->is('mobile')) {
			$btnSize = ' btn-sm';
		} else {
			$btnSize = '';
		}
		return $btnSize;
	}

/**
 * <button>タグの出力
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string <button>タグ
 */
	public function button($title, $options = array()) {
		$icon = Hash::get($options, 'icon');
		if ($icon) {
			$title = '<span class="glyphicon ' . $icon . '"></span> ' . $title;
			$options = Hash::remove($options, 'icon');
			$options = Hash::insert($options, 'escape', false);
		}
		if (Hash::check($options, 'class')) {
			if (is_string(Hash::get($options, 'class'))) {
				$class = explode(' ', trim(Hash::get($options, 'class')));
			} else {
				$class = Hash::get($options, 'class', array());
			}
			if (in_array('btn', $class, true)) {
				if ($this->_View->request->is('mobile')) {
					$btnSize = 'btn-sm';
					$class = array_merge($class, array($btnSize));
				}
			}
			$options = Hash::insert($options, 'class', $class);
		}
		return $this->NetCommonsForm->button($title, $options);
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
			'class' => 'btn btn-danger' . $this->getButtonSize(),
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
		if (isset($options['icon'])) {
			$title .= '<span class="glyphicon glyphicon-' . $options['icon'] . '"></span>';
		}
		$output = '';

		$defaultOptions = array(
			'name' => 'save',
			'class' => 'btn btn-primary' . $this->getButtonSize() . ' btn-workflow',
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
 * キャンセル、一時保存、決定ボタン
 *
 * @param string $cancelUrl キャンセルボタン押下のURL
 * @param array $cancelOptions キャンセルボタンのオプション
 * @param array $saveTempOptions 一時保存ボタンのオプション
 * @param array $saveOptions 決定ボタンのオプション
 * @param string|null $backUrl Back url
 * @return string ボタン群のタグ.
 */
	public function cancelAndSaveAndSaveTemp($cancelUrl = null, $cancelOptions = array(), $saveTempOptions = array(), $saveOptions = array(), $backUrl = null) {
		App::uses('WorkflowComponent', 'Workflow.Controller/Component');

		if (! isset($cancelUrl)) {
			$cancelUrl = NetCommonsUrl::backToPageUrl();
		}
		$output = '';

		//キャンセル
		$cancelOptions = Hash::merge(array(
			'class' => 'btn btn-default' . $this->getButtonSize() . ' btn-workflow', 'escape' => false
		), $cancelOptions);

		$label = Hash::get($cancelOptions, 'label', __d('net_commons', 'Cancel'));
		$cancelOptions = Hash::remove($cancelOptions, 'label');

		$output .= $this->Html->link(
			'<span class="glyphicon glyphicon-remove"></span> ' . $label,
			$cancelUrl,
			$cancelOptions
		);

		//戻るボタン
		if (isset($backUrl)) {
			$output .= $this->Html->link(
				'<span class="glyphicon glyphicon-chevron-left"></span> ' . __d('net_commons', 'BACK'),
				$backUrl,
				array('class' => 'btn btn-default' . $this->getButtonSize() . ' btn-workflow', 'escape' => false)
			);
		}

		//一時保存ボタン
		$saveTempOptions = Hash::merge(array(
			'class' => 'btn btn-info' . $this->getButtonSize() . ' btn-workflow',
			'name' => 'save_' . WorkflowComponent::STATUS_IN_DRAFT,
		), $saveTempOptions);

		$label = Hash::get($saveTempOptions, 'label', __d('net_commons', 'Save temporally'));
		$saveTempOptions = Hash::remove($saveTempOptions, 'label');

		$output .= $this->Form->button($label, $saveTempOptions);

		//決定ボタン
		$saveOptions = Hash::merge(array(
			'class' => 'btn btn-primary' . $this->getButtonSize() . ' btn-workflow',
			'name' => 'save_' . WorkflowComponent::STATUS_PUBLISHED,
		), $saveOptions);

		$label = Hash::get($saveOptions, 'label', __d('net_commons', 'OK'));
		$saveOptions = Hash::remove($saveOptions, 'label');

		$output .= $this->Form->button($label, $saveOptions);

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
			'class' => 'btn btn-info' . $this->getButtonSize() . ' btn-workflow',
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
			'class' => 'btn' . $this->getButtonSize() . ' btn-success ' . Hash::get($options, 'iconSize'),
		);
		$options = Hash::remove($options, 'iconSize');

		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($iconElement . $title, $inputOptions);
		return $output;
	}
}
