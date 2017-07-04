<?php
/**
 * SetBlockRolePermissionsGeneralUserTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsGeneralUserTest
 *
 */
class SetBlockRolePermissionsGeneralUserTest extends SetBlockRolePermissionsTestBase {

/**
 * general_user data provider
 *
 * @return array
 */
	public function generalUserProvider() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForGeneralUser();
		$expectedData = $this->_getExpectedData();

		// Room approval is required,general_user のデータ
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissionData['general_user'];
		foreach ($blockData as $blockDataName => $block) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName = 'Room approval is required,' .
					$blockDataName . ',' .
					$blockSettingDataName . ',' .
					'general_user';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both false']
				];
			}
		}

		// Room approval is not required,Block not exists,general_user のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is not required,' .
				'Block not exists,' .
				$blockSettingDataName . ',' .
				'general_user';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both true']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use both,general_user のデータ
		$block = $blockData['Block exists'];
		$blockSetting = $blockSettingData['BlockSetting use both'];
		$dataName = 'Room approval is not required,' .
			'Block exists,' .
			'BlockSetting use both,' .
			'general_user';
		$data[$dataName] = [
			$room + $block + $blockSetting + $rolePermission,
			$expectedData['both false']
		];

		// Room approval is not required,Block exists,BlockSetting use content and comment is null,general_user のデータ
		$blockSetting = $blockSettingData['BlockSetting use content and comment is null'];
		$dataName = 'Room approval is not required,' .
			'Block exists,' .
			'BlockSetting use content and comment is null,' .
			'general_user';
		$data[$dataName] = [
			$room + $block + $blockSetting + $rolePermission,
			$expectedData['comment true only']
		];

		// Room approval is not required,Block exists,BlockSetting use comment only,general_user のデータ
		$blockSetting = $blockSettingData['BlockSetting use comment only'];
		$dataName = 'Room approval is not required,' .
			'Block exists,' .
			'BlockSetting use comment only,' .
			'general_user';
		$data[$dataName] = [
			$room + $block + $blockSetting + $rolePermission,
			$expectedData['content true only']
		];

		// Room approval is not required,Block exists,BlockSetting unuse both,general_user のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,general_user のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,general_user のデータ
		$blockSettings = [
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'general_user';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both true']
			];
		}

		return $data;
	}

/**
 * testGeneralUser method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider generalUserProvider
 * @return void
 */
	public function testGeneralUser($data, $expected) {
		Current::$current = $data;
		$this->_setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
	}

}
