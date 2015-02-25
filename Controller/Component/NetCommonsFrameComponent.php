<?php
/**
 * NetCommonsFrame Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * NetCommonsFrame Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsFrameComponent extends Component {

/**
 * frame id
 *
 * @var mixed false do not use the setView(). null to get frames.id from request parameter. ingerger is frames.id .
 */
	public $frameId = null;

/**
 * frame key
 *
 * @var mixed false do not use the setViewKey(). null to get frames.key from request parameter. string is frames.key .
 */
	public $frameKey = false;

/**
 * language code
 *
 * @var mixed null to get languages.id from Config.language. string is languages.id .
 */
	public $languageCode = null;

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		//model class registry
		$models = array(
			'Frame' => 'Frames.Frame',
			'Language' => 'Language',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//default
		$controller->set('frameId', 0);
		$controller->set('frameKey', '');
		/* $controller->set('blockId', 0); */
		/* $controller->set('blockKey', ''); */
		$controller->set('roomId', 0);
		$controller->set('languageId', 0);
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 */
	public function startup(Controller $controller) {
		if ($this->frameId === null) {
			$this->frameId = (isset($controller->params['pass'][0]) ? (int)$controller->params['pass'][0] : 0);
		} elseif ($this->frameKey === null) {
			$this->frameKey = (isset($controller->params['pass'][0]) ? $controller->params['pass'][0] : false);
		}

		if ($this->frameId) {
			$this->setView($controller);
		} elseif ($this->frameKey) {
			$this->setViewKey($controller);
		}
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function setView(Controller $controller) {
		//set language_id
		if (isset($controller->viewVars['languageId']) && $controller->viewVars['languageId'] === 0) {
			$language = $this->Language->findByCode(Configure::read('Config.language'));
			$controller->set('languageId', $language['Language']['id']);
		}

		//set frame by id
		$frame = $this->Frame->findById($this->frameId);

		$this->__setViewFrame($controller, $frame);
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function setViewKey(Controller $controller) {
		//set language_id
		if ($this->languageCode === null) {
			$this->languageCode = Configure::read('Config.language');
		}
		$language = $this->Language->findByCode($this->languageCode);
		$controller->set('languageId', $language['Language']['id']);

		//get frame by key and language_id
		$frame = $this->Frame->find('first', array(
				'conditions' => array(
					'Frame.key' => $this->frameKey,
					'Frame.language_id' => $controller->viewVars['languageId']
				)
			));

		$this->__setViewFrame($controller, $frame);
	}

/**
 * Controller frame data set
 *
 * @param Controller $controller Instantiating controller
 * @param array $frame frame data
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewFrame(Controller $controller, $frame) {
		if (! $frame || ! isset($frame['Frame']['id'])) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$controller->set('frameId', (int)$frame['Frame']['id']);
		$controller->set('frameKey', $frame['Frame']['key']);
		$controller->set('blockId', (is_int($frame['Frame']['block_id']) ? (int)$frame['Frame']['block_id'] : $frame['Frame']['block_id']));
		if (isset($frame['Block'])) {
			$controller->set('blockKey', $frame['Block']['key']);
		}
		$controller->set('roomId', (int)$frame['Frame']['room_id']);
		$controller->set('languageId', (int)$frame['Frame']['language_id']);
	}

}
