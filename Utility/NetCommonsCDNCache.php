<?php
/**
 * NetCommons用CDNキャッシュ Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

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
 * Invalidate CDN Cache
 *
 * @return void
 */
	public function invalidate() {
		$data = array(
			"Site" => array(
				"Domain" => Configure::read('App.cacheDomain')
			)
		);

		$curl = curl_init();
		$accessToken = Configure::read('Cdn.AccessToken');
		$accessTokenSecret = Configure::read('Cdn.Secret');
		if (!(isset($accessToken) && isset($accessTokenSecret))) {
			return;
		}

		curl_setopt($curl, CURLOPT_URL,
			'https://secure.sakura.ad.jp/cloud/zone/is1a/api/webaccel/1.0/deleteallcache');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_USERPWD, "$accessToken:$accessTokenSecret");
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

		curl_exec($curl);
		curl_close($curl);
	}
}
