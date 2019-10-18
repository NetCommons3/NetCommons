<?php
/**
 * Angularに対するパーサ処理
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Angularに対するパーサ処理
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Lib
 */
class AngularParser {

/**
 * Angularで使用できない文字のパーサ処理
 *
 * @param array &$values 変換する値
 * @return bool
 */
	public static function parse(&$values) {
		if (is_array($values)) {
			$cleansingRequest = function (&$value) {
				if (is_string($value)) {
					$value = self::convertText($value);
				}
			};
			return array_walk_recursive($values, $cleansingRequest);
		} else {
			return false;
		}
	}

/**
 * テキスト文字を変換する
 *
 * @param string $value 変換する値
 * @return string 変換後の値
 */
	public static function convertText($value) {
		return str_replace(['{{', '}}', "\0"], ['{ { ', ' } }', ''], $value);
	}

}
