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
class NetCommonsFormHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml'
	);

/**
 * @var array タイムゾーン変換対象フィールド
 */
	protected $_convertFields = array();

/**
 * @var null デフォルトモデル名
 */
	protected $_model = null;

/**
 * @var array アップロードされたファイルの元ファイル名
 */
	protected $_uploadFileNames = array();

/**
 * Returns an HTML FORM element.
 *
 * ### Options:
 *
 * - `type` Form method defaults to POST
 * - `action`  The controller action the form submits to, (optional).
 * - `url`  The URL the form submits to. Can be a string or a URL array. If you use 'url'
 *    you should leave 'action' undefined.
 * - `default`  Allows for the creation of Ajax forms. Set this to false to prevent the default event handler.
 *   Will create an onsubmit attribute if it doesn't not exist. If it does, default action suppression
 *   will be appended.
 * - `onsubmit` Used in conjunction with 'default' to create ajax forms.
 * - `inputDefaults` set the default $options for FormHelper::input(). Any options that would
 *   be set when using FormHelper::input() can be set here. Options set with `inputDefaults`
 *   can be overridden when calling input()
 * - `encoding` Set the accept-charset encoding for the form. Defaults to `Configure::read('App.encoding')`
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
		$this->_model = $model;
		if (!isset($options['ng-submit'])) {
			$options['ng-submit'] = 'sending=true;';
		}
		if (!isset($options['novalidate'])) {
			$options['novalidate'] = true;
		}

		$output = $this->Form->create($model, $options);

		if (Hash::get($options, 'type') == 'file') {
			$output .= $this->_setupFileUploadForm();
		}
		return $output;
	}

/**
 * Filesプラグインのアップロードフォームの準備
 *
 * 現在添付されてるファイルのID、フィールド名をhidden で埋め込む
 *
 * @return string
 */
	protected function _setupFileUploadForm() {
		// setup的な処理と定型のhidden埋め込み
		$output = '';
		if (isset($this->request->data['UploadFile'])) {
			foreach (array_keys($this->request->data['UploadFile']) as $key) {
				$output .= $this->input('UploadFile.' . $key . '.id', ['type' => 'hidden']);
				$output .= $this->input('UploadFile.' . $key . '.field_name', ['type' => 'hidden']);
				$output .= $this->input('UploadFile.' . $key . '.original_name', ['type' => 'hidden']);
			}
			// uploadされた元ファイル名のリスト

			$this->_uploadFileNames = Hash::combine(
					$this->request->data['UploadFile'],
					'{s}.field_name',
					'{s}.original_name'
			);
		}
		return $output;
	}

/**
 * Overwrite FormHelper::input()
 * Generates a form input element complete with label and wrapper div
 *
 * ### Options
 *
 * See each field type method for more information. Any options that are part of
 * $attributes or $options for the different **type** methods can be included in `$options` for input().i
 * Additionally, any unknown keys that are not in the list below, or part of the selected type's options
 * will be treated as a regular html attribute for the generated input.
 *
 * - `type` - Force the type of widget you want. e.g. `type => 'select'`
 * - `label` - Either a string label, or an array of options for the label. See FormHelper::label().
 * - `div` - Either `false` to disable the div, or an array of options for the div.
 *    See HtmlHelper::div() for more options.
 * - `options` - For widgets that take options e.g. radio, select.
 * - `error` - Control the error message that is produced. Set to `false` to disable any kind of error reporting (field
 *    error and error messages).
 * - `errorMessage` - Boolean to control rendering error messages (field error will still occur).
 * - `empty` - String or boolean to enable empty select box options.
 * - `before` - Content to place before the label + input.
 * - `after` - Content to place after the label + input.
 * - `between` - Content to place between the label + input.
 * - `format` - Format template for element order. Any element that is not in the array, will not be in the output.
 *    - Default input format order: array('before', 'label', 'between', 'input', 'after', 'error')
 *    - Default checkbox format order: array('before', 'input', 'between', 'label', 'after', 'error')
 *    - Hidden input will not be formatted
 *    - Radio buttons cannot have the order of input and label elements controlled with these settings.
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @return string Completed form widget.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#creating-form-elements
 */
	public function input($fieldName, $options = array()) {
		if (Hash::get($options, 'type') === 'hidden') {
			return $this->hidden($fieldName, $options);
		}
		if (Hash::get($options, 'type') === 'datetime') {
			$options = $this->_makeDatetimeOptions($fieldName, $options);
		}
		if (Hash::get($options, 'convert_timezone') === true) {
			$this->_convertFields[] = $fieldName;
		}
		$options = Hash::merge(array(
			'error' => array(),
		), $options);

		$defaultOptions = array(
			'error' => false,
			'class' => 'form-control',
			'required' => null,
			'label' => null,
		);
		if (Hash::get($options, 'type') === 'number') {
			$defaultOptions['min'] = 0;
		}

		$inputOptions = Hash::merge($defaultOptions, $options);
		$inputOptions['error'] = false;

		if ($inputOptions['required']) {
			if ($inputOptions['label']) {
				$inputOptions['label'] .= $this->_View->element('NetCommons.required');
			}
			unset($inputOptions['required']);
		}

		$output = '';
		$outputStart = '';
		$outputEnd = '';

		if (!isset($inputOptions['div'])) {
			$outputStart = '<div class="form-group">';
			$outputEnd = '</div>';
		}

		$output .= $outputStart;

		$output .= $this->Form->input($fieldName, $inputOptions);

		if (is_array($options['error'])) {
			$output .= $this->error($fieldName, null, $options['error']);
		}

		$output .= $outputEnd;

		return $output;
	}

