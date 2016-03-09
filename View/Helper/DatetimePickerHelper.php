<?php
/**
 * DatetimePickerHelper
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * DatetimePickerHelper
 * User: ryuji
 * Date: 2016/03/09
 * Time: 16:04
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Class DatetimePickerHelper
 */
class DatetimePickerHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
	);

/**
 * @var array datetimePickerでfromTo制約するフィールドリスト
 */
	protected $_datetimeLink = array();

/**
 * @var array FromTo制約を付加するfromフィールド名のサフィックス
 * ex) publish_start
 */
	protected $_fromFieldSuffix = [
		'start',
		'from',
	];

/**
 * @var array FromTo制約を付加するtoフィールド名のサフィックス
 * ex) publish_end
 */
	protected $_toFieldSuffix = [
		'end',
		'to',
	];

/**
 * datetimepickerを使うフィールドをFromTo制約候補に追加する
 *
 * @param string $fieldName FieldName
 * @param array $options Options
 * @return void
 */
	public function setLinkFieldName($fieldName, $options) {
		if (Hash::get($options, 'datetimepicker')) {
			if (preg_match('/^(.*)_(' . implode('|', $this->_fromFieldSuffix) . ')$/', $fieldName, $matches)) {
				$this->_datetimeLink[$matches[1]]['from'] = $fieldName;
			}
			if (preg_match('/^(.*)_(' . implode('|', $this->_toFieldSuffix) . ')$/', $fieldName, $matches)) {
				$this->_datetimeLink[$matches[1]]['to'] = $fieldName;
			}
		}
	}

/**
 * datetimePickerFromToLink()をコールするscriptBlock出力
 *
 * @return string
 */
	public function render() {
		$out = '';
		if ($this->_datetimeLink) {
			$script = '$(function () {';
			foreach ($this->_datetimeLink as $fromTo) {
				if (isset($fromTo['from']) && isset($fromTo['to'])) {
					// from to のペア有り
					$fromId = $this->Form->domId($fromTo['from']);
					$toId = $this->Form->domId($fromTo['to']);

					$script .= "datetimePickerFromToLink('{$fromId}', '{$toId}');\n";
				}
			}
			$script .= '});';
			$this->Html->scriptBlock($script, ['inline' => false]);
			$this->renderScript();
		}
		return $out;
	}

/**
 * FromTo制約をDatetimePickerに設定する関数をscriptBlockへ
 *
 * @return void
 */
	public function renderScript() {
		static $executed = false;
		if ($executed === false) {
			$functionScript = "function datetimePickerFromToLink(fromId, toId){
				$('#' + fromId).on('dp.change', function (e) {
					$('#' + toId).data('DateTimePicker').minDate(e.date);
				});
				$('#' + toId).on('dp.change', function (e) {
					$('#' + fromId).data('DateTimePicker').maxDate(e.date);
				});
			}";
			$this->Html->scriptBlock($functionScript, ['inline' => false]);
			$executed = true;
		}
	}
}