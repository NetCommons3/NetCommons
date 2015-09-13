<?php
/**
 * NetCommons Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * NetCommons Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsUrl {

/**
 * Back to page url
 *
 * @param bool $settingMode Setting mode
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function backToPageUrl($settingMode = false, $full = false) {
		$url = '/';
		if (! Current::isControlPanel()) {
			if ($settingMode) {
				$url .= Current::SETTING_MODE_WORD . '/';
			}

			if (Current::read('Page.permalink')) {
				$url .= Current::read('Page.permalink') . '/';
			}
		}
		return h(Router::url($url, $full));
	}

/**
 * Back to default action url
 *
 * @param string $defaultField Plugin table's default action field. The value is "default_action" or "default_setting_action"
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function backToIndexUrl($defaultField = 'default_action', $full = false) {
		$url = '/' . Current::read('Plugin.key') . '/' . Current::read('Plugin.' . $defaultField);
		if (Current::read('Plugin.' . $defaultField) && ! Current::isControlPanel()) {
			if (Current::read('Frame.id')) {
				$url .= '/' . Current::read('Frame.id');
			}
		}
		return h(Router::url($url, $full));
	}

/**
 * Back to default action url
 *
 * @param array $params Action url array
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function actionUrl($params = array(), $full = false) {
		$url = array();
		if (! isset($params['plugin'])) {
			$url['plugin'] = Current::read('Plugin.key');
		} else {
			$url['plugin'] = $params['plugin'];
		}
		$url['controller'] = $params['controller'];
		$url['action'] = $params['action'];

		if (isset($params['frame_id'])) {
			$url[] = $params['frame_id'];
			unset($params['frame_id']);
		}
		if (isset($params['block_id'])) {
			$url[] = $params['block_id'];
			unset($params['block_id']);
		}
		if (isset($params['key'])) {
			$url[] = $params['key'];
			unset($params['key']);
		}
		if (isset($params['origin_id'])) {
			$url[] = $params['origin_id'];
			unset($params['origin_id']);
		}

		$url = Hash::merge($url, $params);

		return h(Router::url($url, $full));
	}

}
