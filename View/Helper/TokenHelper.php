<?php
/**
 * TokenHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('FormHelper', 'View/Helper');
App::uses('Xml', 'Utility');

/**
 * TokenHelper
 *
 */
class TokenHelper extends FormHelper {

/**
 * Return _Token array.
 *
 * @param array $tokenFields An array of fields to generate inputs for, or null.
 * @param array $hiddenFields An array of fields that exist in $tokenFields to generate inputs hidden for, or null.
 * @param array $blacklist  A array of fields to not create inputs for.
 * @return array _Token
 */
	public function getToken($tokenFields = null, $hiddenFields = array(), $blacklist = null) {
		if (empty($blacklist)) {
			$blacklist = array();
			$blacklist += array(
				'created',
				'modified',
				'created_user',
				'modified_user'
			);
		}
		$options = array(
			'legend' => false,
			'fieldset' => false
		);

		$fields = $tokenFields;
		if (is_array($tokenFields)) {
			$fields = $this->_getInputsFields($tokenFields, $hiddenFields);
		}

		$formHtml = $this->create();
		$this->inputs($fields, $blacklist, $options);
		$formHtml .= $this->end();

		$tokens = $this->_extractToken($formHtml);

		return $tokens;
	}

/**
 * Return input fields array added hidden option.
 *
 * @param array $tokenFields An array of fields to generate inputs for, or null.
 * @param array $hiddenFields An array of fields that exist in $tokenFields to generate inputs hidden for, or null.
 * @return array input fields
 */
	protected function _getInputsFields($tokenFields, $hiddenFields) {
		$fieldNames = array_keys($tokenFields);
		$fields = array();

		$options = array('type' => 'hidden');
		foreach ($fieldNames as $fieldName) {
			if (in_array($fieldName, $hiddenFields)) {
				$fields[$fieldName] = $options;
				continue;
			}

			$fields[$fieldName] = array();
		}

		return $fields;
	}

/**
 * Return _Token array.
 *
 * @param string $formHtml Token html string
 * @return array _Token
 */
	protected function _extractToken($formHtml) {
		$tokens = array();
		$domDocument = Xml::build($formHtml, array('return' => 'domdocument'));
		$inputs = $domDocument->getElementsByTagName('input');

		foreach ($inputs as $input) {
			$matches = array();
			$name = $input->getAttribute('name');
			if (preg_match('/data\[_Token\]\[(.+)\]/', $name, $matches)) {
				$tokens['_Token'][$matches[1]] = $input->getAttribute('value');
			}
		}

		return $tokens;
	}
}
