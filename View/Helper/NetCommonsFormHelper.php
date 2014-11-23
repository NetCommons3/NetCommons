<?php
/**
 * NetCommons Form Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');
App::uses('Xml', 'Utility');

/**
 * NetCommons Form Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\View\Helper
 */
class NetCommonsFormHelper extends FormHelper {

/**
 * tokenHTML
 *
 * @var string
 */
	private $__tokenHTML = null;

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
 * @return string An formatted opening FORM tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-create
 */
	public function create($model = null, $options = array()) {
		$default = array(
			'default' => false,
			'inputDefaults' => array('label' => false, 'div' => false),
		);
		$options = Hash::merge($default, $options);
		$this->__tokenHTML = parent::create($model, $options);
		return $this->__tokenHTML;
	}

/**
 * Closes an HTML form, cleans up values set by FormHelper::create(), and writes hidden
 * input fields where appropriate.
 *
 * If $options is set a form submit button will be created. Options can be either a string or an array.
 *
 * {{{
 * array usage:
 *
 * array('label' => 'save'); value="save"
 * array('label' => 'save', 'name' => 'Whatever'); value="save" name="Whatever"
 * array('name' => 'Whatever'); value="Submit" name="Whatever"
 * array('label' => 'save', 'name' => 'Whatever', 'div' => 'good') <div class="good"> value="save" name="Whatever"
 * array('label' => 'save', 'name' => 'Whatever', 'div' => array('class' => 'good')); <div class="good"> value="save" name="Whatever"
 * }}}
 *
 * @param string|array $options as a string will use $options as the value of button,
 * @return string a closing FORM tag optional submit button.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#closing-the-form
 */
	public function endJson($options = null) {
		$this->__tokenHTML .= parent::end($options);

		$data = array();
		$xmlData = Xml::toArray(Xml::build($this->__tokenHTML));
		if (isset($xmlData['form']['div'][0]) && isset($xmlData['form']['div'][1])) {

			//data[_Token][key]の取得
			foreach ($xmlData['form']['div'][0]['input'] as $i => $input) {
				$matches = array();
				if (preg_match('/data\[(_Token)\]\[(.+)\]/iU', $input['@name'], $matches)) {
					$data[$matches[1]][$matches[2]] = $input['@value'];
				}
			}
			//data[_Token][fields]、data[_Token][unlocked]の取得
			foreach ($xmlData['form']['div'][1]['input'] as $i => $input) {
				$matches = array();
				if (preg_match('/data\[(_Token)\]\[(.+)\]/iU', $input['@name'], $matches)) {
					$data[$matches[1]][$matches[2]] = $input['@value'];
				}
			}
		}

		return json_encode($data);
	}
}
