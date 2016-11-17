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
 * ビヘイビアの設定
 *
 * @var array
 * @see ModelBehavior::$settings
 */
	public $settings = array(
		'priority' => 8
	);

/**
 * PHPUnitで使用するキー配列
 *
 * @var mixed
 */
	public static $isUnitRandomKey = false;

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
		if (isset($model->data[$model->alias]['id']) && ($model->data[$model->alias]['id'] > 0)) {
			// updateのときは何もしない
			return true;
		}
		if (! isset($model->data[$model->alias]['key']) || $model->data[$model->alias]['key'] === '') {
			$model->data[$model->alias]['key'] = self::generateKey($model->alias, $model->useDbConfig);
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
			if (isset($model->data[$model->alias]['origin_id']) &&
					(int)$model->data[$model->alias]['origin_id'] === 0) {
				// origin_id がセットされてなかったらkey=idでupdate
				$backupData = $model->data;
				$result = $model->saveField(
					'origin_id', $model->data[$model->alias]['id'], array('callbacks' => false)
				);
				$model->data = $backupData;
				$model->data[$model->alias]['origin_id'] = $result[$model->alias]['origin_id'];

				//$model->saveField('origin_id', $model->data[$model->alias]['id']);
			}
		}
	}

/**
 * Generate key
 *
 * @param string $plugin Plugin name
 * @param string $dataSource The name of the DataSource, as defined in app/Config/database.php
 * @return string Hash key
 */
	public static function generateKey($plugin, $dataSource) {
		if ($dataSource !== 'test' || self::$isUnitRandomKey) {
			return Security::hash($plugin . mt_rand() . microtime(), 'md5');
		} else {
			return Security::hash($plugin, 'md5');
		}
	}

}
