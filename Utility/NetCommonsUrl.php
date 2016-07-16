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

App::uses('Current', 'NetCommons.Utility');
App::uses('Page', 'Pages.Model');

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
		$page['Page'] = Current::read('Page');

		$url = '/';
		if (! Current::isControlPanel()) {
			if ($settingMode) {
				$url .= Current::SETTING_MODE_WORD . '/';
			}

			if (Hash::get($page, 'Page.parent_id') === Page::PUBLIC_ROOT_PAGE_ID &&
					Hash::get($page, 'Page.id') === Current::read('Room.page_id_top')) {
				$url .= '';
			} else {
				$url .= h(Hash::get($page, 'Page.permalink'));
			}
		}
		return self::url($url, $full);
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
		return self::url($url, $full);
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
		if (is_array($params)) {
			$url = self::actionUrlAsArray($params, $full);
		} else {
			$url = $params;
		}
		return self::url($url, $full);
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
		if (isset($params['controller'])) {
			$url['controller'] = $params['controller'];
			unset($params['controller']);
		}
		if (isset($params['action'])) {
			$url['action'] = $params['action'];
			unset($params['action']);
		}

		if (isset($params['block_id'])) {
			$url[] = $params['block_id'];
			unset($params['block_id']);
		}
		if (isset($params['key'])) {
			$url[] = $params['key'];
			unset($params['key']);
		}
		if (isset($params['key2'])) {
			$url[] = $params['key2'];
			unset($params['key2']);
		}

		if (isset($params['frame_id'])) {
			$query['?']['frame_id'] = $params['frame_id'];
			unset($params['frame_id']);
		}
		return Hash::merge($url, $query, $params);
	}

/**
 * ユーザのアクションURLを生成
 *
 * @param array $params Action url array
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function userActionUrl($params = array(), $full = false) {
		$params = Hash::merge(array(
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'view',
			'key' => Current::read('User.id')
		), $params);

		//if (! Current::isControlPanel()) {
		//	if (Current::read('Frame.id')) {
		//		$params['frame_id'] = Current::read('Frame.id');
		//	} else {
		//		$params['?']['page_id'] = Current::read('Page.id');
		//	}
		//}

		$url = self::actionUrlAsArray($params, $full);
		return self::url($url, $full);
	}

/**
 * URLを生成
 *
 * @param array $params Action url array
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function url($params = array(), $full = false) {
		$url = Router::url($params, $full);
		if (is_array($params) && Current::isSettingMode()) {
			$url = preg_replace('/\/' . Current::SETTING_MODE_WORD . '/', '', $url);
		}

		$request = Router::getRequest(true);
		$base = '';
		if ($request) {
			$base = $request->base;
		}
		if (! $full) {
			return preg_replace('/&amp;/', '&', h(substr($url, strlen($base))));
		} else {
			return $url;
		}
	}

/**
 * BlockのURLを生成
 *
 * @param array $url An array specifying any of the following: 'controller', 'action',
 *   and/or 'plugin', in addition to named arguments (keyed array elements),
 *   and standard URL arguments (indexed array elements).
 *   'autoSetting': Current::SETTING_MODE_WORDを付ける処理を自動で行う。デフォルトfalse
 * @return array block url
 */
	public static function blockUrl($url = array()) {
		if (!is_array($url)) {
			return $url;
		}

		$autoSetting = Hash::get($url, ['autoSetting']);
		if ($autoSetting && Current::isSettingMode()) {
			array_unshift($url, Current::SETTING_MODE_WORD);
		}
		unset($url['autoSetting']);

		$blockId = Current::read('Block.id');
		if (!isset($url['block_id']) && $blockId) {
			$url['block_id'] = $blockId;
		}

		if (Hash::get($url, ['?', 'frame_id'])) {
			return $url;
		}
		if (isset($url['frame_id'])) {
			$url['?']['frame_id'] = $url['frame_id'];
			unset($url['frame_id']);
			return $url;
		}

		$frameId = Current::read('Frame.id');
		if ($frameId) {
			$url['?']['frame_id'] = $frameId;
		}

		return $url;
	}
}
