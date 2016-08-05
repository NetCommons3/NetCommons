<?php
/**
 * NetCommons用に拡張したページネーション Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PaginatorHelper', 'View/Helper');
App::uses('NetCommonsUrl', 'NetCommons.Utility');

/**
 * NetCommons用に拡張したページネーション Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\View\Helper
 */
class AppPaginatorHelper extends PaginatorHelper {

/**
 * Converts the keys being used into the format set by options.paramType
 *
 * @param array $url Array of URL params to convert
 * @param string $type Keys type.
 * @return array converted URL params.
 */
	protected function _convertUrlKeys($url, $type) {
		$url = parent::_convertUrlKeys($url, $type);
		if (array_key_exists('block_id', $this->request->params)) {
			$url['block_id'] = $this->request->params['block_id'];
		}
		if (array_key_exists('key', $this->request->params)) {
			$url['key'] = $this->request->params['key'];
		}

		if (array_key_exists('block_id', $this->request->params)) {
			$url = NetCommonsUrl::blockUrl($url);
		} else {
			$url = NetCommonsUrl::actionUrlAsArray($url);
		}

		return $url;
	}

}
