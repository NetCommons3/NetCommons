<?php
/**
 * DateHelper Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Validation', 'Utility');
App::uses('NetCommonsTimeHelper', 'NetCommons.View/Helper');

/**
 * DateHelper Helper
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\NetCommons\View\Helper
 */
class DateHelper extends AppHelper {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsTime',
		'Time',
	);

/**
 * Date Format
 *
 * @param datetime $date datetime
 * @return array
 */
	public function dateFormat($date) {
		if (! Validation::datetime($date)) {
			return null;
		}
		// ユーザタイムゾーンに変換
		$date = $this->NetCommonsTime->toUserDatetime($date);

		if ($this->_isToday($date)) {
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
		$now = $this->NetCommonsTime->getNowDatetime();
		$nowUserDatetime = $this->NetCommonsTime->toUserDatetime($now);

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
		$now = $this->NetCommonsTime->getNowDatetime();
		$nowUserDatetime = $this->NetCommonsTime->toUserDatetime($now);

		$dateYear = date('Y', strtotime($date));
		$nowYear = date('Y', strtotime($nowUserDatetime));
		return ($dateYear === $nowYear);
	}
}