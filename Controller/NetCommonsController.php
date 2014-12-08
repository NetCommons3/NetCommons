<?php
/**
 * NetCommons Controller
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

}
