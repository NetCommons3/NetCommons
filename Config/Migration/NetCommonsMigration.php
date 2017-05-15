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
 * This method will invoke the before/afterAction callbacks, it is good when
 * you need track every action.
 *
 * @param string $callback Callback name, beforeMigration, beforeAction, afterAction
 * 		or afterMigration.
 * @param string $type Type of action. i.e: create_table, drop_table, etc.
 * 		Or also can be the direction, for before and after Migration callbacks
 * @param array $data Data to send to the callback
 * @return void
 * @throws MigrationException
 */
	protected function _invokeCallbacks($callback, $type, $data = array()) {
		try {
			parent::_invokeCallbacks($callback, $type, $data);
		} catch (Exception $ex) {
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * Generate a instance of model for given options
 *
 * @param string $name Model name to be initialized
 * @param string $table Table name to be initialized
 * @param array $options Model constructor options
 * @return Model
 */
	public function generateModel($name, $table = null, $options = array()) {
		$Model = parent::generateModel($name, $table, $options);
		$Model->unbindModel(array(
			'belongsTo' => array('TrackableCreator', 'TrackableUpdater')
		), false);
		return $Model;
	}

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
		$objModel = $this->generateModel($model);
		if ($clear) {
			if (!$objModel->deleteAll(array('1 = 1'), false, false)) {
				return false;
			}
		}

		foreach ($records as $record) {
			foreach ($record as $field => $foreign) {
				if (! is_array($foreign)) {
					continue;
				}

				foreach ($foreign as $model2 => $options) {
					$objModel2 = $this->generateModel($model2);
					$result = $objModel2->find('first', $options);
					$record[$field] = Hash::get($result, $options['fields']);

					continue;
				}
			}

			$objModel->create();
			if (!$objModel->save($record, false)) {
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
 * @return void
 */
	public function loadModels(array $models = []) {
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
			$this->$model->setDataSource($this->connection);
			//if ($this->$model->useDbConfig !== 'test') {
			//	$this->$model->setDataSource($source);
			//}
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
