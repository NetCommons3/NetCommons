<?php
/**
 * NetCommons用キャッシュ Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Cache', 'Cache');

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
$cacheSetting = Cache::settings('_cake_core_');
$cacheSetting['duration'] = '+999 days';
$cacheSetting['prefix'] =
		preg_replace('/cake_core_/', 'netcommons_core_', $cacheSetting['prefix']);
Cache::config('netcommons_core', $cacheSetting);

$cacheSetting = Cache::settings('_cake_model_');
$cacheSetting['duration'] = '+999 days';
$cacheSetting['prefix'] =
		preg_replace('/cake_model_/', 'netcommons_model_', $cacheSetting['prefix']);
Cache::config('netcommons_model', $cacheSetting);

/**
 * NetCommons用キャッシュ Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsCache {

/**
 * キャッシュの設定値
 *
 * @var array
 */
	private $__setting = [];

/**
 * キャッシュのデータ保持用
 *
 * @var array
 */
	private $__data = [];

/**
 * キャッシュ名
 *
 * @var string
 */
	private $__cacheName = '';

/**
 * キャッシュ種別
 *
 * @var string
 */
	private $__cacheType = '';

/**
 * テストか否か
 *
 * @var bool
 */
	private $__isTest = false;

/**
 * コンストラクタ
 *
 * @param string $cacheName キャッシュ名
 * @param bool $isTest テストか否か
 * @param string $cacheType キャッシュ種別
 * @return void
 */
	public function __construct($cacheName, $isTest, $cacheType = 'netcommons_core') {
		if (defined('NC3_VERSION') && $cacheName !== 'version') {
			$this->__cacheName = $cacheName . '_' . preg_replace('/\./', '_', NC3_VERSION);
		} else {
			$this->__cacheName = $cacheName;
		}
		$this->__isTest = $isTest;
		$this->__cacheType = $cacheType;
		$this->__setting = Cache::settings($this->__cacheType);

		if (! $this->__isTest) {
			$result = Cache::read($this->__cacheName, $this->__cacheType);
			if ($result !== false) {
				$this->__data = $result;
			}
		}
	}

/**
 * 空か否か
 *
 * @return bool
 */
	public function isEmpty() {
		return empty($this->__data);
	}

/**
 * キャッシュ変数からの読み込み
 *
 * @param string|null $mainKey メインキー
 * @param string|null $subKey サブキー
 * @return array|null|string|int|bool
 */
	public function read($mainKey = null, $subKey = null) {
		if (is_null($mainKey)) {
			return $this->__data;
		} elseif (is_null($subKey)) {
			if (isset($this->__data[$mainKey])) {
				return $this->__data[$mainKey];
			} else {
				return null;
			}
		} else {
			if (isset($this->__data[$mainKey][$subKey])) {
				return $this->__data[$mainKey][$subKey];
			} else {
				return null;
			}
		}
	}

/**
 * キャッシュの書き込み
 *
 * @param array|int|string|bool $value キャッシュに書き込む値
 * @param string|null $mainKey メインキー
 * @param string|null $subKey サブキー
 * @return void
 */
	public function write($value, $mainKey = null, $subKey = null) {
		if (is_null($mainKey)) {
			$this->__data = $value;
		} elseif (is_null($subKey)) {
			$this->__data[$mainKey] = $value;
		} else {
			$this->__data[$mainKey][$subKey] = $value;
		}

		if (! $this->__isTest) {
			Cache::write($this->__cacheName, $this->__data, $this->__cacheType);
		}
	}

/**
 * キャッシュから削除
 *
 * @param string|null $mainKey メインキー
 * @param string|null $subKey サブキー
 * @return void
 */
	public function delete($mainKey = null, $subKey = null) {
		if (is_null($mainKey)) {
			$this->__data = [];
		} elseif (is_null($subKey)) {
			if (isset($this->__data[$mainKey])) {
				unset($this->__data[$mainKey]);
			}
		} else {
			if (isset($this->__data[$mainKey][$subKey])) {
				unset($this->__data[$mainKey][$subKey]);
			}
		}

		if (! $this->__isTest) {
			$success = Cache::write($this->__cacheName, $this->__data, $this->__cacheType);
			if (! $success) {
				$this->__triggerWarning('delete');
			}
		}
	}

/**
 * キャッシュのクリア
 *
 * @return void
 */
	public function clear() {
		$this->__data = [];

		if (! $this->__isTest) {
			$engine = Cache::engine($this->__cacheType);
			if ($engine && $engine->key($this->__cacheName)) {
				$success = Cache::delete($this->__cacheName, $this->__cacheType);
			} else {
				$success = true;
			}
			if (! $success) {
				$this->__triggerWarning('clear');
			}
		}
	}

/**
 * キャッシュのクリア処理や削除処理が失敗した際にWarningを発生させる
 *
 * @param string $type 種別。'delete' or 'clear'
 * @return void
 */
	private function __triggerWarning($type) {
		if ($type === 'delete') {
			$message = __d(
				'net_commons',
				'Could not write to the %s cache file. Please check the file permissions.',
				$this->__setting['path'] . $this->__setting['prefix'] . $this->__cacheName
			);
		} else {
			$message = __d(
				'net_commons',
				'The %s cache file could not be deleted. ' .
					'Check the permissions of the file and delete the cache file.',
				$this->__setting['path'] . $this->__setting['prefix'] . $this->__cacheName
			);
		}
		trigger_error($message, E_USER_WARNING);
	}

}
