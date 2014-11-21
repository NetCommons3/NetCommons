<?php
/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller
 */
class NetCommonsAppController extends AppController {

/**
 * json render
 *
 * @param array $results results data
 * @param string $name message
 * @param int $status status code
 * @return void
 */
	public function renderJson($results, $name = 'OK', $status = 200) {
		$this->viewClass = 'Json';
		$this->layout = false;
		$this->response->statusCode($status);
		$result = array(
			'code' => $status,
			'name' => $name,
			'results' => $results,
		);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');

		$this->render(false);
	}

}
