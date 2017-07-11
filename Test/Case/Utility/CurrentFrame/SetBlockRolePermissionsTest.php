<?php
/**
 * SetBlockRolePermissionsTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsTest
 *
 */
class SetBlockRolePermissionsTest extends SetBlockRolePermissionsTestBase {

/**
 * testBlockRolePermissionCurrentDataIsAlreadyExists method
 *
 * @return void
 */
	public function testBlockRolePermissionCurrentDataIsAlreadyExists() {
		Current::$current['BlockRolePermission'] = ['dummy'];

		$this->CurrentFrame->setBlockRolePermissions();
		$actual = Current::read('Permission');

		$this->assertNull($actual);
	}

/**
 * testBlockRolePermissionCurrentDataIsAlreadyExists method
 *
 * @return void
 */
	public function testNotCallBlockRolePermissionFindMethod() {
		$this->MockBlockRPermission
			->expects($this->once())
			->method('find');

		$this->CurrentFrame->setBlockRolePermissions();

		Current::$current = [];
		Current::$current['RolesRoom']['id'] = 'dummy';
		$this->CurrentFrame->setBlockRolePermissions();

		Current::$current = [];
		Current::$current['Block']['key'] = 'dummy';
		$this->CurrentFrame->setBlockRolePermissions();

		Current::$current = [];
		Current::$current['RolesRoom']['id'] = 'dummy';
		Current::$current['Block']['key'] = 'dummy';
		$this->CurrentFrame->setBlockRolePermissions();
	}

}