/**
 * Overwrite FormHelper::radio()
 *
 * ### Options
 *
 * $options = array(
 *  array('name' => 'United states', 'value' => 'US', 'title' => 'My title'),
 *  array('name' => 'Germany', 'value' => 'DE', 'class' => 'de-de', 'title' => 'Another title'),
 * );
 *
 * ### Attributes:
 *
 * - `separator` - define the string in between the radio buttons
 * - `between` - the string between legend and input set or array of strings to insert
 *    strings between each input block
 * - `legend` - control whether or not the widget set has a fieldset & legend
 * - `value` - indicate a value that is should be checked
 * - `label` - boolean to indicate whether or not labels for widgets show be displayed
 * - `hiddenField` - boolean to indicate if you want the results of radio() to include
 *    a hidden input with a value of ''. This is useful for creating radio sets that non-continuous
 * - `disabled` - Set to `true` or `disabled` to disable all the radio buttons.
 * - `empty` - Set to `true` to create an input with the value '' as the first option. When `true`
 *   the radio label will be 'empty'. Set this option to a string to control the label value.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $options Radio button options array.
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		$defaultAttributes = array(
			'error' => false,
			'div' => false,
			//'label' => false,
			'legend' => false,
		);

		$attributes = Hash::merge($defaultAttributes, $attributes);

		$output = $this->Form->radio($fieldName, $options, $attributes);
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
 * Filesプラグイン用のfileフォーム。ファイル削除チェックボックスとファイル名表示付き
 *
 * @param string $fieldName フィールド名
 * @param array $options オプション
 *  filename => false でフィアル名非表示
 *  remove => falseで削除チェックボックス非表示。デフォルトはtrue
 * @return string inputタグ等
 */
	public function uploadFile($fieldName, $options = array()) {
		if (strpos($fieldName, '.')) {
			//モデル名あり ex BlogEntry.pdf
			$inputFieldName = $fieldName;
			$fieldName = substr($fieldName, strrpos($fieldName, '.') + 1); //BlogEntry.pdf -> pdf
		} else {
			// モデル名ついてない
			$modelName = $this->Form->defaultModel;
			$inputFieldName = $modelName . '.' . $fieldName;
		}
		$output = '<div class="form-group">';
		$defaultOptions = [
			'class' => '',
			'div' => false,
			'remove' => true,
			'filename' => true,
		];
		$options = Hash::merge($defaultOptions, $options, ['type' => 'file']);

		$remove = Hash::get($options, 'remove');
		Hash::remove($options, 'remove');
		$filename = Hash::get($options, 'filename');
		Hash::remove($options, 'filename');

		$help = $help = Hash::get($options, 'help', false);
		Hash::remove($options, 'help');

		$output .= $this->input($inputFieldName, $options);

		// help-block
		if ($help) {
			$output .= $this->Html->tag('p', $help, ['class' => 'help-block']);
		}

		if (isset($this->_uploadFileNames[$fieldName])) {
			if ($filename) {
				$output .= $this->_uploadFileNames[$fieldName];
			}
			if ($remove) {
				$output .= $this->checkbox(
						$inputFieldName . '.remove',
						['type' => 'checkbox', 'div' => false, 'error' => false]
				);
				$output .= $this->Form->label($inputFieldName . '.remove', __d('net_commons', 'Delete'));
			}
		}
		$output .= '</div>';

		return $output;
	}

