<?php
/**
 * NetCommonsMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CakeMigration', 'Migrations.Lib');
App::uses('I18n', 'I18n');

/**
 * NetCommonsMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Config\Migration
 */
class NetCommonsMigration extends CakeMigration {

/**
 * plugin data
 *
 * @var array $migration
 */
	public $records = array();

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param array $records records to be stored
 * @param bool $clear 初期化するかどうか
 * @return bool Should process continue
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function updateRecords($model, $records, $clear = false) {
		$Model = $this->generateModel($model);
		if ($clear) {
			if (!$Model->deleteAll(array('1 = 1'), false, false)) {
				return false;
			}
		}
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}

/**
 * Delete model records
 *
 * @param string $model model name to delete
 * @param array $records records to be stored
 * @param string $key 削除条件項目
 * @return bool Should process continue
 */
	public function deleteRecords($model, $records, $key = 'id') {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$id = Hash::get($record, $key);
			if (!$id) {
				continue;
			}
			$conditions = array($key => $id);
			if (!$Model->deleteAll($conditions, false, false)) {
				return false;
			}
		}
		return true;
	}

/**
 * Load models
 *
 * @param array $models models to load
 * @param string $source data source
 * @return void
 */
	public function loadModels(array $models = [], $source = 'master') {
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
			if ($this->$model->useDbConfig !== 'test') {
				$this->$model->setDataSource($source);
			}
		}
	}

/**
 * データ投入のマイグレーションupの更新と,downの削除
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function updateAndDeleteRecords($direction) {
		foreach ($this->records as $model => $records) {
			if ($direction === 'up') {
				if (!$this->updateRecords($model, $records)) {
					return false;
				}
			} elseif ($direction === 'down') {
				if (!$this->deleteRecords($model, $records)) {
					return false;
				}
			}
		}

		return true;
	}
}
