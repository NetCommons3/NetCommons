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
	public $helpers = array('Form');

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
	public function deleteButton($title, $confirm, $options = array()) {
		$output = '';

		$title = '<span class="glyphicon glyphicon-trash"> </span> ' . $title;

		$defaultOptions = array(
			'name' => 'delete',
			'class' => 'btn btn-danger pull-right',
			'onclick' => 'return confirm(\'' . $confirm . '\')'
		);
		$inputOptions = Hash::merge($defaultOptions, $options);

		$output .= $this->Form->button($title, $inputOptions);
		return $output;
	}

}
