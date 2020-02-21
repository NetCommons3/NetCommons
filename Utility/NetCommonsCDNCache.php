<?php
/**
 * NetCommons用CDNキャッシュ Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Wataru Nishimoto <watura@willbooster.com>
 * @author Kazunori Sakamoto <exkazuu@willbooster.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCache', 'NetCommons.Utility');

/**
 * NetCommons用CDNキャッシュ Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Wataru Nishimoto <watura@willbooster.com>
 * @author Kazunori Sakamoto <exkazuu@willbooster.com>
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsCDNCache {

/**
 * 高頻度なキャッシュ無効化を防ぐために、無効化のリクエストを無視する期間（秒）
 *
 * @var float
 */
	const NO_CACHE_INVALIDATION_DURATION_SEC = 1.0;

/**
 * Invalidate CDN Cache checking the invalidation frequency
 *
 * @return void
 */
	public function invalidate() {
		$ncCache = new NetCommonsCache('cache_invalidated_at', false, 'netcommons_core');
		$lastTime = floatval($ncCache->read());
		$now = microtime(true);
		if ($now - $lastTime > self::NO_CACHE_INVALIDATION_DURATION_SEC) {
			$ncCache->write($now);
			$this->postInvalidationRequest();
		}
	}

	/**
	 * Invalidate CDN Cache
	 *
	 * @return void
	 */
	public function postInvalidationRequest() {
		$cacheDomain = Configure::read('App.cacheDomain');
		if (!isset($cacheDomain)) {
			return;
		}

		$accessToken = Configure::read('Cdn.AccessToken');
		$accessTokenSecret = Configure::read('Cdn.Secret');
		if (!(isset($accessToken) && isset($accessTokenSecret))) {
			return;
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,
			'https://secure.sakura.ad.jp/cloud/zone/is1a/api/webaccel/1.0/deleteallcache');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_USERPWD, "$accessToken:$accessTokenSecret");
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$data = array(
			"Site" => array(
				"Domain" => $cacheDomain
			)
		);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

		curl_exec($curl);
		curl_close($curl);
	}
}
