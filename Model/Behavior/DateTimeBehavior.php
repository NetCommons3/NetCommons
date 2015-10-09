<?php
/**
 * DateTime Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * DateTime Behavior
 *
 * @package  NetCommons\NetCommons\Model\Befavior
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 */
class DateTimeBehavior extends ModelBehavior {

/**
 * 現時刻を取得
 *
 * @param Model $model Model using this behavior
 * @param string $type Type
 * @return string now()
 */
	public function getNowTime(Model $model, $type = 'datetime') {
		$db = $this->getDataSource();

		$colType = array_merge(array('formatter' => 'date'), $db->columns[$type]);
		$time = time();
		if (array_key_exists('format', $colType)) {
			$time = call_user_func($colType['formatter'], $colType['format']);
		}

		return $time;
	}

}
