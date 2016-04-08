<?php
/**
 * NetCommonsTimeHelper
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');
App::uses('NetCommonsTime', 'NetCommons.Utility');

/**
 * Class NetCommonsTimeHelper
 */
class NetCommonsTimeHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
	);

/**
 * @var NetCommonsTime NetCommonsTimeのインスタンス
 */
	protected $_netCommonsTime = null;

/**
 * @var array タイムゾーン変換対象フィールド
 */
	protected $_convertFields = array();

/**
 * コンストラクタ
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 * @return NetCommonsTimeHelper
 */
	public function __construct(View $View, $settings = array()) {
		$this->_netCommonsTime = new NetCommonsTime();
		parent::__construct($View, $settings);
	}

/**
 * NetCommonsTime ラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->_netCommonsTime, $method), $params);
	}

/**
 * コンバートするFieldsをセットする処理
 * NetCommonsForm::inputから呼ばれる。
 *
 * @param string $fieldName field name
 * @param array $options options
 * @return void
 */
	public function beforeFormInput($fieldName, $options) {
		if (Hash::get($options, 'convert_timezone') === true) {
			if (strpos($fieldName, '.') === false) {
				$fieldName = $this->Form->defaultModel . '.' . $fieldName;
			}
			$this->_convertFields[] = $fieldName;
		}
	}

/**
 * Timezone変換の準備を組み込んだForm::end
 *
 * @return string $out timezone変換用のhiddenタグ
 */
	public function beforeFormEnd() {
		$out = '';

		// modelをみてdatetime
		$out .= $this->Form->hidden('_NetCommonsTime.user_timezone', array('value' => Current::read('User.timezone')));
		$out .= $this->Form->hidden('_NetCommonsTime.convert_fields', array('value' => implode(',', $this->_convertFields)));
		$this->_convertFields = array();

		return $out;
	}

}