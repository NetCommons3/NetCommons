<?php
/**
 * CurrentPage::setDefaultRolePermissions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * CurrentPage::setDefaultRolePermissions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\CurrentPage
 */
class NetCommonsUtilityCurrentPageSetDefaultRolePermissionsTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.roles.default_role_permission',
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

		$this->CurrentPage = new CurrentPage();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current = array();
		parent::tearDown();
	}

/**
 * RolesRoomなしテスト
 *
 * @return void
 */
	public function testWORolesRoom() {
		//テスト実施
		$this->assertArrayNotHasKey('DefaultRolePermission', Current::$current);
		$this->CurrentPage->setDefaultRolePermissions();

		//チェック
		$expected = $this->__assertData('visitor');
		$this->assertEquals(Current::$current, $expected);
	}

/**
 * RolesRoomありテスト
 *
 * @return void
 */
	public function testWithRolesRoom() {
		//テスト実施
		Current::$current['RolesRoom']['role_key'] = 'room_administrator';
		$this->assertArrayNotHasKey('DefaultRolePermission', Current::$current);
		$this->CurrentPage->setDefaultRolePermissions();

		//チェック
		$expected = $this->__assertData('room_administrator');

		$this->assertEquals(Current::$current, $expected);
	}

/**
 * DefaultRolePermissionが既に存在しているテスト
 *
 * @return void
 */
	public function testExistsData() {
		//テスト実施
		Current::$current['RolesRoom']['role_key'] = 'room_administrator';
		Current::$current['DefaultRolePermission'] = array(
			'page_editable' => array(
				'id' => '1', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'page_editable', 'value' => true, 'fixed' => true,
			),
		);

		$this->CurrentPage->setDefaultRolePermissions();

		//チェック
		$expected = array(
			'RolesRoom' => array(
				'role_key' => 'room_administrator',
			),
			'DefaultRolePermission' => array(
				'page_editable' => array(
					'id' => '1', 'role_key' => 'room_administrator', 'type' => 'room_role',
					'permission' => 'page_editable', 'value' => true, 'fixed' => true,
				),
			)
		);

		$this->assertEquals(Current::$current, $expected);
	}

/**
 * DefaultRolePermissionが既に存在しているテスト
 *
 * @return void
 */
	public function testGroupCraetable() {
		//テスト実施
		Current::$current['RolesRoom']['role_key'] = 'room_administrator';
		$this->assertArrayNotHasKey('DefaultRolePermission', Current::$current);

		$this->CurrentPage->setDefaultRolePermissions();
		$this->CurrentPage->setDefaultRolePermissions('administrator', true);

		//チェック
		$expected = $this->__assertData('room_administrator');
		$expected = Hash::merge($expected, $this->__assertData('administrator'));
		$expected['Permission'] = array(
			'group_creatable' => array (
				'id' => '72',
				'role_key' => 'administrator',
				'type' => 'user_role',
				'permission' => 'group_creatable',
				'value' => true,
				'fixed' => false,
			),
		);

		$this->assertEquals(Current::$current, $expected);
	}

/**
 * DefaultRolePermissionが既に存在しているテスト
 *
 * @return void
 */
	public function testGroupCraetableWithPermission() {
		//テスト実施
		Current::$current['RolesRoom']['role_key'] = 'room_administrator';
		$this->assertArrayNotHasKey('DefaultRolePermission', Current::$current);

		$this->CurrentPage->setDefaultRolePermissions();
		Current::$current['Permission'] = array(
			'page_editable' => array(
				'id' => '1', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'page_editable', 'value' => true, 'fixed' => true,
			),
			'block_editable' => array(
				'id' => '2', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'block_editable', 'value' => true, 'fixed' => true,
			),
			'content_readable' => array(
				'id' => '3', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'content_readable', 'value' => true, 'fixed' => true,
			),
		);

		$this->CurrentPage->setDefaultRolePermissions('administrator', true);

		//チェック
		$expected = $this->__assertData('room_administrator');
		$expected = Hash::merge($expected, $this->__assertData('administrator'));
		$expected['Permission'] = array(
			'page_editable' => array(
				'id' => '1', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'page_editable', 'value' => true, 'fixed' => true,
			),
			'block_editable' => array(
				'id' => '2', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'block_editable', 'value' => true, 'fixed' => true,
			),
			'content_readable' => array(
				'id' => '3', 'role_key' => 'room_administrator', 'type' => 'room_role',
				'permission' => 'content_readable', 'value' => true, 'fixed' => true,
			),
			'group_creatable' => array (
				'id' => '72',
				'role_key' => 'administrator',
				'type' => 'user_role',
				'permission' => 'group_creatable',
				'value' => true,
				'fixed' => false,
			),
		);

		$this->assertEquals(Current::$current, $expected);
	}

