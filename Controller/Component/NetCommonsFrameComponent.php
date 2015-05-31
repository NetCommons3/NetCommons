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
 * Frame data w/ associations
 *
 * @var array
 */
	public $data = [];

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;

		//model class registry
		$models = array(
			'Box' => 'Boxes.Box',
			'Frame' => 'Frames.Frame',
			'Language' => 'M17n.Language',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//default
		$this->controller->set('frameId', 0);
		$this->controller->set('frameKey', '');
		$this->controller->set('roomId', 0);
		$this->controller->set('languageId', 0);

		if ($this->frameId === null) {
			$this->frameId = (isset($this->controller->params['pass'][0]) ? (int)$this->controller->params['pass'][0] : 0);
		}

		if ($this->frameId) {
			$this->setView();
		}
	}

/**
 * Controller view set
 *
 * @return void
 */
	public function setView() {
		//set language_id
		if (isset($this->controller->viewVars['languageId']) && $this->controller->viewVars['languageId'] === 0) {
			$language = $this->Language->findByCode(Configure::read('Config.language'));
			$this->controller->set('languageId', $language['Language']['id']);
		}

		//set frame by id
		$frame = $this->Frame->findById($this->frameId);
		$this->data = $frame;

		$this->__setViewFrame($frame);
	}

/**
 * Controller frame data set
 *
 * @param array $frame frame data
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewFrame($frame) {
		if (! $frame || ! isset($frame['Frame']['id'])) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$this->controller->set('frameId', (int)$frame['Frame']['id']);
		$this->controller->set('frameKey', $frame['Frame']['key']);
		$this->controller->set('blockId', (is_int($frame['Frame']['block_id']) ? (int)$frame['Frame']['block_id'] : $frame['Frame']['block_id']));
		if (isset($frame['Block'])) {
			$this->controller->set('blockKey', $frame['Block']['key']);
		}
		$this->controller->set('roomId', (int)$frame['Frame']['room_id']);
		$this->controller->set('languageId', (int)$frame['Frame']['language_id']);
	}

/**
 * Validate frameId on request data
 *
 * @return mixed true on success, false on failure
 */
	public function validateFrameId() {
		if (! isset($this->controller->viewVars['frameId']) || (int)$this->controller->viewVars['frameId'] === 0) {
			return false;
		}
		if ($this->controller->request->isGet()) {
			return true;
		}

		if (! isset($this->controller->data['Frame']['id']) || (int)$this->controller->data['Frame']['id'] === 0) {
			return true;
		}
		//POSTのframeIdとGETのframeIdのチェック
		if ((int)$this->controller->data['Frame']['id'] !== (int)$this->controller->viewVars['frameId']) {
			return false;
		}
		return true;
	}

}
