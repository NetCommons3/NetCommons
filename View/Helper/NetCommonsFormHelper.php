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
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NetCommonsFormHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'Files.FilesForm',
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
		'NetCommons.NetCommonsTime',
		'NetCommons.DatetimePicker',
	);

/**
 * 各プラグインFormHelperラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if ($method === 'uploadFile') {
			//アップロード
			$helper = $this->FilesForm;

		} elseif ($method === 'wysiwyg') {
			//WYSIWYG
			$this->Wysiwyg = $this->_View->loadHelper('Wysiwyg.Wysiwyg');
			$helper = $this->Wysiwyg;

		} elseif (in_array($method, ['inlineCheckbox', 'inlineRadio'], true)) {
			//checkbox、radioのインライン
			$helper = $this;
			$type = strtolower(substr($method, strlen('inline')));
			$method = 'input';

			$params = Hash::insert($params, '1.type', $type);
			$params = Hash::insert($params, '1.class', false);
			$params = Hash::insert($params, '1.childDiv', array('class' => 'form-inline'));

		} elseif (in_array($method,
						['inputWithTitleIcon', 'titleIconPicker', 'ngTitleIconPicker'], true)) {
			//タイトルアイコン
			$this->TitleIcon = $this->_View->loadHelper('NetCommons.TitleIcon');
			$helper = $this->TitleIcon;

		} else {
			//それ以外
			$helper = $this->Form;
		}
		return call_user_func_array(array($helper, $method), $params);
	}

/**
 * Returns an HTML FORM element.
 *
 * @param mixed $model The model name for which the form is being defined. Should
 *   include the plugin name for plugin models. e.g. `ContactManager.Contact`.
 *   If an array is passed and $options argument is empty, the array will be used as options.
 *   If `false` no model is used.
 * @param array $options An array of html attributes and options.
 * @return string A formatted opening FORM tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-create
 */
	public function create($model = null, $options = array()) {
		$options['ng-submit'] = Hash::get($options, 'ng-submit', 'submit($event)');
		$options['novalidate'] = Hash::get($options, 'novalidate', true);

		$output = $this->Form->create($model, $options);

		if (Hash::get($options, 'type') === 'file') {
			$output .= $this->FilesForm->setupFileUploadForm();
		}
		return $output;
	}

/**
 * Overwrite FormHelper::input()
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options オプション配列
 * @return string HTML
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#creating-form-elements
 */
	public function input($fieldName, $options = array()) {
		if (Hash::get($options, 'type') === 'hidden') {
			return $this->hidden($fieldName, $options);
		}

		//DatetimePicker用処理
		$options = $this->DatetimePicker->beforeFormInput($fieldName, $options);

		//TimeZoneのコンバートするinputのセットアップ
		$this->NetCommonsTime->beforeFormInput($fieldName, $options);

		$options = Hash::merge(array(
			'error' => array(),
		), $options);

		$defaultOptions = array(
			'error' => false,
			//'class' => 'form-control',
			'required' => null,
			'label' => null,
		);
		if (Hash::get($options, 'type') === 'number') {
			$defaultOptions['min'] = 0;
		}

		$inputOptions = Hash::merge($defaultOptions, $options);
		$inputOptions['error'] = false;

		//Form->inputには含めないため、divの設定を取得しておく
		$type = Hash::get($inputOptions, 'type', 'text');
		$divOption = $this->__getDivOption($type, $inputOptions, 'div', array('class' => 'form-group'));
		$inputOptions = Hash::remove($inputOptions, 'div');
		$inputOptions = Hash::insert(
			$inputOptions, 'div', $this->__getDivOption($type, $inputOptions, 'childDiv', false)
		);
		$inputOptions = Hash::remove($inputOptions, 'childDiv');

		//Form->input
		$input = '';
		if ($this->Form->error($fieldName)) {
			$input .= '<div class="has-error">';
			$input .= $this->_input($fieldName, $inputOptions);
			$input .= '</div>';
		} else {
			$input .= $this->_input($fieldName, $inputOptions);
		}

		if (Hash::get($inputOptions, 'help')) {
			$input .= $this->help(Hash::get($inputOptions, 'help'));
		}

		//error出力
		if (is_array($options['error'])) {
			$input .= $this->error($fieldName, null, $options['error']);
		}

		if ($divOption) {
			return $this->NetCommonsHtml->div(null, $input, $divOption);
		} else {
			return $input;
		}
	}

