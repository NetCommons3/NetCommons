<?php
/**
 * SetBlockRolePermissionsChiefEditorTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsChiefEditorTest
 *
 */
class SetBlockRolePermissionsChiefEditorTest extends SetBlockRolePermissionsTestBase {

/**
 * chief_editor data provider
 *
 * @return array
 */
	public function chiefEditorProvider() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForChiefEditor();
		$expectedData = $this->_getExpectedData();

		// chief_editor content true のデータ
		$rolePermission = $rolePermissionData['chief_editor content true'];
		foreach ($roomData as $roomDataName => $room) {
			foreach ($blockData as $blockDataName => $block) {
				foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
					$dataName = $roomDataName . ',' .
						$blockDataName . ',' .
						$blockSettingDataName . ',' .
						'chief_editor content true';
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						$expectedData['both true']
					];
				}
			}
		}

		// Room approval is required,chief_editor content false のデータ
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissionData['chief_editor content false'];
		foreach ($blockData as $blockDataName => $block) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName = 'Room approval is required,' .
					$blockDataName . ',' .
					$blockSettingDataName . ',' .
					'chief_editor content false';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['comment true only']
				];
			}
		}

		// Room approval is not required,Block exists,BlockSetting use both,chief_editor content false のデータ
		// Room approval is not required,Block exists,BlockSetting use content and comment is null,chief_editor content false のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSettings = [
			'BlockSetting use both' => $blockSettingData['BlockSetting use both'],
			'BlockSetting use content and comment is null' => $blockSettingData['BlockSetting use content and comment is null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'chief_editor content false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use comment only,chief_editor content false のデータ
		// Room approval is not required,Block exists,BlockSetting unuse both,chief_editor content false のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,chief_editor content false のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,chief_editor content false のデータ
		$blockSettings = [
			'BlockSetting use comment only' => $blockSettingData['BlockSetting use comment only'],
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'chief_editor content false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both true']
			];
		}

		// Room approval is not required,Block not exists,chief_editor content false のデータ
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is not required,' .
				'Block not exists,' .
				$blockSettingDataName . ',' .
				'chief_editor content false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both true']
			];
		}

		return $data;
	}

/**
 * testChiefEditor method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider chiefEditorProvider
 * @return void
 */
	public function testChiefEditor($data, $expected) {
		Current::$current = $data;
		$this->_setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
	}

}
