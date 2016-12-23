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
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		//ビヘイビアの優先順位
		$this->settings['priority'] = 7;
	}

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
