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
			],

			'chief_editor content true' => [
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
			],
			'chief_editor content false' => [
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
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => true,
					],
				]
			],

			'editor both true' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => true,
					],
				]
			],
			'editor content true only' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				]
			],
			'editor comment true only' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => true,
					],
				]
			],
			'editor both false' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'BlockRolePermission' => [
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				]
			],
			'editor content true and comment is null' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => true,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
			],
			'editor content false and comment is null' => [
				'DefaultRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
						'value' => false,
					],
				],
				'RoomRolePermission' => [
					'content_publishable' => [
						'permission' => 'content_publishable',
						'value' => false,
					],
					'content_comment_publishable' => [
						'permission' => 'content_comment_publishable',
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
					'permission' => 'content_publishable',
					'value' => true,
				],
				'content_comment_publishable' => [
					'permission' => 'content_comment_publishable',
					'value' => true,
				],
			],
			'content true only' => [
				'content_publishable' => [
					'permission' => 'content_publishable',
					'value' => true,
				],
				'content_comment_publishable' => [
					'permission' => 'content_comment_publishable',
					'value' => false,
				],
			],
			'comment true only' => [
				'content_publishable' => [
					'permission' => 'content_publishable',
					'value' => false,
				],
				'content_comment_publishable' => [
					'permission' => 'content_comment_publishable',
					'value' => true,
				],
			],
			'both false' => [
				'content_publishable' => [
					'permission' => 'content_publishable',
					'value' => false,
				],
				'content_comment_publishable' => [
					'permission' => 'content_comment_publishable',
					'value' => false,
				],
			],
		];
	}

/**
 * room_administrator data provider
 *
 * @return array
 */
	public function roomAdministratorProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

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
 * chief_editor data provider
 *
 * @return array
 */
	public function chiefEditorProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

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
 * editor data provider
 *
 * @return array
 */
	public function editorProvider() {
		$data = [];
		$roomData = $this->__getRoomTestData();
		$blockData = $this->__getBlockTestData();
		$blockSettingData = $this->__getBlockSettingTestData();
		$rolePermissionData = $this->__getRolePermissionTestData();
		$expectedData = $this->__getExpectedData();

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
		// Room approval is not required,Block exists,BlockSetting unuse both,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting unuse content and comment is null,editor content true only のデータ
		// Room approval is not required,Block exists,BlockSetting both are null,editor content true only のデータ
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

		// Room approval is not required,Block exists,BlockSetting use both,editor both false のデータ
		// Room approval is not required,Block exists,BlockSetting use both,editor content false and comment is null のデータ
		$room = $roomData['Room approval is not required'];
		$block = $blockData['Block exists'];
		$blockSetting = $blockSettingData['BlockSetting use both'];
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


		// Room approval is required,Block not exists,editor both false のデータ
/*		$room = $roomData['Room approval is required'];
		$block = $blockData['Block not exists'];
		foreach ($blockSettingData as $blockSettingDataName => $blockSetting) {
			$dataName = 'Room approval is required,' .
				'Block not exists,' .
				$blockSettingDataName . ',' .
				'editor both false';
			$data[$dataName] = [
				$room + $block + $blockSetting + $rolePermission,
				$expectedData['content true only']
			];
		}*/



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
		$this->__setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
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
		$this->__setMockBlockSetting($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
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
		$this->__setMockBlockSetting($data);
		$this->__setMockBlockRolePermission($data);

		$this->CurrentFrame->setBlockRolePermissions();

		$this->assertEquals($expected, Current::$current['Permission']);
	}

/**
 * Set MockBlockSetting
 *
 * @param array $data test data
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

/**
 * Set MockBlockRolePermission
 *
 * @param array $data test data
 * @return void
 */
	private function __setMockBlockRolePermission($data) {
		unset(Current::$current['BlockRolePermission']);

		if (!isset(Current::$current['Block']['key'])) {
			$this->MockBlockRolePermission
				->expects($this->never())
				->method('find');

			return;
		}

		Current::$current['RolesRoom']['id'] = 'dummy';
		$blockRolePermissions = Hash::get($data, ['BlockRolePermission'], []);
		$value = [];
		foreach ($blockRolePermissions as $permission => $blockRolePermission) {
			$value[] = [
				'BlockRolePermission' => [
					'permission' =>	$permission,
					'value' => $blockRolePermission['value'],
				]
			];
		}
		$this->MockBlockRolePermission
			->expects($this->once())
			->method('find')
			->with(
				'all',
				[
					'recursive' => -1,
					'conditions' => [
						'roles_room_id' => Current::$current['RolesRoom']['id'],
						'block_key' => Current::$current['Block']['key'],
					],
				]
			)
			->will($this->returnValue($value));

	}

}
