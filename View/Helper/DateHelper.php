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
	);

/**
 * Date Format
 *
 * @param datetime $date datetime
 * @param null|string $format フォーマット
 * @return array
 */
	public function dateFormat($date, $format = null) {
		return  $this->NetCommonsTime->dateFormat($date, $format);
	}

}
