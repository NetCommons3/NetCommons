<?php
/**
 * ValidateMerge.php
 *
 * @author Japan Science and Technology Agency
 * @author National Institute of Informatics
 * @link http://researchmap.jp researchmap Project
 * @link http://www.netcommons.org NetCommons Project
 * @license http://researchmap.jp/public/terms-of-service/ researchmap license
 * @copyright Copyright 2017, researchmap Project
 */

class ValidateMerge {
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