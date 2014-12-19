<?php
/**
 * Json CakePHP template test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Controller', 'Controller');
App::uses('CakeResponse', 'Network');

/**
 * Json CakePHP template test case
 */
class JsonTemplateTest extends CakeTestCase {

/**
 * testJson method
 *
 * @return void
 */
	public function testJson() {
		// It is better reference Google JSON Style Guide
		$response = new CakeResponse();
		$controller = new Controller(null, $response);
		$controller->viewClass = 'Json';
		$name = 'test';
		$status = '999';
		$results = 'results test';

		$controller->set(compact('name', 'status', 'results'));
		$response = $controller->render('NetCommons.Elements/json');
		$jsonArray = json_decode($response->body(), true);

		$this->assertEquals($name, $jsonArray['name']);
		$this->assertEquals($status, $jsonArray['code']);
		$this->assertEquals($results, $jsonArray['results']);
	}

}
