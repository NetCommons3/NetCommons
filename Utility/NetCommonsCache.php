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
$cacheSetting['prefix'] = preg_replace('/cake_core_/', 'netcommons_', $cacheSetting['prefix']);
Cache::config('netcommons', $cacheSetting);

/**
 * NetCommons用キャッシュ Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsCache {

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
	public function __construct($cacheName, $isTest, $cacheType = 'netcommons') {
		$this->__cacheName = $cacheName;
		$this->__isTest = $isTest;
		$this->__cacheType = $cacheType;

		$result = Cache::read($this->__cacheName, $this->__cacheType);
		if ($result !== false) {
			$this->__data = $result;
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
			Cache::write($this->__cacheName, $this->__data, $this->__cacheType);
		}
	}

/**
 * キャッシュのクリア
 *
 * @return void
 */
	public function clear() {
		$this->__data = [];
		Cache::delete($this->__cacheName, $this->__cacheType);
	}

}
