<?php
/**
 * CDNCache Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kazunori Sakamoto <exkazuu@willbooster.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2020, NetCommons Project
 */

/**
 * CDNCache Helper
 *
 */
class CDNCacheHelper extends AppHelper {

/**
 * Return a boolean value whether the page is cacheable or not.
 *
 * @return bool a boolean value whether the page is cacheable or not.
 */
	public function isCacheable() {
		$nonCacheable = $this->_View->response->header()['Pragma'] === 'no-cache' ||
				strncmp('origin-', $_SERVER['SERVER_NAME'], 7) !== 0;
		return ! $nonCacheable;
	}
}
