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
 * Data provider
 *
 * @return array
 */
	public function dataProvider() {
		$rooms = [
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

		$blocks  = [
			'exists' => [
				'Block' => [
					'key' => 'dummy'
				]
			],
			'not exists' => [
				'Block' => [
				]
			],
		];

		$blockSettings  = [
			'use both' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '1',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '1',
				],
			],
			'use comment only' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '1',
				],
			],
			'unuse both' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
					BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL => '0',
				],
			],
			'use content and comment is null' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '1',
				],
			],
			'unuse content and comment is null' => [
				'BlockSetting' => [
					BlockSettingBehavior::FIELD_USE_WORKFLOW => '0',
				],
			],
			'both are null' => [
				'BlockSetting' => [
				],
			],
		];

		$rolePermissions  = [
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
				],
				'BlockPermission' => [
					'content_comment_publishable' => [
						'value' => true,
					],
				]
			],
		];

		$expectedData = [
			'both are true' => [
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
			'both are fale' => [
				'content_publishable' => [
					'value' => false,
				],
				'content_comment_publishable' => [
					'value' => false,
				],
			],
		];

		/*
		$data = [
			array_merge(
				$rooms['approval is required'],
				$blockSettings['use both'],
				$rolePermissions['room_administrator'],
				$expectedData['both are true']
			),
			array_merge(
				$rooms['approval is required'],
				$blockSettings['use both'],
				$rolePermissions['room_administrator'],
				$expectedData['both are true']
			),
		];
		*/
		foreach ($rooms as $roomDataName => $room) {
			$dataName = $roomDataName;
			foreach ($blocks as $blockDataName => $block) {
				$dataName .= ',' . $blockDataName;
				foreach ($blockSettings as $blockSettingDataName => $blockSetting) {
					$dataName .= ',' . $blockSettingDataName;
					foreach ($rolePermissions as $roleKey => $rolePermission) {
						$dataName .= ',' . $roleKey;
						$data[$dataName] = [
							$room + $block + $blockSetting + $rolePermission,
							$expectedData['both are true']
						];
					}
				}
			}
		}

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
