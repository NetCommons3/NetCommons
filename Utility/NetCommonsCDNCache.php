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
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsCDNCache {

/**
 * Clear CDN Cache
 *
 * @return void
 */
	public function clear() {
		$data = array(
			"Site" => array(
				"Domain" => Configure::read('App.fullBaseUrl')
			)
		);

		$curl = curl_init();
		$accessToken = Configure::read('CDN.accessToken');
		$accessTokenSecret = Configure::read('CDN.accessTokenSecret');

		curl_setopt($curl, CURLOPT_URL, Configure::read('CDN.apiUrl') . 'deleteallcache');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_USERPWD, "$accessToken:$accessTokenSecret");
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

		curl_exec($curl);
		curl_close($curl);
	}
}
