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

/**
 * Current Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Behavior
 */
class CurrentBehavior extends ModelBehavior {

/**
 * layout
 *
 * @var array
 */
	public $aaaa = '';

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public static function initialize($params = array()) {
		static $requestParams = null;

		//$this->settings = Hash::merge($this->settings, $config);

CakeLog::debug('CurrentBehavior::initialize');
//CakeLog::debug('CurrentBehavior::initialize $model->model' . $model->table);
CakeLog::debug(print_r($params, true));

		if (! $requestParams) {
			$requestParams = $params;
		}

		return $requestParams;
	}

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		//$this->settings = Hash::merge($this->settings, $config);

CakeLog::debug('CurrentBehavior::setup');
CakeLog::debug('CurrentBehavior::setup $model->model = ' . $model->table);
CakeLog::debug($model->table);
CakeLog::debug($this->aaaa);

$this->aaaa = 'aaaa';
	}

}
