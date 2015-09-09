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

App::uses('FormHelper', 'View/Helper');

/**
 * NetCommonsFormHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class NetCommonsFormHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.BackHtml',
		'NetCommons.Button'
	);

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
 *	See HtmlHelper::div() for more options.
 * - `options` - For widgets that take options e.g. radio, select.
 * - `error` - Control the error message that is produced. Set to `false` to disable any kind of error reporting (field
 *    error and error messages).
 * - `errorMessage` - Boolean to control rendering error messages (field error will still occur).
 * - `empty` - String or boolean to enable empty select box options.
 * - `before` - Content to place before the label + input.
 * - `after` - Content to place after the label + input.
 * - `between` - Content to place between the label + input.
 * - `format` - Format template for element order. Any element that is not in the array, will not be in the output.
 *	- Default input format order: array('before', 'label', 'between', 'input', 'after', 'error')
 *	- Default checkbox format order: array('before', 'input', 'between', 'label', 'after', 'error')
 *	- Hidden input will not be formatted
 *	- Radio buttons cannot have the order of input and label elements controlled with these settings.
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @return string Completed form widget.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#creating-form-elements
 */
	public function input($fieldName, $options = array()) {
		$defaultOptions = array(
			'error' => false,
			'class' => 'form-control',
			'required' => null,
			'label' => null,
		);
		if (isset($options['type'])) {
			if ($options['type'] === 'number') {
				$defaultOptions['min'] = 0;
			}
		}

		$inputOptions = Hash::merge($defaultOptions, $options);

		if ($inputOptions['required']) {
			if ($inputOptions['label']) {
				$inputOptions['label'] .= $this->_View->element('NetCommons.required');
			}
			unset($inputOptions['required']);
		}

		$output = '';

		if (! isset($inputOptions['div'])) {
			$output .= '<div class="form-group">';
		}

		$output .= $this->Form->input($fieldName, $inputOptions);

		if (! isset($options['error']) || $options['error']) {
			$output .= '<div class="has-error">';
			$output .= $this->Form->error($fieldName, null, array('class' => 'help-block'));
			$output .= '</div>';
		}

		if (! isset($inputOptions['div'])) {
			$output .= '</div>';
		}

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
			'label' => false,
			'legend' => false,
		);

		$attributes = Hash::merge($defaultAttributes, $attributes);

		$output = $this->Form->radio($fieldName, $options, $attributes);
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

		if (! isset($attributes['error']) || $attributes['error']) {
			$output .= '<div class="has-error">';
			$output .= $this->Form->error($fieldName, null, array('class' => 'help-block'));
			$output .= '</div>';
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
		return $this->input($fieldName, $attributes);
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param string $value The content key
 * @param string $title The anchor's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function editLink($value, $title = '', $url = null, $options = array()) {
		//URLの設定
		if (! isset($url)) {
			$url = '/' . $this->_View->request->params['plugin'] . '/';
			if (! isset($this->_View->viewVars['editActionController'])) {
				$url .= $this->_View->request->params['controller'] . '/';
			} else {
				$url .= $this->_View->viewVars['editActionController'] . '/';
			}
			$url .= 'edit/';
			if (Current::read('Frame.id')) {
				$url .= Current::read('Frame.id') . '/';
			}
		}
		if ($value) {
			$url .= h($value) . '/';
		}

		return $this->Html->link($title, $url, $options);
	}

/**
 * Setting display number
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	public function selectDisplayNumber($fieldName, $attributes = array()) {
		if (! isset($attributes['options'])) {
			if (! isset($attributes['unit'])) {
				$attributes['unit']['single'] = __d('net_commons', '%s item');
				$attributes['unit']['multiple'] = __d('net_commons', '%s items');
			} elseif (is_string($attributes['unit'])) {
				$unit = $attributes['unit'];
				$attributes['unit'] = array();
				$attributes['unit']['single'] = $unit;
				$attributes['unit']['multiple'] = $unit;
			}

			$attributes['options'] = array();
			foreach (array(1, 5, 10, 20, 50, 100) as $value) {
				if ($value === 1) {
					$unitLabel = $attributes['unit']['single'];
				} else {
					$unitLabel = $attributes['unit']['multiple'];
				}
				$attributes['options'][$value] = sprintf($unitLabel, $value);
			}

			unset($attributes['unit']);
		}

		$defaultAttributes = array(
			'type' => 'select',
		);
		$attributes = Hash::merge($defaultAttributes, $attributes);

		return $this->input($fieldName, $attributes);
	}

}
