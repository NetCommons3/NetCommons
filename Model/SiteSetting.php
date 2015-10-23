<?php
/**
 * SiteSetting Model
 *
 * @property CreatedUser $CreatedUser
 * @property ModifiedUser $ModifiedUser
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');
App::uses('Current', 'NetCommons.Utility');

/**
 * Summary for SiteSetting Model
 */
class SiteSetting extends AppModel {

/**
 * サイトに設定されているテーマを返す
 *
 * @author Takako Miyagawa <nekoget@gmail.com>
 * @return string or null
 */
	public function getSiteTheme() {
		$row = $this->find('first', array(
			'conditions' => array('SiteSetting.key' => 'theme'),
		));
		if ($row && isset($row['SiteSetting'])
			&& isset($row['SiteSetting']['value'])) {
			return $row['SiteSetting']['value'];
		}
		return null;
	}

/**
 * サイトのデフォルトタイムゾーン（未ログインのゲスト用）を返す
 *
 * @return string timezone
 */
	public function getSiteTimezone() {
		$languageId = Current::read('Language.id');
		$setting = $this->findByLanguageIdAndKey($languageId, 'site_timezone');
		$timezone = $setting['SiteSetting']['value'];
		return $timezone;
	}
}

