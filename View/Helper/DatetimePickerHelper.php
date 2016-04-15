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
 * このHelperはNetCommonsFormから使われる前提で開発されています。Viewから直接使われることは想定していません。
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
 * @var bool スクリプトロード済みでtrue
 */
	protected static $_loadedScript = false;

/**
 * NetCommonsForm::inputから呼ばれる。
 * type=datetimeだったらdatetimipicker有効
 * options = array('datetimepicker')あればdatetimepickerスクリプトロード
 *
 * @param string $fieldName field name
 * @param array $inputOptions options
 * @return array options
 */
	public function beforeFormInput($fieldName, $inputOptions) {
		if (Hash::get($inputOptions, 'type') === 'datetime') {
			$inputOptions = $this->_makeDatetimeOptions($fieldName, $inputOptions);
		}
		if (Hash::get($inputOptions, 'datetimepicker') || in_array('datetimepicker', $inputOptions)) {
			$this->_loadDatetimePicker();
			$this->_setLinkFieldName($fieldName, $inputOptions);
		}
		return $inputOptions;
	}

/**
 * datetimePickerFromToLink()をコールするscriptBlock出力
 *
 * @return void
 */
	public function beforeFormEnd() {
		if ($this->_datetimeLink) {
			$script = '';
			foreach ($this->_datetimeLink as $fromTo) {
				if (isset($fromTo['from']) && isset($fromTo['to'])) {
					// from to のペア有り
					$fromId = $this->Form->domId($fromTo['from']);
					$toId = $this->Form->domId($fromTo['to']);

					$script .= "datetimePickerFromToLink('{$fromId}', '{$toId}');\n";
				}
			}
			if ($script) {
				$scriptBlock = '$(function () {';
				$scriptBlock .= $script;
				$scriptBlock .= '});';
				$this->Html->scriptBlock($scriptBlock, ['inline' => false]);
				$this->_loadJsFile();
			}
		}
	}

/**
 * datetimepickerを使うフィールドをFromTo制約候補に追加する
 *
 * @param string $fieldName FieldName
 * @param array $options Options
 * @return void
 */
	protected function _setLinkFieldName($fieldName, $options) {
		if (preg_match('/^(.*)_(' . implode('|', $this->_fromFieldSuffix) . ')$/', $fieldName, $matches)) {
			$this->_datetimeLink[$matches[1]]['from'] = $fieldName;
		}
		if (preg_match('/^(.*)_(' . implode('|', $this->_toFieldSuffix) . ')$/', $fieldName, $matches)) {
			$this->_datetimeLink[$matches[1]]['to'] = $fieldName;
		}
	}

/**
 * datimepicker用オプション指定
 *
 * @param string $fieldName フィールド名
 * @param array $options オプション
 * @return mixed
 */
	protected function _makeDatetimeOptions($fieldName, $options) {
		//$this->DatetimePicker->usePicker();
		// $filedNameにモデル名が入ってるかは不定
		if (strpos($fieldName, '.') === false) {
			$fieldName = $this->Form->defaultModel . '.' . $fieldName;
		}

		$options['type'] = 'text';
		$options['datetimepicker'] = true;
		$options['convert_timezone'] = true;
		// ng-modelを指定してなくてもdatetimepickerが動くようにする
		if (!isset($options['ng-model'])) {
			$options['ng-model'] = 'NetCommonsFormDatetimePickerModel_' . str_replace('.', '_', $fieldName);
			//'ng-init' => 'hoge=\'2011-01-01\'',
			// value > request->data > default
			$value = '';
			if (isset($options['value'])) {
				$value = $options['value'];
			} elseif (Hash::check($this->request->data, $fieldName)) {
				$value = Hash::get($this->request->data, $fieldName);
			} elseif (isset($options['default'])) {
				$value = $options['default'];
			}
			$netCommonsTime = new NetCommonsTime();

			$value = $netCommonsTime->toUserDatetime($value);
			$options['value'] = $value;
			$options['ng-value'] = $options['ng-model'];

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
 * datetimepickerに必要なJSとCSSを読みこみ
 *
 * @return void
 */
	protected function _loadDatetimePicker() {
		if (self::$_loadedScript === false) {
			$this->_View->element('NetCommons.load_datetimepicker');
			self::$_loadedScript = true;
		}
	}

/**
 * FromTo制約をDatetimePickerに設定する関数をscriptBlockへ
 *
 * @return void
 */
	protected function _loadJsFile() {
		$this->Html->script(
			'/net_commons/js/datetime_picker_from_to_link.js',
			array(
				'plugin' => false,
				'once' => true,
				'inline' => false
			)
			);
	}

}
