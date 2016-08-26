<?php
/**
 * FormInputHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * FormInputHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class FormInputHelper extends AppHelper {

/**
 * 使用するHelpers
 *
 * - [FormHelper](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html)
 * - [HtmlHelper](http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html)
 * - [NetCommons.NetCommonsFormHelper](../../NetCommons/classes/NetCommonsFormHelper.html)
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.NetCommonsForm',
		'Users.DisplayUser',
	);

/**
 * $optionsの中身をarray('div' => css文字列)をarray('div' => ['class' => css文字列])に変換して出力する
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
 * ラジオボタンを出力する
 *
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options radioのオプション配列
 * @param array $attributes HTML属性オプション配列
 * @return string
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::radio FormHelper::radio()
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#select-checkbox-radio checkbox, radio に関するオプション
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

		//後で消すかも
		if ($divOption && strpos(Hash::get($divOption, 'class', ''), 'form-inline') !== false) {
			$attributes = Hash::insert($attributes, 'inline', true);
		}

		$radioClass = 'radio';
		if (Hash::get($attributes, 'inline')) {
			$radioClass .= ' radio-inline';
			$attributes = Hash::remove($attributes, 'inline');
		}

		$input = '';

		$befor = Hash::get($attributes, 'before', '');
		$separator = Hash::get($attributes, 'separator', '');
		$separator = '</label></div>' .	$separator .
					'<div class="' . $radioClass . '"><label class="control-label">';
		$after = Hash::get($attributes, 'after', '');

		$attributes = Hash::merge($attributes, array('separator' => $separator));
		$input .= '<div class="' . $radioClass . '"><label class="control-label">' . $befor;

		$attributes = Hash::remove($attributes, 'outer');
		$input .= $this->Form->radio($fieldName, $options, $attributes);
		$input .= $after . '</label></div>';

		if ($divOption) {
			$input = $this->Html->div(null, $input, $divOption);
		}

		$output = '';
		$output .= $input;

		if (Hash::get($attributes, 'error', true)) {
			$output .= $this->NetCommonsForm->error($fieldName);
		}

		return $output;
	}

/**
 * チェックボックスを出力する
 *
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options checkboxオプション配列
 * @return string
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::checkbox FormHelper::checkbox()
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#select-checkbox-radio checkbox, radio に関するオプション
 */
	public function checkbox($fieldName, $options = array()) {
		$defaultOptions = array(
			'type' => 'checkbox',
			'error' => false,
			'legend' => false,
		);

		$escape = Hash::get($options, 'escape', true);
		$options = Hash::remove($options, 'escape');

		//divタグの設定
		$divOption = $this->getDivOption('checkbox', $options, 'div', array());
		$options = Hash::insert($options, 'div', false);
		$options = Hash::remove($options, 'outer');

		//チェックボックスのclass属性
		$checkboxClass = 'checkbox';
		if (Hash::get($options, 'inline')) {
			$checkboxClass .= ' checkbox-inline';
		}

		//チェックボックス出力
		$input = '';

		if (Hash::get($options, 'options')) {
			$checkboxes = Hash::get($options, 'options');
			$options = Hash::remove($options, 'options');

			$default = Hash::get($options, 'default', array());
			$options = Hash::remove($options, 'default');

			$inputOptions = Hash::merge($defaultOptions, $options);

			$index = 0;
			foreach ($checkboxes as $key => $label) {
				$domId = $this->domId($fieldName . $index);

				$inputOptions['id'] = $domId;
				$inputOptions['value'] = $key;
				$inputOptions['checked'] = in_array($key, $default, true);

				$input .= $this->__bootstrapCheckbox(
					$fieldName . '.' . $index, $checkboxClass, $label, $escape, $inputOptions
				);

				$index++;
			}
		} else {
			$label = Hash::get($options, 'label', '');
			$options = Hash::insert($options, 'label', false);

			$inputOptions = Hash::merge($defaultOptions, $options);
			$inputOptions = Hash::remove($inputOptions, 'inline');

			$domId = Hash::get($inputOptions, 'id', $this->domId($fieldName));

			if ($label || Hash::check($options, 'inline')) {
				$input .= $this->__bootstrapCheckbox(
					$fieldName, $checkboxClass, $label, $escape, $inputOptions
				);
			} else {
				$input .= $this->Form->input($fieldName, $inputOptions);
			}
		}

		$output = '';
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
 * Bootstrapのチェックボックスを出力する
 *
 * @param string $fieldName フィールド名
 * @param string $checkboxClass チェックボックスclass属性
 * @param string $label ラベル
 * @param bool $escape エスケープフラグ
 * @param array $inputOptions HTMLの属性オプション
 * @return string
 */
	private function __bootstrapCheckbox($fieldName, $checkboxClass, $label, $escape, $inputOptions) {
		$domId = Hash::get($inputOptions, 'id', $this->domId($fieldName));
		$inputOptions = Hash::remove($inputOptions, 'type');

		$input = '<div class="' . $checkboxClass . '">';
		$input .= '<label class="control-label" for="' . $domId . '">';
		$input .= $this->Form->checkbox($fieldName, $inputOptions);
		if ($escape) {
			$input .= h($label);
		} else {
			$input .= $label;
		}
		$input .= '</label>';
		$input .= '</div>';

		return $input;
	}

/**
 * セレクトボックスを出力する
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options selectオプション配列
 * - multiple=checkboxを指定している場合<br>
 * [FormInputHelper::multipleCheckbox()](#method_multipleCheckbox)
 * を実行する。
 *
 * - それ以外の場合<br>
 * [FormHelper::select()](http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::select)
 * を実行する
 *
 * @param array $attributes HTMLの属性オプション
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::select FormHelper::select()
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#select-checkbox-radio checkbox, radio に関するオプション
 * @see https://netcommons3.github.io/NetCommons3Docs/phpdoc/NetCommons/classes/FormInputHelper.html#method_multipleCheckbox NetCommons.FormInputHelper::multipleCheckbox()
 * @return string
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
 * 複数チェックボックスを出力する
 *
 * ##### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options オプション配列
 * @return string
 * @see http://book.cakephp.org/2.0/ja/core-libraries/helpers/form.html#FormHelper::select FormHelper::select()
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
 * NetCommons用にFormHelper::hidden()を付与してHTMLを出力する
 *
 * 値がfalseの場合、hiddenのvalueが消えてしまい、validationErrorになってしまう。<br>
 * {@link https://github.com/cakephp/cakephp/issues/5639}
 *
 * #### サンプル
 * - 入力
 * ```
 * $this->request->data['BbsSetting']['use_comment'] = false;
 * ```
 * ```
 * echo $this->NetCommonsForm->hidden('BbsSetting.use_comment');
 * ```
 * - 出力
 * ```
 * <input type="hidden" name="data[BbsSetting][use_comment]" value="0" id="BbsSettingUseComment"/>
 * ```
 *
 * @param string $fieldName フィールド名, like this "Modelname.fieldname"
 * @param array $options hiddenのオプション
 * @return string
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
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options passwordオプション
 * @return string
 */
	public function password($fieldName, $options = array()) {
		$input = '';

		$divOption = $this->getDivOption('password', $options, 'div');

		$current = Hash::get($options, 'current', false);
		$options = Hash::remove($options, 'current');

		$again = Hash::get($options, 'again', false);
		$options = Hash::remove($options, 'again');

		$options = Hash::merge(
			array(
				'type' => 'password',
				'label' => false,
				'div' => false,
				'class' => 'form-control',
				'autocomplete' => 'off',
			),
			$options
		);

		if ($current) {
			$options = Hash::merge(
				$options,
				array(
					'placeholder' => __d('net_commons', 'Enter current password.'),
					'class' => 'form-control form-input-again'
				)
			);
			$input .= $this->Form->input($fieldName . '_current', $options);

			$options = Hash::merge(
				$options,
				array(
					'placeholder' => __d('net_commons', 'Enter new password.'),
					'class' => 'form-control form-input-again'
				)
			);
			//入力フォーム
			$input .= $this->Form->input($fieldName, $options);

		} else {
			//入力フォーム
			$input .= $this->Form->input($fieldName, $options);
		}

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

/**
 * emailの出力
 *
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options emailオプション
 * @return string
 */
	public function email($fieldName, $options = array()) {
		$input = '';

		$divOption = $this->getDivOption('email', $options, 'div');

		$again = Hash::get($options, 'again', false);
		$options = Hash::remove($options, 'again');

		$options = Hash::merge(
			array(
				'type' => 'text',
				'label' => false,
				'div' => false,
				'class' => 'form-control',
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

/**
 * ラベルの出力
 *
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options label型のオプション
 * @return string
 */
	public function label($fieldName, $options = array()) {
		$input = '';

		$input .= '<div class="form-label-input-outer form-control">';
		if (isset($options['value'])) {
			$input .= Hash::get($options, 'value');
		} else {
			$input .= Hash::get($this->_View->request->data, $fieldName);
		}
		$input .= '</div>';

		return $input;
	}

/**
 * ハンドルの出力
 *
 * #### サンプル
 * - 入力
 * ```
 * ```
 * - 出力
 * ```
 * ```
 *
 * @param string $modelName モデル名
 * @param array $attributes リンクタグの属性。array('avatar' => true)とするとアバターも表示する
 * @param array $options リンクタグのオプション
 * @return string
 */
	public function handle($modelName, $attributes = [], $options = []) {
		$input = '';

		$user = Hash::get($attributes, 'user', $this->_View->request->data);
		$attributes = Hash::remove($attributes, 'user');
		$attributes = Hash::merge(['avatar' => true], $attributes);

		$input .= '<div class="form-input-outer">';
		$input .= $this->DisplayUser->handleLink($user, $attributes, $options, $modelName);
		$input .= '</div>';

		return $input;
	}

}

