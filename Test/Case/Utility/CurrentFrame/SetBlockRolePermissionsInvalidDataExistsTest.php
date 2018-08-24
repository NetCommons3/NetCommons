<?php
/**
 * SetBlockRolePermissionsInvalidDataExistsTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsInvalidDataExistsTest
 *
 */
class SetBlockRolePermissionsInvalidDataExistsTest extends SetBlockRolePermissionsTestBase {

/**
 * Get RolePermission test data for general_user
 *
 * @return array
 */
	private function __getRolePermissionTestDataForInvalid() {
		return [
			'BlockRolePermission content_publishable true with same value as RoomRolePermission' => [
				'RolesRoom' => [
					'id' => '1',
				],
				'DefaultRolePermission' => [
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
				],
				'BlockRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
				]
			],
			'BlockRolePermission content_publishable true with different from RoomRolePermission' => [
				'RolesRoom' => [
					'id' => '2',
				],
				'DefaultRolePermission' => [
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
				]
			],
			'BlockRolePermission content_publishable false with different from RoomRolePermission' => [
				'RolesRoom' => [
					'id' => '3',
				],
				'DefaultRolePermission' => [
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
				],
				'BlockRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
				]
			],
			'BlockRolePermission content_publishable false with same value as RoomRolePermission' => [
				'RolesRoom' => [
					'id' => '4',
				],
				'DefaultRolePermission' => [
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
				]
			],
		];
	}

/**
 * invalid data provider block not exists
 *
 * @return array
 */
	public function blockNotExistsProvider() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestDataForInvalid();

		// Block not exists,RoomRolePermission content_publishable true のデータ
		$rolePermissions = [
			'BlockRolePermission content_publishable true with same value as RoomRolePermission' =>
				$rolePermissionData['BlockRolePermission content_publishable true with same value as RoomRolePermission'],
			'BlockRolePermission content_publishable false with different from RoomRolePermission' =>
				$rolePermissionData['BlockRolePermission content_publishable false with different from RoomRolePermission'],
		];
		$block = $blockData['Block not exists'];
		foreach ($roomData as $roomDataName => $room) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
					$dataName = $roomDataName . ',' .
						'Block not exists,' .
						$blockSettingDataName . ',' .
						$rPermissionDataName;
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						true
					];
				}
			}
		}

		// Room approval is required,Block not exists,RoomRolePermission content_publishable false のデータ
		$room = $roomData['Room approval is required'];
		$rolePermissions = [
			'BlockRolePermission content_publishable false with same value as RoomRolePermission' =>
				$rolePermissionData['BlockRolePermission content_publishable false with same value as RoomRolePermission'],
			'BlockRolePermission content_publishable true with different from RoomRolePermission' =>
				$rolePermissionData['BlockRolePermission content_publishable true with different from RoomRolePermission'],
		];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is required,' .
					'Block not exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					false
				];
			}
		}

		// Room approval is not required,Block not exists,RoomRolePermission content_publishable false のデータ
		$room = $roomData['Room approval is not required'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
				$dataName = 'Room approval is not required,' .
					'Block not exists,' .
					$blockSettingDataName . ',' .
					$rPermissionDataName;
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					true
				];
			}
		}

		return $data;
	}

/**
 * invalid data provider block exists
 *
 * @return array
 */
	public function blockExistsProvider() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestDataForInvalid();

		// Block not exists のデータ
		$block = $blockData['Block exists'];
		foreach ($roomData as $roomDataName => $room) {
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				foreach ($rolePermissionData as $rPermissionDataName => $rolePermission) {
					$dataName = $roomDataName . ',' .
						'Block exists,' .
						$blockSettingDataName . ',' .
						$rPermissionDataName;
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission
					];
				}
			}
		}

		return $data;
	}

/**
 * testGeneralUser method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider blockNotExistsProvider
 * @return void
 */
	public function testInvalidDataBlockNotExists($data, $expected) {
		Current::$current = $data;
		$this->_setMockBlockSetting($data);
		$this->_setMockBlockRolePermission($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']['content_publishable']['value']);
	}

/**
 * testGeneralUser method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider blockExistsProvider
 * @return void
 */
	public function testInvalidDataBlockExists($data) {
		$this->setExpectedException('InternalErrorException');

		Current::$current = $data;
		$this->_setMockBlockRolePermission($data);

		$this->CurrentFrame->setBlockRolePermissions();
	}

}
