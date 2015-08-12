<?php
/**
 * OriginalKey Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * OriginalKey Behavior
 *
 * @package  NetCommons\NetCommons\Model\Befavior
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 */
class OriginalKeyBehavior extends ModelBehavior {

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		if (! $model->hasField('key')) {
			return true;
		}
		//  beforeSave はupdateAllでも呼び出される。
		if (isset($model->data[$model->name]['id']) && ($model->data[$model->name]['id'] > 0)) {
			// updateのときは何もしない
			return true;
		}
		if (! isset($model->data[$model->name]['key']) || $model->data[$model->name]['key'] === '') {
			$model->data[$model->name]['key'] = $this->generateKey($model);
		}
		return true;
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @see Model::save()
 */
	public function afterSave(Model $model, $created, $options = array()) {
		if ($created && $model->hasField('origin_id')) {
			if (isset($model->data[$model->name]['origin_id']) &&
					(int)$model->data[$model->name]['origin_id'] === 0) {
				// origin_id がセットされてなかったらkey=idでupdate
				$backupData = $model->data;
				$result = $model->saveField('origin_id', $model->data[$model->name]['id'], array('callbacks' => false));
				$model->data = $backupData;
				$model->data[$model->name]['origin_id'] = $result[$model->name]['origin_id'];

				//$model->saveField('origin_id', $model->data[$model->name]['id']);
			}
		}
	}

/**
 * Generate key
 *
 * @param Model $model Model using this behavior
 * @return string Hash key
 */
	public function generateKey(Model $model) {
		return Security::hash($model->name . mt_rand() . microtime(), 'md5');
	}

}
