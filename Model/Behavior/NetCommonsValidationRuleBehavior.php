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
 * @param array|null $options allowSymbolsとerrorSymbolsが指定できます。
 *								allowSymbolsは、許可する記号(指定しなかった記号をエラーにする)、
 *								errorSymbolsは、エラーとする記号を設定できます。
 * @return bool
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function alphaNumericSymbols(Model $model, $check, $options = []) {
		$value = array_shift($check);

		if (is_string($options)) {
			$options = [
				'errorSymbols' => $options
			];
		} elseif (! is_array($options) || isset($options['rule'])) {
			$options = [];
		}

		//許可する記号
		//(NC2)
		//「_」「-」「<」「>」「,」「.」「$」「%」「#」「@」「!」「\」「'」「"」
		//
		//(NC3で追加)
		//「+」「&」「?」「=」「~」「:」「;」「|」「]」「[」「(」「)」「*」「^」「{」「}」「/」
		$pattern = 'a-zA-Z0-9';
		if (isset($options['allowSymbols'])) {
			$pattern .= preg_quote($options['allowSymbols'], '/');
		} else {
			if (isset($options['errorSymbols'])) {
				if (strlen($options['errorSymbols']) > 1 &&
						in_array(substr($options['errorSymbols'], 0, 1), ['/', '#'], true) &&
						in_array(substr($options['errorSymbols'], -1), ['/', '#'], true)) {
					$symbolsPerttern = $options['errorSymbols'];
				} else {
					$symbolsPerttern = '/[' . preg_quote($options['errorSymbols'], '/') . ']/';
				}

				if (preg_match($symbolsPerttern, $value)) {
					return false;
				}
			}
			$pattern .= preg_quote('_-<>,.$%#@!\\\'"+&?=~:;|][()*^{}/', '/');
		}

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
		if (is_string($value)) {
			$value = preg_replace('/((' . preg_quote('&nbsp;', '/') . ')+)/', ' ', $value);
		}

		if (empty($value) && !is_bool($value) && !is_numeric($value)) {
			return false;
		}

		$regex = '/[^\s　' . preg_quote('$`', '/') . ']+/m';
		if (is_string($value) && is_scalar($value) && preg_match($regex, $value)) {
			return true;
		}

		return false;
	}

}
