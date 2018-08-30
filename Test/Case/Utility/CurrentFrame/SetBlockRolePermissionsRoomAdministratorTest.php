<?php
/**
 * SetBlockRolePermissionsRoomAdministratorTest
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SetBlockRolePermissionsTestBase', 'NetCommons.Test/Case/Utility/CurrentFrame');

/**
 * SetBlockRolePermissionsRoomAdministratorTest
 *
 */
class SetBlockRolePermissionsRoomAdministratorTest extends SetBlockRolePermissionsTestBase {

/**
 * Get RolePermission test data for room_administrator
 *
 * @return array
 */
	private function __getRolePermissionTestDataForRoomAdministrator() {
		return [
			'room_administrator' => [
				'RolesRoom' => [
					'id' => '1',
				],
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => true,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => true,
					],
				]
			]
		];
	}

/**
 * room_administrator data provider
 *
 * @return array
 */
	public function roomAdministratorProvider() {
		$data = [];
		$roomData = $this->_getRoomTestData();
		$blockData = $this->_getBlockTestData();
		$blockSettingData = $this->_getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestDataForRoomAdministrator();
		$expectedData = $this->_getExpectedData();

		// Role.key:room_administrator のデータ
		$rolePermission = $rolePermissionData['room_administrator'];
		foreach ($roomData as $roomDataName => $room) {
			foreach ($blockData as $blockDataName => $block) {
				foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
					$dataName = $roomDataName . ',' .
						$blockDataName . ',' .
						$blockSettingDataName . ',' .
						'room_administrator';
					$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						$expectedData['both true']
					];
				}
			}
		}

		return $data;
	}

/**
 * testRoomAdministrator method
 *
 * @param array $data test data
 * @param array $expected permission data
 * @dataProvider roomAdministratorProvider
 * @return void
 */
	public function testRoomAdministrator($data, $expected) {
		Current::$current = $data;
		$this->CurrentFrame->reset();
		$this->_setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$assert = [];
		foreach (Current::$current['Permission'] as $key => $value) {
			$assert[$key]['permission'] = $value['permission'];
			$assert[$key]['value'] = $value['value'];
		}

		$this->assertEquals($expected, $assert);
	}

}
