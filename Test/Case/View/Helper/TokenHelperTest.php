<?php
/**
 * TokenHelper Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('View', 'View');
App::uses('TokenHelper', 'NetCommons.View/Helper');

/**
 * Summary for TokenHelper Test Case
 */
class TokenHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$View = new View();
		$this->Token = new TokenHelper($View);
		$this->Token->request = new CakeRequest('test', false);
		$this->Token->request->data = array(
			'TestModel' => array(
				'id' => 1,
				'first_name' => 'Nate',
				'last_name' => 'Abele',
				'email' => 'nate@example.com',
				'created' => '2014-12-5 05:04:42',
				'created_user' => '1',
				'modified' => '2014-12-09 05:04:42',
				'modified_user' => '2'
			)
		);
		$this->Token->request['_Token'] = array('key' => 'testKey');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Token);

		parent::tearDown();
	}

/**
 * testGetToken method
 *
 * @return void
 */
	public function testGetToken() {
		$tokenFields = Hash::flatten($this->Token->request->data);
		$hiddenFields = array('TestModel.email');

		$tokens = $this->Token->getToken($tokenFields, $hiddenFields);

		$this->assertEquals('testKey', $tokens['_Token']['key']);
		$this->assertTextContains('TestModel.email', $tokens['_Token']['fields']);
		$this->assertEmpty($tokens['_Token']['unlocked']);
	}

/**
 * testGetTokenUnlocked method
 *
 * @return void
 */
	public function testGetTokenUnlocked() {
		$tokenFields = Hash::flatten($this->Token->request->data);
		$hiddenFields = array('TestModel.email');
		$this->Token->request['_Token'] += array('unlockedFields' => 'TestModel.email');

		$tokens = $this->Token->getToken($tokenFields, $hiddenFields);

		$this->assertEquals('testKey', $tokens['_Token']['key']);
		$this->assertNotContains('TestModel.email', $tokens['_Token']['fields']);
		$this->assertEquals('TestModel.email', $tokens['_Token']['unlocked']);
	}

/**
 * testGetTokenBlacklist method
 *
 * @return void
 */
	public function testGetTokenBlacklist() {
		$tokenFields = Hash::flatten($this->Token->request->data);
		$hiddenFields = array(
			'TestModel.email',
			'TestModel.created',
			'TestModel.modified',
			'TestModel.created_user',
			'TestModel.modified_user'
		);

		$tokens = $this->Token->getToken($tokenFields, $hiddenFields);

		$this->assertEquals('testKey', $tokens['_Token']['key']);
		$this->assertContains('TestModel.email', $tokens['_Token']['fields']);
		$this->assertNotContains('TestModel.created', $tokens['_Token']['fields']);
		$this->assertNotContains('TestModel.modified', $tokens['_Token']['fields']);
		$this->assertNotContains('TestModel.created_user', $tokens['_Token']['fields']);
		$this->assertNotContains('TestModel.modified_user', $tokens['_Token']['fields']);
		$this->assertEmpty($tokens['_Token']['unlocked']);
	}

/**
 * testGetTokenUnlocked method
 *
 * @return void
 */
	public function testGetTokenBlacklistPass() {
		$tokenFields = Hash::flatten($this->Token->request->data);
		$hiddenFields = array('TestModel.email', 'TestModel.created');
		$blackLists = array('TestModel.email');

		$tokens = $this->Token->getToken($tokenFields, $hiddenFields, $blackLists);

		$this->assertEquals('testKey', $tokens['_Token']['key']);
		$this->assertNotContains('TestModel.email', $tokens['_Token']['fields']);
		$this->assertContains('TestModel.created', $tokens['_Token']['fields']);
		$this->assertEmpty($tokens['_Token']['unlocked']);
	}
}
