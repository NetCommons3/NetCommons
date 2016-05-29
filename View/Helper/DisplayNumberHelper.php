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
 * listStyle
 *
 * @var array
 */
	public $displayDaysOptions = array(1, 3, 7, 14, 30);

/**
 * 件数セレクトボックスのオプション
 *
 * @param array $attributes HTMLの属性オプション
 * @return array
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
 * 日数セレクトボックスのオプション
 *
 * @param array $attributes HTMLの属性オプション
 * @return array
 */
	private function __getOptionsForDays($attributes = array()) {
		$options = array();
		if (! isset($attributes['options'])) {
			if (! isset($attributes['unit'])) {
				$attributes['unit']['single'] = __d('net_commons', '%s day');
				$attributes['unit']['multiple'] = __d('net_commons', '%s days');
			} elseif (is_string($attributes['unit'])) {
				$unit = $attributes['unit'];
				$attributes['unit'] = array();
				$attributes['unit']['single'] = $unit;
				$attributes['unit']['multiple'] = $unit;
			}

			foreach ($this->displayDaysOptions as $value) {
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
		return $this->_select($fieldName, $attributes);
	}

/**
 * Setting display number
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	public function selectDays($fieldName, $attributes = array()) {
		$attributes['options'] = $this->__getOptionsForDays($attributes);
		return $this->_select($fieldName, $attributes);
	}

/**
 * Setting display number
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $attributes Array of HTML attributes, and special attributes above.
 * @return string Completed radio widget set.
 */
	protected function _select($fieldName, $attributes = array()) {
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
			$named = $this->_View->Paginator->params['named'];
			$named['page'] = '1';
			$attributes['url'] = $named;
		}

		return $this->_View->element('NetCommons.limit_dropdown_toggle', array(
			'displayNumberOptions' => $attributes['options'],
			'currentLimit' => $attributes['currentLimit'],
			'url' => $attributes['url'],
		));
	}

/**
 * Output display number drop down toggle
 *
 * @param array $attributes Array of options and HTML arguments.
 * @return string HTML tags
 */
	public function dropDownToggleDays($attributes = array()) {
		$attributes['options'] = $this->__getOptionsForDays($attributes);
		if (isset($attributes['unit'])) {
			unset($attributes['unit']);
		}

		$days = Hash::get($this->_View->Paginator->params['named'], 'days', $attributes['currentDays']);

		if (! isset($attributes['url'])) {
			$named = $this->_View->Paginator->params['named'];
			$named['page'] = '1';
			$attributes['url'] = $named;
		}

		return $this->_View->element('NetCommons.limit_dropdown_toggle_days', array(
			'displayNumberOptions' => $attributes['options'],
			'currentDays' => $days,
			'url' => $attributes['url'],
		));
	}

}
