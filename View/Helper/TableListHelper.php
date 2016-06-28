<?php
/**
 * テーブルリスト用Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * テーブルリスト用Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class TableListHelper extends AppHelper {

/**
 * 使用するHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Button',
		'NetCommons.Date',
		'NetCommons.LinkButton',
		'NetCommons.MessageFlash',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
		'Users.DisplayUser',
	);

/**
 * 各プラグインのHelperラップ用マジックメソッド
 *
 * 指定されたメソッドにより、各プラグインのHelperのメソッドを呼び出します。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if ($method === 'addLink') {
			$helper = $this->Button;

			$html = '<div class="text-right nc-table-add">';
			$html .= call_user_func_array(array($helper, $method), $params);
			$html .= '</div>';
		} else {
			$helper = $this->NetCommonsForm;
			$html = call_user_func_array(array($helper, $method), $params);
		}

		return $html;
	}

/**
 * `<table>`を表示する
 *
 * @param string $tableType テーブル種別 `table-hover`,`table-striped`,`table-bordered`,`table-condensed`
 * @return string HTML
 * @see http://getbootstrap.com/css/#tables
 */
	public function startTable($tableType = 'table-hover') {
		$html = '';

		if ($tableType) {
			$tableType = ' ' . $tableType;
		}

		$html .= '<div class="table-responsive">';
		$html .= '<table class="table' . $tableType . '">';
		return $html;
	}

/**
 * `</table>`を表示する
 *
 * @return string HTML
 */
	public function endTable() {
		$html = '';
		$html .= '</table>';
		$html .= '</div>';
		return $html;
	}

/**
 * `<tr>`を表示する
 *
 * @param int $currentId カレントのID
 * @param string $fieldName フィールド名(Model.field)
 * @return string HTML
 */
	public function startTableRow($currentId = null, $fieldName = null) {
		if (isset($fieldName) &&
				Hash::get($this->_View->request->data, $fieldName, false) === $currentId) {
			$active = ' class="active"';
		} else {
			$active = '';
		}

		$html = '<tr' . $active . '>';
		return $html;
	}

/**
 * `</tr>`を表示する
 *
 * @return string HTML
 */
	public function endTableRow() {
		$html = '</tr>';
		return $html;
	}

/**
 * `<th>...</th>`を表示する
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param string $title タイトル
 * @param array $options オプション
 * - type
 *   - false
 *   - text
 *   - datetime
 *   - numeric
 *   - center
 *   - right
 *   - link
 *   - handle
 * - sort<br>
 * ソートを表示するかどうか
 * @return string HTML
 */
	public function tableHeader($fieldName, $title = '', $options = array()) {
		$type = Hash::get($options, 'type', 'text');

		if (in_array($type, ['text', 'datetime', 'numeric', 'center', 'right', 'link', 'handle'])) {
			$start = '<th class="nc-table-' . $type . '">';
		} else {
			$start = '<th>';
		}

		if (Hash::get($options, 'sort', false)) {
			$title = $this->_View->Paginator->sort($fieldName, $title);
		}

		$end = '</th>';

		$output = $start . $title . $end;

		if (Hash::get($options, 'editUrl', false)) {
			$output .= '<th></th>';
		}

		return $output;
	}

/**
 * `<td>...</td>`を表示する
 *
 * @param string $fieldName フィールド名(Model.field)<br>
 * ただし、$option['handle']の場合は、Model名(TrackableCreatorなど)をセットする
 * @param string|array $value 値
 * @param array $options オプション
 * - type
 *   - false
 *   - text
 *   - datetime
 *   - numeric
 *   - center
 *   - right
 *   - link リンクを付ける
 *   - handle ハンドルを表示する
 * - escape
 * - editUrl<br>
 * 編集ボタンを付与させる
 * - format（数値の場合のみ有効）<br>
 * 出力のフォーマット。詳しくは、[__dn()](http://book.cakephp.org/2.0/ja/core-libraries/global-constants-and-functions.html#__dn)
 *   - domain
 *   - singular
 *   - plural
 * @return string HTML
 */
	public function tableData($fieldName, $value = '', $options = array()) {
		$type = Hash::get($options, 'type', 'text');

		if ($type === 'datetime') {
			$start = '<td class="nc-table-' . $type . '">';
			$value = $this->Date->dateFormat($value);

		} elseif ($type === 'link') {
			$start = '<td class="nc-table-' . $type . '">';
			$value = $this->NetCommonsHtml->link(
				$value, $value, array('target' => '_blank')
			);
			$options = Hash::insert($options, 'escape', false);

		} elseif ($type === 'handle') {
			$start = '<td class="nc-table-' . $type . '">';
			$value = $this->DisplayUser->handleLink($value, ['avatar' => true], [], $fieldName);
			$options = Hash::insert($options, 'escape', false);

		} elseif (in_array($type, ['text', 'numeric', 'center', 'right'])) {
			$start = '<td class="nc-table-' . $type . '">';

		} else {
			$start = '<td>';
		}

		if (Hash::get($options, 'format')) {
			$value = sprintf(
				__dn(
					Hash::get($options, 'format.domain', 'net_commons'),
					Hash::get($options, 'format.singular', '%d'),
					Hash::get($options, 'format.plural', '%d'),
					(int)$value
				),
				(int)$value
			);
		}

		if (Hash::get($options, 'escape', true)) {
			$value = h($value);
		}

		$end = '</td>';

		$output = $start . $value . $end;

		if (Hash::get($options, 'editUrl', false)) {
			$output .= '<td>';
			$output .= $this->LinkButton->edit(
				'', Hash::get($options, 'editUrl', []), ['iconSize' => ' btn-xs']
			);
			$output .= '</td>';
		}

		return $output;
	}

}
