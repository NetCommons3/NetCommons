<?php
/**
 * Initialize Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Initialize Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class InitializeComponent extends Component {

/**
 * Model class
 *
 * @var array
 */
	public $modelClass;

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		if (! isset($this->modelClass)) {
			$pluginName = ucfirst(Inflector::pluralize($controller->params['plugin']));
			$modelClass = Inflector::classify($controller->params['controller']);
		} else {
			list($pluginName, $modelClass) = pluginSplit($this->modelClass);
		}

		try {
			$model = ClassRegistry::init($pluginName . '.' . $modelClass);
			$model->prepareCurrent($controller->request);

//			CakeLog::debug(print_r(CurrentBehavior::$current, true));
		} catch (Exception $ex) {

		}
	}
}
