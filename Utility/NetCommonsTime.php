<?php
/**
 * NetCommonsTime
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Current', 'NetCommons.Utility');

/**
 * Class NetCommonsTime
 *
 * タイムゾーンを考慮した日時を算出します。
 * コンポーネントとヘルパーを提供しています。
 *
 * [NetCommonsTimeComponent](./NetCommonsTimeComponent.html)<br>
 * [NetCommonsTimeHelper](./NetCommonsTimeHelper.html)
 *
 * ## テストで時刻を差し替えたいときのサンプルコード
 * ```
 *    $nowProperty = new ReflectionProperty('NetCommonsTime', '_now');
 *    $nowProperty->setAccessible(true);
 *    $nowProperty->setValue(strtotime('2000-01-01 00:00:00'));
 *    // test code ..
 *    $nowProperty->setValue(null); // 現在日時変更が他のテストに影響を与えないようにnullにもどしておく
 * ```
 *
 * ## 現在時刻を得る
 * ```
 * $nowDatetime = (new NetCommonsTime())->getNowDatetime();
 * ```
 */
class NetCommonsTime {

/**
 * @var int 現在日時 unixtime
 */
	protected static $_now = null;

/**
 * Unitテストで自由に変更できるようするため、publicにする
 *
 * @var string サイトデフォルトタイムゾーン
 */
	public static $siteTimezone = null;

/**
 * サイトのデフォルトタイムゾーンを返す
 *
 * @return string タイムゾーン
 */
	public function getSiteTimezone() {
		if (self::$siteTimezone === null) {
			$SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
			self::$siteTimezone = $SiteSetting->getSiteTimezone();
		}
		return self::$siteTimezone;
	}

/**
 * サーバタイムゾーンの日時をユーザタイムゾーンの日時に変換する
 *
 * @param string $serverDatetime server timezone datetime
 * @return string ユーザタイムゾーンの日時
 */
	public function toUserDatetime($serverDatetime) {
		if (! $this->isDatetime($serverDatetime)) {
			//日時型じゃない場合、変換できないので、そのまま返す。
			return $serverDatetime;
		}
		$userTimezone = $this->getUserTimezone();
		$date = new DateTime($serverDatetime, new DateTimeZone('UTC'));

		$date->setTimezone(new DateTimeZone($userTimezone));
		return $date->format('Y-m-d H:i:s');
	}

/**
 * サーバタイムゾーンの日時が含まれる連想配列から指定された配列添え字の値だけをユーザタイムゾーンに変換した配列を返す
 *
 * @param array $data サーバタイムゾーンの日時が含まれた配列
 * @param array $convertKeyNameList ユーザタイムゾーンに変換する配列添え字
 * @return array ユーザタイムゾーンに変換済みの配列
 */
	public function toUserDatetimeArray(array $data, array $convertKeyNameList) {
		$userDatetimeData = $data;
		$convertKeyNameList = Hash::filter($convertKeyNameList);
		foreach ($convertKeyNameList as $keyName) {
			if (Hash::get($data, $keyName)) {
				$_userDatetime = $this->toUserDatetime(Hash::get($data, $keyName));
				$userDatetimeData = Hash::insert($userDatetimeData, $keyName, $_userDatetime);
			}
		}
		//
		//foreach ($userDatetimeData as $key => $value) {
		//	if (is_array($value)) {
		//		$userDatetimeData[$key] = $this->toUserDatetimeArray($value, $convertKeyNameList);
		//	} else {
		//		if (in_array($key, $convertKeyNameList)) {
		//			$userDatetimeData[$key] = $this->toUserDatetime($value);
		//		}
		//	}
		//}
		return $userDatetimeData;
	}

/**
 * ユーザタイムゾーンからサーバタイムゾーンに日時を変換する
 *
 * @param string $userDatetime ユーザタイムゾーンの日時
 * @param null|string $userTimezone ユーザタイムゾーンを指定したい時にユーザタイムゾーンを渡す。指定しないとアクセスユーザのタイムゾーンを対象に変換する
 * @return string サーバタイムゾーンに変換された日時
 */
	public function toServerDatetime($userDatetime, $userTimezone = null) {
		if (! $this->isDatetime($userDatetime)) {
			//日時型じゃない場合、変換できないので、そのまま返す。
			return $userDatetime;
		}
		if (! $userTimezone) {
			$userTimezone = $this->getUserTimezone();
		}
		$date = new DateTime($userDatetime, new DateTimeZone($userTimezone));

		$date->setTimezone(new DateTimeZone('UTC'));
		return $date->format('Y-m-d H:i:s');
	}

/**
 * ユーザタイムゾーンの日時が含まれる連想配列から指定された配列添え字の値だけをサーバタイムゾーンに変換した配列を返す
 *
 * @param array $data ユーザタイムゾーンの日時が含まれた配列
 * @param array $convertKeyNameList サーバタイムゾーンに変換する配列添え字
 * @param null|string $userTimezone  ユーザタイムゾーンを指定したい時にユーザタイムゾーンを渡す。指定しないとアクセスユーザのタイムゾーンを対象に変換する
 * @return array サーバタイムゾーンに変換済みの配列
 */
	public function toServerDatetimeArray($data, array $convertKeyNameList, $userTimezone = null) {
		$serverDatetimeData = $data;
		$convertKeyNameList = Hash::filter($convertKeyNameList);
		foreach ($convertKeyNameList as $keyName) {
			$date = Hash::get($data, $keyName);
			if ($date) {
				$_serverDatetime = $this->toServerDatetime($date, $userTimezone);
				$serverDatetimeData = Hash::insert($serverDatetimeData, $keyName, $_serverDatetime);
			}
		}

		//foreach ($serverDatetimeData as $key => $value) {
		//	if (is_array($value)) {
		//		$serverDatetimeData[$key] = $this->toServerDatetimeArray($value, $convertKeyNameList, $userTimezone);
		//	} else {
		//		if (in_array($key, $convertKeyNameList)) {
		//			$serverDatetimeData[$key] = $this->toServerDatetime($value, $userTimezone);
		//		}
		//	}
		//}
		return $serverDatetimeData;
	}

/**
 * 現在日時を返す
 *
 * @return string
 */
	static public function getNowDatetime() {
		if (self::$_now === null) {
			self::$_now = time();
		}
		return date('Y-m-d H:i:s', self::$_now);
	}

/**
 * アクセスしたユーザのタイムゾーンを返す
 * ゲストならサイトタイムゾーンを返す
 *
 * @return string タイムゾーン
 */
	public function getUserTimezone() {
		$userTimezone = Current::read('User.timezone');
		if (! $userTimezone) {
			$userTimezone = $this->getSiteTimezone();
		}
		return $userTimezone;
	}

/**
 * DateTime型チェック
 *
 * @param string $value datetimeの値
 * @return bool DateTime型
 */
	public function isDatetime($value) {
		try {
			// DateTime値チェック($value=20150716150000 or 2018-06-26 11:37:39いずれにも対応)
			new DateTime($value, new DateTimeZone('UTC'));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}

/**
 * Date Format
 *
 * @param datetime $date datetime
 * @param null|string $format フォーマット
 * @return array
 */
	public function dateFormat($date, $format = null) {
		if (! Validation::datetime($date)) {
			return null;
		}
		// ユーザタイムゾーンに変換
		$date = $this->toUserDatetime($date);

		if ($format) {
			return date($format, strtotime($date));

		} elseif ($this->_isToday($date)) {
			return date('G:i', strtotime($date));

		} elseif (! $this->_isThisYear($date)) {
			return date('Y/m/d', strtotime($date));

		} else {
			return date('m/d', strtotime($date));
		}
	}

/**
 * ユーザタイムゾーンで今日の日付かの判定
 *
 * @param string $date user timezone datetime
 * @return bool
 */
	protected function _isToday($date) {
		$now = $this->getNowDatetime();
		$nowUserDatetime = $this->toUserDatetime($now);

		$dateYmd = date('Y-m-d', strtotime($date));
		$nowYmd = date('Y-m-d', strtotime($nowUserDatetime));
		return ($dateYmd === $nowYmd);
	}

/**
 * ユーザタイムゾーンで今年の日時かの判定
 *
 * @param string $date user timezone datetime
 * @return bool
 */
	protected function _isThisYear($date) {
		$now = $this->getNowDatetime();
		$nowUserDatetime = $this->toUserDatetime($now);

		$dateYear = date('Y', strtotime($date));
		$nowYear = date('Y', strtotime($nowUserDatetime));
		return ($dateYear === $nowYear);
	}

}
