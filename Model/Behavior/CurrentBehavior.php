<?php
/**
 * Current Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');
App::uses('CurrentUtility', 'NetCommons.Utility');

/**
 * Current Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class CurrentBehavior extends ModelBehavior {

/**
 * Get the current data.
 *
 * @param Model $model Model using this behavior
 * @param string $key field to retrieve. Leave null to get entire Current data
 * @return void
 */
	public function current(Model $model, $key = null) {
		return CurrentUtility::current($key);
	}
}