/**
 * DefaultRolePermissionの期待値
 *
 * @param string $roleKey ロールキー
 * @return array
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	private function __assertData($roleKey) {
		Current::$current['DefaultRolePermission'] = Hash::remove(
			Current::$current['DefaultRolePermission'], '{s}.created'
		);
		Current::$current['DefaultRolePermission'] = Hash::remove(
			Current::$current['DefaultRolePermission'], '{s}.created_user'
		);
		Current::$current['DefaultRolePermission'] = Hash::remove(
			Current::$current['DefaultRolePermission'], '{s}.modified'
		);
		Current::$current['DefaultRolePermission'] = Hash::remove(
			Current::$current['DefaultRolePermission'], '{s}.modified_user'
		);
		if (isset(Current::$current['Permission'])) {
			Current::$current['Permission'] = Hash::remove(
				Current::$current['Permission'], '{s}.created'
			);
			Current::$current['Permission'] = Hash::remove(
				Current::$current['Permission'], '{s}.created_user'
			);
			Current::$current['Permission'] = Hash::remove(
				Current::$current['Permission'], '{s}.modified'
			);
			Current::$current['Permission'] = Hash::remove(
				Current::$current['Permission'], '{s}.modified_user'
			);
		}

		$result = array();
		if ($roleKey === 'administrator') {
			$result = array(
				'DefaultRolePermission' => array (
					'group_creatable' => array (
						'id' => '72',
						'role_key' => 'administrator',
						'type' => 'user_role',
						'permission' => 'group_creatable',
						'value' => true,
						'fixed' => false,
					),
				),
			);
		} elseif ($roleKey === 'visitor') {
			$result = array(
				'DefaultRolePermission' => array(
					'page_editable' => array(
						'id' => '41', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'page_editable', 'value' => false, 'fixed' => true,
					),
					'block_editable' => array(
						'id' => '42', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'block_editable', 'value' => false, 'fixed' => true,
					),
					'content_readable' => array(
						'id' => '43', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_readable', 'value' => true, 'fixed' => true,
					),
					'content_creatable' => array(
						'id' => '44', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_creatable', 'value' => false, 'fixed' => true,
					),
					'content_editable' => array(
						'id' => '45', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_editable', 'value' => false, 'fixed' => true,
					),
					'content_publishable' => array(
						'id' => '46', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_publishable', 'value' => false, 'fixed' => true,
					),
					'content_comment_creatable' => array(
						'id' => '47', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_comment_creatable', 'value' => false, 'fixed' => false,
					),
					'content_comment_editable' => array(
						'id' => '48', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_comment_editable', 'value' => false, 'fixed' => true,
					),
					'content_comment_publishable' => array(
						'id' => '49', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'content_comment_publishable', 'value' => false, 'fixed' => true,
					),
					'block_permission_editable' => array(
						'id' => '50', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'block_permission_editable', 'value' => false, 'fixed' => true,
					),
					'html_not_limited' => array(
						'id' => '55', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'html_not_limited', 'value' => false, 'fixed' => true,
					),
					'mail_content_receivable' => array(
						'id' => '60', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'mail_content_receivable', 'value' => false, 'fixed' => false,
					),
					'mail_answer_receivable' => array(
						'id' => '65', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'mail_answer_receivable', 'value' => false, 'fixed' => true,
					),
					'mail_editable' => array(
						'id' => '70', 'role_key' => 'visitor', 'type' => 'room_role',
						'permission' => 'mail_editable', 'value' => false, 'fixed' => true,
					),
				),
			);
		} elseif ($roleKey === 'room_administrator') {
			$result = array(
				'RolesRoom' => array(
					'role_key' => 'room_administrator',
				),
				'DefaultRolePermission' => array(
					'page_editable' => array(
						'id' => '1', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'page_editable', 'value' => true, 'fixed' => true,
					),
					'block_editable' => array(
						'id' => '2', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'block_editable', 'value' => true, 'fixed' => true,
					),
					'content_readable' => array(
						'id' => '3', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_readable', 'value' => true, 'fixed' => true,
					),
					'content_creatable' => array(
						'id' => '4', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_creatable', 'value' => true, 'fixed' => true,
					),
					'content_editable' => array(
						'id' => '5', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_editable', 'value' => true, 'fixed' => true,
					),
					'content_publishable' => array(
						'id' => '6', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_publishable', 'value' => true, 'fixed' => true,
					),
					'content_comment_creatable' => array(
						'id' => '7', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_comment_creatable', 'value' => true, 'fixed' => true,
					),
					'content_comment_editable' => array(
						'id' => '8', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_comment_editable', 'value' => true, 'fixed' => true,
					),
					'content_comment_publishable' => array(
						'id' => '9', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'content_comment_publishable', 'value' => true, 'fixed' => true,
					),
					'block_permission_editable' => array(
						'id' => '10', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'block_permission_editable', 'value' => true, 'fixed' => true,
					),
					'html_not_limited' => array(
						'id' => '51', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'html_not_limited', 'value' => false, 'fixed' => false,
					),
					'mail_content_receivable' => array(
						'id' => '56', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'mail_content_receivable', 'value' => true, 'fixed' => true,
					),
					'mail_answer_receivable' => array(
						'id' => '61', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'mail_answer_receivable', 'value' => true, 'fixed' => true,
					),
					'mail_editable' => array(
						'id' => '66', 'role_key' => 'room_administrator', 'type' => 'room_role',
						'permission' => 'mail_editable', 'value' => true, 'fixed' => true,
					),
				),
			);
		}

		return $result;
	}

}
