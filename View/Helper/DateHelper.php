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

		if ($this->Time->isToday($date)) {
			return date('G:i', strtotime($date));

		} elseif (! $this->Time->isThisYear($date)) {
			return date('Y/m/d', strtotime($date));

		} else {
			return date('m/d', strtotime($date));
		}
	}

}