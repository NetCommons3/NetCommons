<?php
/**
 * getDivOption
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * getDivOption
 *
 * @package NetCommons\NetCommons\View\Helper
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FormInputHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.NetCommonsForm',
	);

/**
 * divのオプション取得
 *
 * @param string $type inputのタイプ
 * @param array $options inputのオプション配列
 * @param string $key オプションキー
 * @param mixed $default デフォルト値
 * @return array $options divオプション
 */
	public function getDivOption($type, $options, $key, $default = array()) {
		$divOption = Hash::get($options, $key, $default);
		if (is_string($divOption)) {
			$divOption = array('class' => $divOption);
		}

		$outer = Hash::get($options, 'outer', false);
		if ($outer && in_array($type, ['radio', 'checkbox'], true)) {
			if (! $divOption) {
				$divOption = array();
			}
			$divOption['class'] = Hash::get($divOption, 'class', '');
			$divOption['class'] .= ' form-' . $type . '-outer';
			$divOption['class'] = trim($divOption['class']);
		}

		return $divOption;
	}

/**
 * Overwrite FormHelper::radio()
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options radioのオプション配列
 * @param array $attributes HTML属性オプション配列
 * @return string HTML
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		$defaultAttributes = array(
			'error' => false,
			'div' => false,
			'label' => false,
			'legend' => false,
		);
		$divOption = $this->getDivOption('radio', $attributes, 'div', array());

		$attributes = Hash::merge($defaultAttributes, $attributes);
		$attributes = Hash::insert($attributes, 'div', false);

		$radioClass = 'radio';
		if ($divOption && strpos(Hash::get($divOption, 'class', ''), 'form-inline') !== false) {
			$radioClass .= ' radio-inline';
		}

		$input = '';

		$befor = Hash::get($attributes, 'before', '');
		$separator = Hash::get($attributes, 'separator', '');
		$after = Hash::get($attributes, 'after', '');

		$attributes = Hash::merge($attributes, array(
			'separator' => '</label></div>' .
						$separator .
						'<div class="' . $radioClass . '"><label class="control-label">',
		));

		$input .= '<div class="' . $radioClass . '"><label class="control-label">' . $befor;

		$attributes = Hash::remove($attributes, 'outer');
		$input .= $this->Form->radio($fieldName, $options, $attributes);
		$input .= $after . '</label></div>';

		if ($divOption) {
			$input = $this->Html->div(null, $input, $divOption);
		}

		$output = '';
		$output .= $input;

		return $output;
	}

/**
 * Overwrite FormHelper::checkbox()
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options checkboxオプション配列
 * @return string HTML
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function checkbox($fieldName, $options = array()) {
		$defaultOptions = array(
			'error' => false,
			'legend' => false,
		);

		$escape = Hash::get($options, 'escape', true);
		$label = Hash::get($options, 'label', '');
		if ($escape) {
			$label = h($label);
		}

		$options = Hash::insert($options, 'label', false);

		$divOption = $this->getDivOption('checkbox', $options, 'div', array());
		$options = Hash::insert($options, 'div', false);

		$inputOptions = Hash::merge($defaultOptions, $options, array('type' => 'checkbox'));

		$output = '';

		$input = '';
		if ($label) {
			$input .= '<div class="checkbox">';
			$input .= '<label class="control-label" for="' . $this->domId($fieldName) . '">';
			$input .= $this->Form->input($fieldName, $inputOptions);
			$input .= $label;
			$input .= '</label>';
			$input .= '</div>';
		} else {
			$input .= $this->Form->input($fieldName, $inputOptions);
		}

		if ($divOption) {
			$output .= $this->Html->div(null, $input, $divOption);
		} else {
			$output .= $input;
		}

		if (Hash::get($inputOptions, 'error', true)) {
			$output .= $this->NetCommonsForm->error($fieldName);
		}

		return $output;
	}

/**
 * Returns a formatted SELECT element.
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options selectオプション配列
 * @param array $attributes HTMLの属性オプション
 * @return string HTML
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function select($fieldName, $options = array(), $attributes = array()) {
		if (Hash::get($attributes, 'multiple') === 'checkbox') {
			$attributes['options'] = $options;
			return $this->multipleCheckbox($fieldName, $attributes);
		} else {
			return $this->Form->select($fieldName, $options, $attributes);
		}
	}

/**
 * 複数チェックボックス
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options オプション配列
 * @return string HTML
 */
	public function multipleCheckbox($fieldName, $options = array()) {
		$output = '';
		$input = '';
		$divOption = $this->getDivOption('select', $options, 'div', array());

		$checkboxClass = 'checkbox nc-multiple-checkbox';
		if ($divOption && strpos(Hash::get($divOption, 'class', ''), 'form-inline') !== false) {
			$checkboxClass .= ' checkbox-inline';
		}
		$options['class'] = Hash::get($options, 'class', $checkboxClass);

		$inputOptions = Hash::remove($options, 'options');
		$inputOptions = Hash::remove($inputOptions, 'outer');
		$input .= $this->Form->select($fieldName, $options['options'], $inputOptions);

		if ($divOption) {
			$input = $this->Html->div(null, $input, $divOption);
		} elseif (Hash::get($options, 'outer')) {
			$input = $this->Html->div(null, $input);
		}

		$output .= $input;

		return $output;
	}

/**
 * Overwrite FormHelper::hidden()
 *
 * 値がfalseの場合、hiddenのvalueが消えてしまい、validationErrorになってしまう。
 *
 * @param string $fieldName フィールド名, like this "Modelname.fieldname"
 * @param array $options hiddenのオプション
 * @return string Completed hiddenタグ
 * @link https://github.com/cakephp/cakephp/issues/5639
 */
	public function hidden($fieldName, $options = array()) {
		if (strpos($fieldName, '.')) {
			//モデル名あり ex BlogEntry.pdf
			$inputFieldName = $fieldName;
		} else {
			// モデル名ついてない
			$modelName = $this->Form->defaultModel;
			$inputFieldName = $modelName . '.' . $fieldName;
		}

		if (Hash::get($this->_View->data, $inputFieldName) === false) {
			$options = Hash::merge(array(
				'value' => (int)Hash::get($this->_View->data, $inputFieldName),
			), $options);
		}

		$output = $this->Form->hidden($fieldName, $options);
		return $output;
	}

/**
 * パスワードの出力
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options passwordオプション
 * @return string HTML
 */
	public function password($fieldName, $options = array()) {
		$input = '';

		$divOption = $this->getDivOption('password', $options, 'div');

		$again = Hash::get($options, 'again', false);
		$options = Hash::remove($options, 'again');

		$options = Hash::merge(
			array(
				'type' => 'password',
				'label' => false,
				'div' => false,
				'class' => 'form-control',
				'autocomplete' => 'off'
			),
			$options
		);

		//入力フォーム
		$input .= $this->Form->input($fieldName, $options);

		//再度入力フォーム
		if ($again) {
			$options = Hash::merge(
				$options,
				array(
					'placeholder' => __d('net_commons', 'For confirmation, please re-enter.'),
					'class' => 'form-control form-input-again'
				)
			);
			$input .= $this->Form->input($fieldName . '_again', $options);
		}

		if ($divOption) {
			return $this->Html->div(null, $input, $divOption);
		} else {
			return $input;
		}
	}

}

