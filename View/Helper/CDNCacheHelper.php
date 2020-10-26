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
		$nonCacheable = (isset($this->_View->response->header()['Pragma']) &&
				$this->_View->response->header()['Pragma'] === 'no-cache') ||
				(strncmp('origin-', $_SERVER['HTTP_HOST'], 7) !== 0 &&
				strncmp('origin.', $_SERVER['HTTP_HOST'], 7) !== 0);
		return !$nonCacheable;
	}
}
