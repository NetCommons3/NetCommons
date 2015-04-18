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
	const STATUS_IN_DRAFT = '3';

/**
 * status disaproved
 *
 * @var string
 */
	const STATUS_DISAPPROVED = '4';

/**
 * status list for editor
 *
 * @var array
 */
	static public $statusesForEditor = array(
		self::STATUS_APPROVED,
		self::STATUS_IN_DRAFT
	);

/**
 * status list
 *
 * @var array
 */
	static public $STATUSES = array(
		self::STATUS_PUBLISHED,
		self::STATUS_APPROVED,
		self::STATUS_IN_DRAFT,
		self::STATUS_DISAPPROVED
	);

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}
}
