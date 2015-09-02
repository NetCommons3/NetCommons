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
 * Model class
 *
 * @var array
 */
	public $pluginName;

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		//$this->controller = $controller;

		if (! isset($this->modelClass)) {
			$this->modelClass = Inflector::classify($controller->params['controller']);
			$this->pluginName = Inflector::pluralize($controller->params['plugin']);
		} else {

		}

CakeLog::debug('InitialaizeComponent::setup $this->modelClass = ' . $this->modelClass);
CakeLog::debug('InitialaizeComponent::setup $controller->params[\'plugin\'] = ' . $controller->params['plugin']);
		//var_dump($this->modelClass);
	}
}
