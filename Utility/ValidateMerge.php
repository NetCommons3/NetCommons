<?php
/**
 * バリデートルール結合用クラス
 *
 * モデルやビヘイビアで $this->validate = Hash::merge($this->validate, [バリデートルール...]); で
 * beforeValidate()がよばれるたびに配列要素が増え続ける問題に対処するために作成
 *
 * 【注意】
 * このクラスを使う前にバリデートルールをbeforeValidateでマージする必用があるかを検討しなおすこと。
 *
 * @see https://github.com/NetCommons3/NetCommons3/issues/1486#issuecomment-490684660
 *
 * @author Japan Science and Technology Agency
 * @author National Institute of Informatics
 * @link http://researchmap.jp researchmap Project
 * @link http://www.netcommons.org NetCommons Project
 * @license http://researchmap.jp/public/terms-of-service/ researchmap license
 * @copyright Copyright 2017, researchmap Project
 */

/**
 * Class ValidateMerge
 */
class ValidateMerge {

/**
 * merge
 *
 * このメソッドは使わないで済むならつかない方がよいです（ファイルコメント参照）
 *
 * @param array $data マージ元配列
 * @param array $merge マージする配列
 * @return mixed
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public static function merge($data, $merge) {
		$args = array_slice(func_get_args(), 1);
		$return = $data;
		$stack = [];

		foreach ($args as &$curArg) {
			$stack[] = [(array)$curArg, &$return];
		}
		unset($curArg);

		while (!empty($stack)) {
			foreach ($stack as $curKey => &$curMerge) {
				foreach ($curMerge[0] as $key => &$val) {
					if (!empty($curMerge[1][$key])) {
						if ((array)$curMerge[1][$key] === $curMerge[1][$key] &&
							(array)$val === $val) {
							$stack[] = array(&$val, &$curMerge[1][$key]);
						} elseif ((int)$key === $key) {
							// 配列数値添え字のときは同じ「値」がなければ追加する
							if (in_array($val, $curMerge[1], true) === false) {
								$curMerge[1][] = $val;
							}
						} else {
							$curMerge[1][$key] = $val;
						}
					} else {
						$curMerge[1][$key] = $val;
					}
				}
				unset($stack[$curKey]);
			}
			unset($curMerge);
		}
		return $return;
	}

}