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
 * @return bool
 */
	public function alphaNumericSymbols(Model $model, $check) {
		$value = array_shift($check);

		//許可する記号
		//(NC2)
		//「_」「-」「<」「>」「,」「.」「$」「%」「#」「@」「!」「\」「'」「"」
		//
		//(NC3で追加)
		//「+」「&」「?」「=」「~」「:」「;」「|」「]」「[」「!」「(」「)」「*」「^」「{」「}」「/」
		$pattern = 'a-zA-Z0-9' .
					preg_quote('_-<>,.$%#@!\\\'"', '/') .
					preg_quote('+&?=~:;|][!()*^{}/', '/');

		return (bool)preg_match('/[^' . $pattern . ']', $value);
	}

}
