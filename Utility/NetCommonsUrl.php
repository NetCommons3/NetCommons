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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class NetCommonsUrl {

/**
 * ページに戻るURLを生成
 *
 * @param bool $settingMode セッティングモード
 * @param array $options URLオプション
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function backToPageUrl($settingMode = false, $options = [], $full = false) {
		$page['Page'] = Current::read('Page');

		$url = '/';
		if (! Current::isControlPanel()) {
			if ($settingMode || $settingMode === null && Current::isSettingMode()) {
				$url .= Current::SETTING_MODE_WORD . '/';
			}

			if (Hash::get($page, 'Page.full_permalink')) {
				$url .= h(Hash::get($page, 'Page.full_permalink'));
			} else {
				if (Hash::get($page, 'Page.id') === Current::read('TopPage.id')) {
					$url .= '';
				} else {
					if (Current::read('Space.permalink')) {
						$url .= Current::read('Space.permalink') . '/';
					}
					$url .= h(Hash::get($page, 'Page.permalink'));
				}
			}
		}

		if (isset($options['frame_id'])) {
			$url .= '?frame_id=' . $options['frame_id'];
		}

		return $url;
	}

/**
 * デフォルトのアクションに戻るURLを生成
 *
 * @param string $defaultField Plugin table's default action field. The value is "default_action" or "default_setting_action"
 * @param bool|array $full If (bool) true, the full base URL will be prepended to the result.
 * @return string Full translated URL with base path.
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public static function backToIndexUrl($defaultField = 'default_action', $full = false) {
		if (Current::read('Frame.' . $defaultField)) {
			$defaultAction = Current::read('Frame.' . $defaultField);
			$url = $defaultAction;
		} else {
			$defaultAction = Current::read('Plugin.' . $defaultField);
			if (substr($defaultAction, 0, 1) === '/') {
				$url = $defaultAction;
			} else {
				$url = '/' . Current::read('Plugin.key') . '/' . $defaultAction;
			}
		}

		if ($defaultAction && ! Current::isControlPanel()) {
			//if (Current::read('Block.id')) {
			//	$url .= '/' . Current::read('Block.id');
			//}

			$urlQuery = '';
			if (Current::read('Frame.id')) {
				$urlQuery .= '&frame_id=' . Current::read('Frame.id');
			}
			if (Current::read('Page.id') && ! Current::read('Box.page_id')) {
				$urlQuery .= '&page_id=' . Current::read('Page.id');
			}

			if ($urlQuery) {
				$url = $url . '?' . substr($urlQuery, 1);
			}
		}
		return $url;
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
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	public static function actionUrlAsArray($params = array(), $full = false) {
		if (!is_array($params)) {
			return $params;
		}

		$url = self::__getCommonAction($params);
		$query['?'] = null;

		if (isset($params['block_id'])) {
			$url[] = $params['block_id'];
		}
		if (isset($params['key'])) {
			$url[] = $params['key'];
		}
		if (isset($params['key2'])) {
			$url[] = $params['key2'];
		}

		if (isset($params['frame_id'])) {
			$query['?']['frame_id'] = $params['frame_id'];
			if (Current::read('Page.id') && ! Current::read('Box.page_id')) {
				//デフォルト、Current::readの値を使用
				$url['?']['page_id'] = Current::read('Page.id');
			}
		}

		if (isset($params['page_id'])) {
			$query['?']['page_id'] = $params['page_id'];
		}

		$unsetParams = [
			'plugin', 'controller', 'action',
			'block_id', 'key', 'key2',
			'frame_id', 'page_id'
		];
		foreach ($unsetParams as $key) {
			if (array_key_exists($key, $params)) {
				unset($params[$key]);
			}
		}

		return Hash::merge($url, $query, $params);
	}

/**
 * NetCommonsプラグインのアクションURL配列を生成
 *
 * @param array $params Action url array
 * @return array
 */
	private static function __getCommonAction($params) {
		$request = Router::getRequest(true);

		$url = array();
		if (isset($params['plugin'])) {
			$url['plugin'] = $params['plugin'];
		} elseif (is_object($request)) {
			$url['plugin'] = $request->params['plugin'];
		} elseif (Current::read('Plugin.key')) {
			$url['plugin'] = Current::read('Plugin.key');
		}
		if (isset($params['controller'])) {
			$url['controller'] = $params['controller'];
		} elseif (is_object($request)) {
			$url['controller'] = $request->params['controller'];
		}
		if (isset($params['action'])) {
			$url['action'] = $params['action'];
		} elseif (is_object($request)) {
			$url['action'] = $request->params['action'];
		}

		return $url;
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
		if ($full) {
			return Router::url($params, $full);
		}
		$url = Router::url($params, $full);
		if (is_array($params) && Current::isSettingMode()) {
			$url = preg_replace('/\/' . Current::SETTING_MODE_WORD . '/', '', $url);
		}
		$url = preg_replace('/^' . preg_quote(substr(Router::url('/'), 0, -1), '/') . '/', '', $url);
		return $url;
	}

/**
 * BlockのURLを生成
 *
 * @param array $url An array specifying any of the following: 'controller', 'action',
 *   and/or 'plugin', in addition to named arguments (keyed array elements),
 *   and standard URL arguments (indexed array elements).
 *   'autoSetting': Current::SETTING_MODE_WORDを付ける処理を自動で行う。デフォルトfalse
 * @param bool $isArray 配列で戻すかどうか
 * @return array|string block url
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	public static function blockUrl($url = array(), $isArray = true) {
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

		if (isset($url['frame_id'])) {
			//$url['frame_id']がある場合、パラメータとするように設定
			$url['?']['frame_id'] = $url['frame_id'];
			unset($url['frame_id']);
		} elseif (Current::read('Frame.id')) {
			//デフォルト、Current::readの値を使用
			$url['?']['frame_id'] = Current::read('Frame.id');
		}

		if (isset($url['page_id'])) {
			//$url['page_id']がある場合、パラメータとするように設定
			$url['?']['page_id'] = $url['page_id'];
			unset($url['page_id']);
		} elseif (Current::read('Page.id') && ! Current::read('Box.page_id')) {
			//デフォルト、Current::readの値を使用
			$url['?']['page_id'] = Current::read('Page.id');
		}

		if ($isArray) {
			return self::actionUrlAsArray($url);
		} else {
			return self::actionUrl($url);
		}
	}
}
