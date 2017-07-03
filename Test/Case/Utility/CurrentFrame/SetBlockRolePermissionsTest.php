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
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * NetCommonsUtilityCurrentFrameSetBlockRolePermissionsTest
 *
 */
class NetCommonsUtilityCurrentFrameSetBlockRolePermissionsTest extends CakeTestCase {

/**
 * CurrentFrame
 *
 * @var CurrentFrame
 */
	public $CurrentFrame = null;

/**
 * MockBlockRolePermission
 *
 * @var PHPUnit_Framework_MockObject_MockObject
 */
	public $MockBlockRolePermission = null;

/**
 * MockBlockSetting
 *
 * @var PHPUnit_Framework_MockObject_MockObject
 */
	public $MockBlockSetting = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CurrentFrame = new CurrentFrame();
		$this->MockBlockRolePermission = $this->getMockForModel('Blocks.BlockRolePermission', ['find']);
		$this->MockBlockSetting = $this->getMockForModel('Blocks.BlockSetting', ['find']);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Current::$current = [];
		unset(
			$this->CurrentFrame,
			$this->MockBlockRolePermission,
			$this->MockBlockSetting
		);
	}

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
		$this->MockBlockRolePermission
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

/**
 * Get Room test data
 *
 * @return array
 */
	private function __getRoomTestData() {
		return [
			'Room approval is required' => [
				'Room' => [
					'need_approval' => '1'
				]
			],
			'Room approval is not required' => [
				'Room' => [
						'need_approval' => '0'
				]
			],
		];
	}

/**
 * Get Block test data
 *
 * @return array
 */
	private function __getBlockTestData() {
		return [
			'Block exists' => [
				'Block' => [
					'key' => 'dummy'
				]
			],
			'Block not exists' => [
				'Block' => [
				]
			],
		];
	}

/**
 * Get Block test data
 *
 * @return array
 */
	private function __getBlockSettingTestData() {
		return [
			'BlockSetting use both' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '1',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '1',
				],
			],
			'BlockSetting use comment only' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '1',
				],
			],
			'BlockSetting unuse both' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '0',
				],
			],
			'BlockSetting use content and comment is null' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '1',
				],
			],
			'BlockSetting unuse content and comment is null' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
				],
			],
			'BlockSetting both are null' => [
				'BlockSetting' => [
				],
			],
		];
	}

/**
 * Get RolePermission test data
 *
 * @return array
 */
	private function __getRolePermissionTestData() {
		return [
			'room_administrator' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],

			'chief_editor content true' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],
			'chief_editor content false' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],

			'editor both true' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],
			'editor content true only' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'value' => false,
					],
				]
			],
			'editor comment true only' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],
			'editor both false' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'value' => false,
					],
				]
			],
			'editor content true and comment is null' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => true,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
			],
			'editor content false and comment is null' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'value' => false,
					],
					'content_comment_publishable' => [
						'value' => false,
					],
				],
			],

		];
	}

/**
 * Get expected data
 *
 * @return array
 */
	private function __getExpectedData() {
		return [
			'both true' => [
				'content_publishable' => [
					'value' => true,
				],
				'content_comment_publishable' => [
					'value' => true,
				],
			],
			'content true only' => [
				'content_publishable' => [
					'value' => true,
				],
				'content_comment_publishable' => [
					'value' => false,
				],
			],
			'comment true only' => [
				'content_publishable' => [
					'value' => false,
				],
				'content_comment_publishable' => [
					'value' => true,
				],
			],
			'both fale' => [
				'content_publishable' => [
					'value' => false,
				],
				'content_comment_publishable' => [
					'value' => false,
				],
			],
		];
	}

