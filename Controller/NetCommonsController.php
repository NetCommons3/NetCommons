<?php
/**
 * NetCommons Controller
 * 
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsAppController', 'NetCommons.Controller');

/**
 * NetCommons Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
class NetCommonsController extends NetCommonsAppController {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
	);

/**
 * csrfToken method
 *
 * @return void
 */
	public function csrfToken() {
		$security = $this->Components->load('Security');
		$security->generateToken($this->request);

		$data = array(
			'_Token' => array(
				'key' => $this->request->params['_Token']['key']
			)
		);

		$this->set(compact('data'));
		$this->set('_serialize', array('data'));
	}

/**
 * Index action
 *
 * @return void
 */
	public function index() {
		$this->__stub();
	}

/**
 * Edit action
 *
 * @return void
 */
	public function edit() {
		$this->__stub();
	}

/**
 * Stub method for unit test
 *
 * @return void
 */
	private function __stub() {
		// @codeCoverageIgnoreStart
		if (php_sapi_name() !== 'cli') {
			throw new NotFoundException;
		}
		// @codeCoverageIgnoreEnd
		$this->autoRender = false;
	}
}
