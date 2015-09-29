<?php
/**
 * TestNetCommons Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * TestNetCommons Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\test_app\TestNetCommons\Controller
 */
class TestNetCommonsController extends AppController {

/**
 * index
 *
 * @return void
 */
	public function index() {
	}

/**
 * throw bad request
 *
 * @return void
 */
	public function throwBadRequestAjax() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		parent::throwBadRequest();
	}

}
