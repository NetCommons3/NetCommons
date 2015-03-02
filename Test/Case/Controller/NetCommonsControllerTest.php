<?php
/**
 * NetCommonsController Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsController', 'NetCommons.Controller');

/**
 * Summary for NetCommonsController Test Case
 */
class NetCommonsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
	);

/**
 * testCsrfToken method
 *
 * @return void
 */
	public function testCsrfToken() {
		CakeSession::write('Auth.User.id', '1');
		Router::parseExtensions();
		$this->testAction('/net_commons/net_commons/csrfToken.json', array('return' => 'contents'));

		$this->assertTextContains('_Token', $this->contents);
		$this->assertTextContains('key', $this->contents);

		$this->assertNotEmpty(CakeSession::read('_Token.csrfTokens'));
		CakeSession::delete('Auth.User.id');
	}

}
