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
	public $helpers = array('Form', 'Html');

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
	public function deleteButton($title, $confirm, $options = array()) {
		$output = '';

		$title = '<span class="glyphicon glyphicon-trash"> </span> ' . $title;

		$defaultOptions = array(
			'name' => 'delete',
			'class' => 'btn btn-danger pull-right',
			'onclick' => 'return confirm(\'' . $confirm . '\')',
			'ng-click' => 'sending=true',
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
 * - `confirm` - Add javascript confirm in onclick attribute
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function saveButton($title, $options = array()) {
		$output = '';

		$defaultOptions = array(
			'name' => 'save',
			'class' => 'btn btn-primary btn-workflow',
			'ng-click' => 'sending=true',
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
	public function cancelButton($title, $url, $options = array()) {
		$output = '';

		$title = '<span class="glyphicon glyphicon-remove"></span> ' . $title;

		$defaultOptions = array(
			'name' => 'cancel',
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

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

}