/**
 * Overwrite FormHelper::checkbox()
 *
 * ### Options
 *
 * $options = array(
 *  array('name' => 'United states', 'value' => 'US', 'title' => 'My title'),
 *  array('name' => 'Germany', 'value' => 'DE', 'class' => 'de-de', 'title' => 'Another title'),
 * );
 *
 * ### Attributes:
 *
 * - `separator` - define the string in between the radio buttons
 * - `between` - the string between legend and input set or array of strings to insert
 *    strings between each input block
 * - `legend` - control whether or not the widget set has a fieldset & legend
 * - `value` - indicate a value that is should be checked
 * - `label` - boolean to indicate whether or not labels for widgets show be displayed
 * - `hiddenField` - boolean to indicate if you want the results of radio() to include
 *    a hidden input with a value of ''. This is useful for creating radio sets that non-continuous
 * - `disabled` - Set to `true` or `disabled` to disable all the radio buttons.
 * - `empty` - Set to `true` to create an input with the value '' as the first option. When `true`
 *   the radio label will be 'empty'. Set this option to a string to control the label value.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function inlineCheckbox($fieldName, $attributes = array()) {
		$defaultAttributes = array(
			'error' => false,
			'div' => array('class' => 'form-inline'),
			'label' => false,
			'legend' => false,
		);

		$inputAttributes = Hash::merge($defaultAttributes, $attributes);

		$output = '<div class="form-group">';
		$output .= $this->Form->input($fieldName, $inputAttributes);

		if (!isset($attributes['error']) || $attributes['error']) {
			$output .= $this->error($fieldName);
		}

		$output .= '</div>';
		return $output;
	}

/**
 * Overwrite FormHelper::input($fieldName, array('type' => 'textarea'))
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function wysiwyg($fieldName, $attributes = array()) {
		$ngModel = Hash::expand(array($fieldName => 0));
		$ngModel = NetCommonsAppController::camelizeKeyRecursive($ngModel);
		$ngModel = Hash::flatten($ngModel);
		$ngModel = array_flip($ngModel);

		$defaultAttributes = array(
			'type' => 'textarea',
			'ui-tinymce' => 'tinymce.options',
			'ng-model' => $ngModel[0],
			'rows' => 5,
		);
		$attributes = Hash::merge($defaultAttributes, $attributes);

		$html = '';
		$html .= $this->NetCommonsHtml->script(array(
			'/wysiwyg/js/wysiwyg.js',
			'/components/tinymce-dist/tinymce.min.js',
			'/components/angular-ui-tinymce/src/tinymce.js',
		));
		$html .= $this->input($fieldName, $attributes);

		return $html;
	}

/**
 * FormHelperラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->Form, $method), $params);
	}

/**
 * Timezone変換の準備を組み込んだForm::end
 *
 * @param null|array $options オプション
 * @param array $secureAttributes secureAttributes
 * @return string
 */
	public function end($options = null, $secureAttributes = array()) {
		// modelをみてdatetime
		$out = $this->Form->hidden('_NetCommonsTime.user_timezone', array('value' => Current::read('User.timezone')));
		$out .= $this->Form->hidden('_NetCommonsTime.convert_fields', array('value' => implode(',', $this->_convertFields)));
		$out .= $this->Form->end($options, $secureAttributes);
		return $out;
	}

/**
 * datimepicker用オプション指定
 *
 * @param string $fieldName フィールド名
 * @param array $options オプション
 * @return mixed
 */
	protected function _makeDatetimeOptions($fieldName, $options) {
		$options['type'] = 'text';
		$options['datetimepicker'] = true;
		$options['convert_timezone'] = true;
		// ng-modelを指定してなくてもdatetimepickerが動くようにする
		if (!isset($options['ng-model'])) {
			$options['ng-model'] = 'NetCommonsFormDatimePickerModel_' . $fieldName;
			//'ng-init' => 'hoge=\'2011-01-01\'',
			// value > request->data > default
			$value = '';
			if (isset($options['value'])) {
				$value = $options['value'];
			} elseif (isset($this->request->data[$this->_model][$fieldName])) {
				$value = $this->request->data[$this->_model][$fieldName];
			} elseif (isset($options['default'])) {
				$value = $options['default'];
			}
			$netCommonsTime = new NetCommonsTime();

			$value = $netCommonsTime->toUserDatetime($value);

			$options['ng-init'] = sprintf(
				'%s=\'%s\'',
				$options['ng-model'],
				$value
			);
			return $options;
		}
		return $options;
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
		$output .= $this->Form->error($fieldName, $text, Hash::merge(array('class' => 'help-block'), $options));
		$output .= '</div>';

		return $output;
	}

}
