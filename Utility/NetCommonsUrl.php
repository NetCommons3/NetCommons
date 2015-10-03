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
 * ページに戻るURLを生成
 *
 * @param bool $settingMode セッティングモード
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
 * デフォルトのアクションに戻るURLを生成
 *
 * @param string $defaultField Plugin table's default action field. The value is "default_action" or "default_setting_action"
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function backToIndexUrl($defaultField = 'default_action', $full = false) {
		$url = '/' . Current::read('Plugin.key') . '/' . Current::read('Plugin.' . $defaultField);
		if (Current::read('Plugin.' . $defaultField) && ! Current::isControlPanel()) {
			if (Current::read('Block.id')) {
				$url .= '/' . Current::read('Block.id');
			}
			if (Current::read('Frame.id')) {
				$url .= '?frame_id=' . Current::read('Frame.id');
			}
		}
		return h(Router::url($url, $full));
	}

/**
 * NetCommonsプラグインのアクションURLを生成
 *
 * @param array $params Action url array
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function actionUrl($params = array(), $full = false) {
		$url = self::actionUrlAsArray($params, $full);
		return h(Router::url($url, $full));
	}

/**
 * NetCommonsプラグインのアクションURL配列を生成
 *
 * @param array $params Action url array
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return array Full translated URL with base path as array.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function actionUrlAsArray($params = array(), $full = false) {
		$url = array();
		$query['?'] = null;
		if (! isset($params['plugin'])) {
			$url['plugin'] = Current::read('Plugin.key');
		} else {
			$url['plugin'] = $params['plugin'];
		}
		if (! isset($params['controller'])) {
			$url['controller'] = $params['controller'];
		}
		if (! isset($params['action'])) {
			$url['action'] = $params['action'];
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

		if (isset($params['frame_id'])) {
			$query['?']['frame_id'] = $params['frame_id'];
			unset($params['frame_id']);
		}
		return Hash::merge($url, $params, $query);
	}

}
