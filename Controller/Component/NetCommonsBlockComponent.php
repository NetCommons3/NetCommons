<?php
/**
 * NetCommonsBlock Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * NetCommonsBlock Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsBlockComponent extends Component {

/**
 * status published
 *
 * @var string
 */
	const STATUS_PUBLISHED = '1';

/**
 * status approved
 *
 * @var string
 */
	const STATUS_APPROVED = '2';

/**
 * in draft status
 *
 * @var string
 */
	const STATUS_INDRAFT = '3';

/**
 * status disaproved
 *
 * @var string
 */
	const STATUS_DISAPPROVED = '4';

/**
 * status list
 *
 * @var array
 */
	static public $STATUSES = array(
		self::STATUS_PUBLISHED,
		self::STATUS_APPROVED,
		self::STATUS_INDRAFT,
		self::STATUS_DISAPPROVED
	);

/**
 * block id
 *
 * @var mixed false do not use the setView(). null to get blocks.id from request parameter. ingerger is blocks.id .
 */
	public $blockId = false;

/**
 * block key
 *
 * @var mixed false do not use the setViewKey(). null to get blocks.key from request parameter. string is blocks.key .
 */
	public $blockKey = false;

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
			'Block' => 'Blocks.Block',
			'Language' => 'Language',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//default
		$controller->set('blockId', 0);
		$controller->set('blockKey', '');
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
		if ($this->blockId === null) {
			$this->blockId = (isset($controller->params['pass'][0]) ? (int)$controller->params['pass'][0] : 0);
			$this->blockId = (int)$this->blockId;
		} elseif ($this->blockKey === null) {
			$this->blockKey = (isset($controller->params['pass'][0]) ? $controller->params['pass'][0] : false);
		}

		if ($this->blockId) {
			$this->setView($controller);
		} elseif ($this->blockKey) {
			$this->setViewKey($controller);
		}
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return bool true is success, false is error.
 */
	public function setView(Controller $controller) {
		//set language_id
		if ($controller->viewVars['languageId'] === 0) {
			$language = $this->Language->findByCode(Configure::read('Config.language'));
			$controller->set('languageId', $language['Language']['id']);
		}

		//get block by id
		$block = $this->Block->findById($this->blockId);

		$this->__setViewBlock($controller, $block);
	}

/**
 * Controller view set
 *
 * @param Controller $controller Instantiating controller
 * @return bool true is success, false is error.
 */
	public function setViewKey(Controller $controller) {
		//set language_id
		if ($this->languageCode === null) {
			$this->languageCode = Configure::read('Config.language');
		}
		$language = $this->Language->findByCode($this->languageCode);
		$controller->set('languageId', $language['Language']['id']);

		//get block by key and language_id
		$block = $this->Block->find('first', array(
			'conditions' => array(
				'Block.key' => $this->blockKey,
				'Block.language_id' => $controller->viewVars['languageId'],
			)
		));

		$this->__setViewBlock($controller, $block);
	}

/**
 * Controller view frame set
 *
 * @param Controller $controller Instantiating controller
 * @param array $block blocks
 * @return void
 * @throws InternalErrorException
 */
	private function __setViewBlock(Controller $controller, $block) {
		if (! $block || ! isset($block['Block']['id'])) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$controller->set('blockId', (int)$block['Block']['id']);
		$controller->set('blockKey', $block['Block']['key']);
		$controller->set('roomId', (int)$block['Block']['room_id']);
		$controller->set('languageId', (int)$block['Block']['language_id']);
	}

}
