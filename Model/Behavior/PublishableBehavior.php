<?php
/**
 * Publishable Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * Publishable Behavior
 *
 * @package  NetCommons\NetCommons\Model\Befavior
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 */
class PublishableBehavior extends ModelBehavior {

/**
 * Default settings
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
	protected $_defaults = array(
		'fields' => array(
			'status_by' => 'status'
		),
		'contentPublishable' => false
	);

/**
 * Setup
 *
 * @param Model $model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$this->settings[$model->alias] = Set::merge($this->_defaults, $config);
	}

/**
 * Checks wether model has the required fields
 *
 * @param Model $model instance of model
 * @return bool True if $model has the required fields
 */
	protected function _hasStatusField(Model $model) {
		$fields = $this->settings[$model->alias]['fields'];
		return $model->hasField($fields['status_by']);
	}

/**
 * beforeValidate is called before a model is validated, you can use this callback to
 * add behavior validation rules into a models validate array. Returning false
 * will allow you to make the validation fail.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		if (! $this->_hasStatusField($model)) {
			return parent::beforeValidate($model, $options);
		}

		$permission = NetCommonsRoomRoleComponent::PUBLISHABLE_PERMISSION;
		if ($this->settings[$model->alias][$permission]) {
			$statuses = NetCommonsBlockComponent::$STATUSES;
		} else {
			$statuses = NetCommonsBlockComponent::$STATUSES_FOR_EDITOR;
		}

		$fields = $this->settings[$model->alias]['fields'];
		$model->validate = Hash::merge($model->validate, array(
			$fields['status_by'] => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
				'inList' => array(
					'rule' => array('inList', $statuses),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
		));

		return parent::beforeValidate($model, $options);
	}

}
