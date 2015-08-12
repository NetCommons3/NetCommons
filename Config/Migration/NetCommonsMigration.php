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
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return bool Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
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

}