/**
 * Get room_administrator data
 *
 * @return array
 */
	private function __getRoomAdministratorDataForDataProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

		// Role.key:room_administrator のデータ
		$rolePermission = $rolePermissionData['room_administrator'];
		foreach ($roomData as $roomDataName => $room) {
			$dataName = $roomDataName;
			foreach ($blockData as $blockDataName => $block) {
				$dataName .= ',' . $blockDataName;
				foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
					$dataName .= ',' . $blockSettingDataName . ',room_administrator';
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
 * Get chief_editor data
 *
 * @return array
 */
	private function __getChiefEditorDataForDataProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

		// chief_editor content true のデータ
		$rolePermission = $rolePermissionData['chief_editor content true'];
		foreach ($roomData as $roomDataName => $room) {
			$dataName = $roomDataName;
			foreach ($blockData as $blockDataName => $block) {
				$dataName .= ',' . $blockDataName;
				foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
					$dataName .= ',' . $blockSettingDataName . ',chief_editor content true';
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
			$dataName .= 'Room approval is required,' . $blockDataName;
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName .= ',' . $blockSettingDataName . ',chief_editor content false';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['comment true only']
				];
			}
		}

		// Room approval is not required,Block exists,chief_editor content false のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSettings = [
			'BlockSetting use both' => $blockSettingData['BlockSetting use both'],
			'BlockSetting use content and comment is null' => $blockSettingData['BlockSetting use content and comment is null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName .= 'Room approval is not required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'chief_editor content false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is not required,Block not exists,chief_editor content false のデータ
		$block = $blockData['Block not exists'];
		$blockSettings = [
			'BlockSetting use comment only' => $blockSettingData['BlockSetting use comment only'],
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName .= 'Room approval is not required,' .
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
 * Get editor data
 *
 * @return array
 */
	private function __getEditorDataForDataProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

		// editor both true のデータ
		// editor content true and comment is null のデータ
		$rolePermissions = [
			'editor content true only' => $rolePermissionData['editor content true only'],
			'editor content true and comment is null' => $rolePermissionData['editor content true and comment is null']
		];
		foreach ($roomData as $roomDataName => $room) {
			$dataName = $roomDataName;
			foreach ($blockData as $blockDataName => $block) {
				$dataName .= ',' . $blockDataName;
				foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
					$dataName .= ',' . $blockSettingDataName;
					foreach ($rolePermissions as $rPermissionDataName => $rolePermission) {
						$dataName .= ',' . $rPermissionDataName;
						$data[$dataName] = [
							$room + $block + $blockSetting + $rolePermission,
							$expectedData['both true']
						];
					}
				}
			}
		}

		// Room approval is required,editor content true only のデータ
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissions['editor content true only'];
		foreach ($blockData as $blockDataName => $block) {
			$dataName .= 'Room approval is required,' . $blockDataName;
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName .= ',' . $blockSettingDataName . ',editor content true only';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['content true only']
				];
			}
		}

		// Room approval is required,editor comment true only のデータ
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissionData['editor comment true only'];
		foreach ($blockData as $blockDataName => $block) {
			$dataName .= 'Room approval is required,' . $blockDataName;
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName .= ',' . $blockSettingDataName . ',editor comment true only';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['comment true only']
				];
			}
		}

		// Room approval is required,editor both false のデータ
		// Room approval is required,editor content false and comment is null のデータ
		$rolePermissions = [
				'editor content true only' => $rolePermissionData['editor content true only'],
				'editor content true and comment is null' => $rolePermissionData['editor content true and comment is null']
		];
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissionData['editor both false'];
		foreach ($blockData as $blockDataName => $block) {
			$dataName .= 'Room approval is required,' . $blockDataName;
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName .= ',' . $blockSettingDataName . ',editor both false';
				$data[$dataName] = [
					$room + $block + $blockSetting + $rolePermission,
					$expectedData['both false']
				];
			}
		}

		// Room approval is required,editor content true and comment is null のデータ
		$room = $roomData['Room approval is required'];
		$rolePermission = $rolePermissionData['editor content true and comment is null'];
		foreach ($blockData as $blockDataName => $block) {
			$dataName .= 'Room approval is required,' . $blockDataName;
			foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
				$dataName .= ',' . $blockSettingDataName . ',editor both false';
				$data[$dataName] = [
						$room + $block + $blockSetting + $rolePermission,
						$expectedData['both false']
				];
			}
		}



		// Room approval is not required,Block exists,chief_editor content false のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSettings = [
			'BlockSetting use both' => $blockSettingData['BlockSetting use both'],
			'BlockSetting use content and comment is null' => $blockSettingData['BlockSetting use content and comment is null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName .= 'Room approval is not required,' .
				'Block exists,' .
				$blockSettingDataName . ',' .
				'chief_editor content false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['comment true only']
			];
		}

		// Room approval is not required,Block not exists,chief_editor content false のデータ
		$block = $blockData['Block not exists'];
		$blockSettings = [
			'BlockSetting use comment only' => $blockSettingData['BlockSetting use comment only'],
			'BlockSetting unuse both' => $blockSettingData['BlockSetting unuse both'],
			'BlockSetting unuse content and comment is null' => $blockSettingData['BlockSetting unuse content and comment is null'],
			'BlockSetting both are null' => $blockSettingData['BlockSetting both are null'],
		];
		foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
			$dataName .= 'Room approval is not required,' .
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
 * Data provider
 *
 * @return array
 */
	public function dataProvider() {
		$data = [];

		$data += $this->__getRoomAdministratorDataForDataProvider();	// Role.key:room_administrator のデータ
		$data += $this->__getChiefEditorDataForDataProvider();			// Role.key:chief_editor のデータ

		return $data;
	}

/**
 * testRoomAdministrator method
 *
 * @dataProvider dataProvider
 * @return void
 */
	public function testRoomAdministrator($data, $expected) {
		Current::$current = $data;
		$this->__setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
	}

/**
 * Set MockBlockSetting
 *
 * @return void
 */
	private function __setMockBlockSetting($data) {
		if (Current::read('Room.need_approval') ||
			!isset(Current::$current['Block']['key'])
		) {
			$this->MockBlockSetting
				->expects($this->never())
				->method('find');

			return;
		}

		$this->MockBlockSetting
			->expects($this->once())
			->method('find')
			->with(
				'list',
				[
					'recursive' => -1,
					'fields' => ['field_name', 'value'],
					'conditions' => [
						'block_key' => Current::$current['Block']['key'],
						'field_name' => [
							BlockSettingBehavior::FIELD_USE_WORKFLOW,
							BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL
						],
					],
				]
			)
			->will($this->returnValue($data['BlockSetting']));
	}

}
