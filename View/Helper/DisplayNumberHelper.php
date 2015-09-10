<?php
/**
 * DisplayNumber Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * DisplayNumber Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class DisplayNumberHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.Button',
		'NetCommons.NetCommonsForm'
	);

/**
 * listStyle
 *
 * @var array
 */
	public $displayNumberOptions = array(1, 5, 10, 20, 50, 100);

/**
 * Get display number options
 *
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	private function __getOptions($attributes = array()) {
		$options = array();
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

			foreach ($this->displayNumberOptions as $value) {
				if ($value === 1) {
					$unitLabel = $attributes['unit']['single'];
				} else {
					$unitLabel = $attributes['unit']['multiple'];
				}
				$options[$value] = sprintf($unitLabel, $value);
			}
		} else {
			$options = $attributes['options'];
		}

		return $options;
	}

/**
 * Setting display number
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	public function select($fieldName, $attributes = array()) {
		$attributes['options'] = $this->__getOptions($attributes);
		if (isset($attributes['unit'])) {
			unset($attributes['unit']);
		}

		$defaultAttributes = array(
			'type' => 'select',
		);
		$attributes = Hash::merge($defaultAttributes, $attributes);

		return $this->NetCommonsForm->input($fieldName, $attributes);
	}

/**
 * Output display number drop down toggle
 *
 * @param array $attributes Array of options and HTML arguments.
 * @return string HTML tags
 */
	public function dropDownToggle($attributes = array()) {
		$attributes['options'] = $this->__getOptions($attributes);
		if (isset($attributes['unit'])) {
			unset($attributes['unit']);
		}

		if (! isset($attributes['currentLimit'])) {
			$attributes['currentLimit'] = $this->_View->Paginator->param('limit');
		}

		if (! isset($attributes['url'])) {
			$attributes['url'] = Hash::merge(array(
				'plugin' => $this->_View->params['plugin'],
				'controller' => $this->_View->params['controller'],
				'action' => $this->_View->params['controller']
			), $this->_View->params->pass);
		}

		$named = $this->_View->Paginator->params['named'];
		$named['page'] = '1';
		$attributes['url'] = Hash::merge((array)$attributes['url'], $named);

		return $this->_View->element('NetCommons.limit_dropdown_toggle', array(
			'displayNumberOptions' => $attributes['options'],
			'currentLimit' => $attributes['currentLimit'],
			'url' => $attributes['url'],
		));
	}

}