/**
 * <input>の出力
 *
 * @param string $fieldName フィールド名("Modelname.fieldname"形式)
 * @param array $options inputのオプション配列
 * @return string HTML
 */
	protected function _input($fieldName, $options = array()) {
		$output = '';

		if (Hash::get($options, 'type') === 'radio') {
			//ラジオボタン
			if (Hash::get($options, 'label')) {
				$label = $this->label($fieldName, $options['label'], array('required' => $options['required']));
				$options = Hash::remove($options, 'required');
				$options = Hash::insert($options, 'label', false);
				$output .= $label;
				$options['outer'] = true;
			}
			$attributes = Hash::remove($options, 'options');
			$output .= $this->radio($fieldName, Hash::get($options, 'options', array()), $attributes);

		} elseif (Hash::get($options, 'type') === 'checkbox') {
			//チェックボックス
			$output .= $this->checkbox($fieldName, $options);

		} elseif (Hash::get($options, 'multiple') === 'checkbox') {
			//複数チェックボックス
			if (Hash::get($options, 'label')) {
				$label = $this->label($fieldName, $options['label'], ['required' => $options['required']]);
				$options = Hash::remove($options, 'required');
				$options = Hash::insert($options, 'label', false);
				$output .= $label;
				$options['outer'] = true;
			}
			$output .= $this->_multipleCheckbox($fieldName, $options);

		} else {
			if (Hash::get($options, 'type') !== 'file') {
				$options = Hash::insert($options, 'class', 'form-control');
			}
			if (Hash::get($options, 'label')) {
				$output .= $this->label($fieldName, $options['label'], ['required' => $options['required']]);
				$options = Hash::remove($options, 'required');
				$options = Hash::insert($options, 'label', false);
			}
			$output .= $this->Form->input($fieldName, $options);
		}

		return $output;
	}

/**
 * divのオプション取得
 *
 * @param string $type inputのタイプ
 * @param array $options inputのオプション配列
 * @param string $key オプションキー
 * @param mixed $default デフォルト値
 * @return array $options divオプション
 */
	private function __getDivOption($type, $options, $key, $default = array()) {
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
 * @param array $attributes HTML属性配列
 * @return string HTML
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		$defaultAttributes = array(
			'error' => false,
			'div' => false,
			'label' => false,
			'legend' => false,
		);
		$divOption = $this->__getDivOption('radio', $attributes, 'div', array());

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
 * @param array $options オプション配列
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

		$divOption = $this->__getDivOption('checkbox', $options, 'div', array());
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
			$output .= $this->error($fieldName);
		}

		return $output;
	}
/**
 * Returns a formatted SELECT element.
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the OPTION elements (as 'value'=>'Text' pairs) to be used in the
 *	SELECT element
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted SELECT element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function select($fieldName, $options = array(), $attributes = array()) {
		if (Hash::get($attributes, 'multiple') === 'checkbox') {
			$attributes['options'] = $options;
			return $this->_multipleCheckbox($fieldName, $attributes);
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
	protected function _multipleCheckbox($fieldName, $options = array()) {
		$output = '';
		$input = '';
		$divOption = $this->__getDivOption('select', $options, 'div', array());

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
 * Timezone変換の準備を組み込んだForm::end
 *
 * @param null|array $options オプション
 * @param array $secureAttributes secureAttributes
 * @return string
 */
	public function end($options = null, $secureAttributes = array()) {
		$out = '';

		$this->DatetimePicker->beforeFormEnd();

		$out .= $this->NetCommonsTime->beforeFormEnd();

		$out .= $this->Form->end($options, $secureAttributes);
		return $out;
	}

/**
 * Overwrite FormHelper::error()
 *
 * @param string $fieldName A field name, like "Modelname.fieldname"
 * @param string|array $text Error message as string or array of messages.
 *   If array contains `attributes` key it will be used as options for error container
 * @param array $options Rendering options for <div /> wrapper tag
 * @return string error html
 */
	public function error($fieldName, $text = null, $options = array()) {
		$output = '';

		$output .= '<div class="has-error">';
		$output .= $this->Form->error(
			$fieldName, $text, Hash::merge(['class' => 'help-block'], $options)
		);
		$output .= '</div>';

		return $output;
	}

/**
 * ヘルプブロックの表示
 *
 * @param string $helpText ヘルプテキスト
 * @return string HTML
 */
	public function help($helpText) {
		$output = '';

		if ($helpText) {
			$output .= '<div class="help-block">';
			$output .= $helpText;
			$output .= '</div>';
		}

		return $output;
	}

/**
 * <label>タグの表示
 *
 * @param string $fieldName フィールド名 "Modelname.fieldname"
 * @param string $labelText ラベルテキスト
 * @param array $options オプション
 * @param bool $returnHtml 戻り値をHTMLにするか配列にするか
 * @return string|array HTMLもしくはoption配列
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function label($fieldName = null, $labelText = null, $options = [], $returnHtml = true) {
		if (! $labelText) {
			return $this->Form->label($fieldName, $labelText, $options);
		}

		if (Hash::get($options, 'required', false)) {
			$labelText .= $this->_View->element('NetCommons.required');
		}
		$options = Hash::merge(array('class' => 'control-label'), $options);

		if ($returnHtml) {
			return $this->Form->label($fieldName, $labelText, $options);
		} else {
			$options['text'] = $labelText;
			return $options;
		}
	}

}

