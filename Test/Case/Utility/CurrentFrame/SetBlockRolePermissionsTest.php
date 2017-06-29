<?php
/**
 * NetCommonsUtilityCurrentFrameSetBlockRolePermissionsTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Current', 'NetCommons.Utility');
App::uses('CurrentFrame', 'NetCommons.Utility');

/**
 * NetCommonsUtilityCurrentFrameSetBlockRolePermissionsTest
 *
 */
class NetCommonsUtilityCurrentFrameSetBlockRolePermissionsTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CurrentFrame = new CurrentFrame();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Current::$current = [];
	}

/**
 * testBlockRolePermissionCurrentDataIsAlreadyExists method
 *
 * @return void
 */
	public function testBlockRolePermissionCurrentDataIsAlreadyExists() {
		Current::$current['BlockRolePermission'] = ['dummy'];
		$this->assertNull($this->CurrentFrame->setBlockRolePermissions());
	}

}
