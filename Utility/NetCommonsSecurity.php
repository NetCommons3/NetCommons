<?php
/**
 * NetCommonsセキュリティ Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Current', 'NetCommons.Utility');
App::uses('SiteSettingUtil', 'SiteManager.Utility');

/**
 * NetCommonsセキュリティ Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class NetCommonsSecurity {

/**
 * コンストラクタ
 *
 * セキュリティチェックで使用するモデルをセットする
 *
 * @return void
 */
	public function __construct() {
		$this->SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
	}

/**
 * IP変動の禁止チェック
 *
 * @return bool
 */
	public function denyIpMove() {
		$ips = explode('|', SiteSettingUtil::read('Security.deny_ip_move', ''));
		$userRoleKey = Current::read('User.role_key');

		if (! in_array($userRoleKey, $ips, true)) {
			return true;
		}

		$currentId = $this->SiteSetting->getCurrentIp();
		if (! $currentId) {
			return true;
		}

		$sessionIp = CakeSession::read('Security.current_ip');
		if (! $sessionIp) {
			CakeSession::write('Security.current_ip', $currentId);
			$sessionIp = $currentId;
		}

		return ($currentId === $sessionIp);
	}

/**
 * IPアドレスの不正アクセスチェック
 *
 * @return bool
 */
	public function enableBadIps() {
		if (SiteSettingUtil::read('Security.enable_bad_ips')) {
			$ips = SiteSettingUtil::read('Security.bad_ips');
			if ($this->SiteSetting->hasCurrentIp($ips)) {
				return false;
			}
		}

		return true;
	}

/**
 * IPアドレスによる管理画面のアクセスチェック
 *
 * @return bool
 */
	public function enableAllowSystemPluginIps() {
		if (SiteSettingUtil::read('Security.enable_allow_system_plugin_ips')) {
			$ips = SiteSettingUtil::read('Security.allow_system_plugin_ips');
			if (! $this->SiteSetting->hasCurrentIp($ips)) {
				return false;
			}
		}

		return true;
	}

/**
 * サイト停止チェック
 *
 * @param CakeRequest $request CakeRequest
 * @return bool
 */
	public function isCloseSite(CakeRequest $request) {
		$allowUrls = array(
			['plugin' => 'auth', 'controller' => 'auth', 'action' => 'login'],
			['plugin' => 'auth_general', 'controller' => 'auth_general', 'action' => 'login'],
			['plugin' => 'net_commons', 'controller' => 'site_close', 'action' => 'index'],
		);

		//サイト停止画面、ログイン画面のみ許可する
		foreach ($allowUrls as $url) {
			if ($request->params['plugin'] === $url['plugin'] &&
					$request->params['controller'] === $url['controller'] &&
					$request->params['action'] === $url['action']) {

				return false;
			}
		}

		//サイト管理が使えるユーザはOKとする
		if (Current::allowSystemPlugin('site_manager')) {
			return false;
		}

		//サイト閉鎖のチェック
		return (bool)SiteSettingUtil::read('App.close_site');
	}

}
