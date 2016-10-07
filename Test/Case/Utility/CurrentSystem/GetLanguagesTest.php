<?php
/**
 * CurrentSystem::getLanguages()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('CurrentSystem', 'NetCommons.Utility');

/**
 * CurrentSystem::getLanguages()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentSystem
 */
class NetCommonsUtilityCurrentSystemGetLanguagesTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.m17n.language',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'net_commons';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Current::$current = array();
		Current::$m17n = array();

		$this->CurrentSystem = new CurrentSystem();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = array();
		Current::$m17n = array();

		parent::tearDown();
	}

/**
 * getLanguages()のテスト
 *
 * @return void
 */
	public function testGetLanguages() {
		//テスト実施
		$result = $this->CurrentSystem->getLanguages();

		//チェック
		$expected = array(
			0 => array(
				'Language' => array(
					'id' => '1',
					'code' => 'en',
					'weight' => '1',
					'is_active' => true,
					'created_user' => null,
					'created' => '2014-07-03 05:00:39',
					'modified_user' => null,
					'modified' => '2014-07-03 05:00:39',
				),
			),
			1 => array(
				'Language' => array(
					'id' => '2',
					'code' => 'ja',
					'weight' => '2',
					'is_active' => true,
					'created_user' => null,
					'created' => '2014-07-03 05:00:39',
					'modified_user' => null,
					'modified' => '2014-07-03 05:00:39',
				),
			),
		);
		$this->assertEquals($result, $expected);
	}

}
