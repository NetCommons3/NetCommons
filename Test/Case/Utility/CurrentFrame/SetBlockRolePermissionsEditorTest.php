<?php
/**
 * SetBlockRolePermissionsEditorTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsEditorTest
 *
 */
class SetBlockRolePermissionsEditorTest extends SetBlockRolePermissionsTestBase {

/**
 * editor data provider
 *
 * @return array
 */
	public function editorProvider() {
		$data = $this->__getRoomApprovalIsNotRequiredBlockNotExistsData() +
			$this->__getEditorBothTrueData() +
			$this->__getEditorContentTrueData() +
			$this->__getEditorCommentTrueData() +
			$this->__getRoomApprovalIsRequiredEditorContentFalseData() +
			$this->__getRoomApprovalIsNotRequiredEditorContentFalseData();

		return $data;
	}

/**
 * Get Room approval is not required,Block not exists data
 *
 * @return array
 */
	private function __getRoomApprovalIsNotRequiredBlockNotExistsData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Room approval is not required,Block not exists のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissionData as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is not required,' .
					'Block not exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both true']
				];
			}
		}

		return $data;
	}

/**
 * Get editor both true data
 *
 * @return array
 */
	private function __getEditorBothTrueData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Block exists,editor both true のデータ
		$block = $blockData['Block exists'];
		$rolePermission = $rolePermissionData['editor both true'];
		foreach ($roomData as $roomDataName => $room) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName = $roomDataName . ',' .
					'Block exists,' .
					$blockSettingDataName . ',' .
					'editor both true';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both true']
				];
			}
		}

		// Room approval is required,Block not exists,editor both true のデータ
		$room = $roomData['Room approval is required'];
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is required,' .
				'Block not exists,' .
				$blockSettingDataName . ',' .
				'editor both true';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['content true only']
			];
		}

		return $data;
	}

/**
 * Get editor content true data
 *
 * @return array
 */
	private function __getEditorContentTrueData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Room approval is required,editor content true only のデータ
		// Room approval is required,editor content true and comment is null のデータ
		$room = $roomData['Room approval is required'];
		$rolePermissions = [
			'editor content true only' => $rolePermissionData['editor content true only'],
			'editor content true and comment is null' => $rolePermissionData['editor content true and comment is null'],
		];
		foreach ($blockData as $blockDataName => $block) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
					$dataName = 'Room approval is required,' .
						$blockDataName . ',' .
						$blockSettingDataName . ',' .
						$rPermissionDataName;
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						$expectedData['content true only']
					];
				}
			}
		}

		// Room approval is not required,Block exists,BlockSetting use both,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting use comment only,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting use both,editor editor content true and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting use comment only,editor editor content true and comment is null のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSettings = [
			'BlockSetting use both' => $blockSettingData['BlockSetting use both'],
			'BlockSetting use comment only' => $blockSettingData['BlockSetting use comment only'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is not required,' .
					'Block exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['content true only']
				];
			}
		}

		// Room approval is not required,Block exists,BlockSetting unuse both,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting use content and comment is null,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting unuse both,editor editor content true and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting use content and comment is null,editor editor content true and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor editor content true and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor editor content true and comment is null のデータ
		$blockSettings = [
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting use content and comment is null' => $blockSettingData['BlockSetting use content and comment is null'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is not required,' .
					'Block exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both true']
				];
			}
		}

		return $data;
	}

/**
 * Get editor comment true data
 *
 * @return array
 */
	private function __getEditorCommentTrueData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Room approval is required,Block exists,editor comment true only のデータ
		$room = $roomData['Room approval is required'];
		$block = $blockData['Block exists'];
		$rolePermission = $rolePermissionData['editor comment true only'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'editor comment true only';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is required,Block not exists,editor comment true only のデータ
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is required,' .
				'Block not exists,' .
				$blockSettingDataName . ',' .
				'editor comment true only';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both false']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use both,editor comment true only のデータ
		// Room approval is not required,Block exists,BlockSetting use content and comment is null,editor comment true only のデータ
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
				'editor comment true only';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use comment only,editor comment true only のデータ
		// Room approval is not required,Block exists,BlockSetting unuse both,editor comment true only のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor comment true only のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor comment true only のデータ
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
				'editor comment true only';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both true']
			];
		}

		return $data;
	}

/**
 * Get Room approval is required,editor content false data
 *
 * @return array
 */
	private function __getRoomApprovalIsRequiredEditorContentFalseData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Room approval is required,editor both false のデータ
		// Room approval is required,editor content false and comment is null のデータ
		$room = $roomData['Room approval is required'];
		$rolePermissions = [
			'editor both false' => $rolePermissionData['editor both false'],
			'editor content false and comment is null' => $rolePermissionData['editor content false and comment is null'],
		];
		$rolePermission = $rolePermissionData['editor both false'];
		foreach ($blockData as $blockDataName => $block) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
					$dataName = 'Room approval is required,' .
						$blockDataName . ',' .
						$blockSettingDataName . ',' .
						$rPermissionDataName;
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						$expectedData['both false']
					];
				}
			}
		}

		return $data;
	}

/**
 * Get Room approval is not required,editor content false data
 *
 * @return array
 */
	private function __getRoomApprovalIsNotRequiredEditorContentFalseData() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->_getRolePermissionTestDataForEditor();
		$expectedData = $this->_getExpectedData();

		// Room approval is not required,Block exists,BlockSetting use both,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting use both,editor content false and comment is null のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSetting = $blockSettingData['BlockSetting use both'];
		$rolePermissions = [
			'editor both false' => $rolePermissionData['editor both false'],
			'editor content false and comment is null' => $rolePermissionData['editor content false and comment is null'],
		];
		foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				'BlockSetting use both,' .
				$rPermissionDataName;
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['both false']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use content and comment is null,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting use content and comment is null,editor content false and comment is null のデータ
		$blockSetting = $blockSettingData['BlockSetting use content and comment is null'];
		foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				'BlockSetting use content and comment is null,' .
				$rPermissionDataName;
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is not required,Block exists,BlockSetting use comment only,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting use comment only,editor content false and comment is null のデータ
		$blockSetting = $blockSettingData['BlockSetting use comment only'];
		foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
			$dataName = 'Room approval is not required,' .
				'Block exists,' .
				'BlockSetting use comment only,' .
				$rPermissionDataName;
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['content true only']
			];
		}

		// Room approval is not required,Block exists,BlockSetting unuse both,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting unuse both,editor content false and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor content false and comment is null のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor content false and comment is null のデータ
		$blockSettings = [
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is not required,' .
					'Block exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both true']
				];
			}
		}

		return $data;
	}

/**
 * testEditor method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider editorProvider
 * @return void
 */
	public function testEditor($data, $expected) {
		Current::$current = $data;
		$this->_setMockBlockSetting($data);
		$this->_setMockBlockRolePermission($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
	}

}
