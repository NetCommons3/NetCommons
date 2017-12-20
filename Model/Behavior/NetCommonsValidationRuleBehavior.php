<?php
/**
 * 共通Validation Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * 共通Validation Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package  NetCommons\NetCommons\Model\Befavior
 */
class NetCommonsValidationRuleBehavior extends ModelBehavior {

/**
 * 半角英数字および記号のバリデーション
 *
 * @param Model $model 呼び出し元モデル
 * @param array $check チェック値
 * @param string|false $errorPattern エラーパタン文字列。falseの場合、処理しない
 * @return bool
 */
	public function alphaNumericSymbols(Model $model, $check, $errorPattern) {
		$value = array_shift($check);

		if ($errorPattern && preg_match('/[' . preg_quote($errorPattern, '/') . ']/', $value)) {
			return false;
		}

		//許可する記号
		//(NC2)
		//「_」「-」「<」「>」「,」「.」「$」「%」「#」「@」「!」「\」「'」「"」
		//
		//(NC3で追加)
		//「+」「&」「?」「=」「~」「:」「;」「|」「]」「[」「(」「)」「*」「^」「{」「}」「/」
		$pattern = 'a-zA-Z0-9' .
					preg_quote('_-<>,.$%#@!\\\'"', '/') .
					preg_quote('+&?=~:;|][()*^{}/', '/');

		return !(bool)preg_match('/[^' . $pattern . ']/', $value);
	}

/**
 * notBlankをNC3用にカスタマイズ
 *
 * @param Model $model 呼び出し元モデル
 * @param array $check チェック値
 * @return bool
 */
	public function notBlank(Model $model, $check) {
		$value = array_shift($check);
		$value = preg_replace('/((' . preg_quote('&nbsp;', '/') . ')+)/', ' ', $value);

		if (empty($value) && !is_bool($value) && !is_numeric($value)) {
			return false;
		}

		$regex = '/[^\s　' . preg_quote('$`', '/') . ']+/m';
		if (is_string($regex) && is_scalar($value) && preg_match($regex, $value)) {
			return true;
		}

		return false;
	}

/**
 * 複数チェックボックス等の配列項目に対するinListバリデーション
 *
 * @param Model $model 呼び出し元モデル
 * @param array $check チェック値
 * @param array $list 確認するリスト
 * @param bool $caseInsensitive 大文字小文字を区別しない比較の場合はtrueに設定する
 * @return bool
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function inListForArrayItems(Model $model, $check, $list, $caseInsensitive = false) {
		$values = current($check);

		if (! is_array($values)) {
			$values = [$values];
		}

		if ($caseInsensitive) {
			$list = array_map('mb_strtolower', $list);
			$values = array_map('mb_strtolower', $values);
		} else {
			$list = array_map('strval', $list);
		}

		foreach ($values as $value) {
			if (! in_array((string)$value, $list, true)) {
				return false;
			}
		}

		return true;
	}

}
