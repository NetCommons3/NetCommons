<?php
/**
 * CurrentFrame Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CurrentFrame Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentFrame {

/**
 * Constant Plugin value
 */
	const PLUGIN_PAGES = 'pages';

/**
 * Request object
 *
 * @var mixed
 */
	private static $__request;

/**
 * Instance object
 *
 * @var mixed
 */
	private static $__instance;

/**
 * setup current data
 *
 * @param CakeRequest $request CakeRequest
 * @return void
 */
	public static function initialize(CakeRequest $request) {
		if (! self::$__instance) {
			self::$__instance = new CurrentFrame();
		}

		self::$__request = $request;

		if (isset(Current::$current['Frame'])) {
			unset(Current::$current['Frame']);
		}
		if (isset(Current::$current['Block'])) {
			unset(Current::$current['Block']);
		}
		if (isset(Current::$current['BlockRolePermission'])) {
			unset(Current::$current['BlockRolePermission']);
		}
		if (self::$__request->params['plugin'] !== self::PLUGIN_PAGES) {
			self::$__instance->setFrame();
			self::$__instance->setBlock();
		}

		CurrentPage::initialize(self::$__request);

		self::$__instance->setBlockRolePermissions();
	}

/**
 * Set Frame
 *
 * @return void
 */
	public function setFrame() {
		if (isset(self::$__request->data['Frame']) && isset(self::$__request->data['Frame']['id'])) {
			$frameId = self::$__request->data['Frame']['id'];
		} elseif (isset(self::$__request->query['frame_id'])) {
			$frameId = self::$__request->query['frame_id'];
		}

		self::$__instance->Frame = ClassRegistry::init('Frames.Frame');
		self::$__instance->Box = ClassRegistry::init('Boxes.Box');

		if (isset($frameId)) {
			$result = self::$__instance->Frame->findById($frameId);
			Current::$current = Hash::merge(Current::$current, $result);
			if (isset(Current::$current['Page'])) {
				return;
			}
		}

		self::$__instance->setPageByBox();
	}

/**
 * Set PageByBox
 *
 * @return void
 */
	public function setPageByBox() {
		if (isset(Current::$current['Box']['id'])) {
			$boxId = Current::$current['Box']['id'];
		} elseif (isset(self::$__request->data['Frame']) && isset(self::$__request->data['Frame']['box_id'])) {
			$boxId = self::$__request->data['Frame']['box_id'];
		} elseif (isset(self::$__request->data['Box']) && isset(self::$__request->data['Box']['id'])) {
			$boxId = self::$__request->data['Box']['id'];
		} else {
			return;
		}

		$result = self::$__instance->Box->find('first', array(
			'conditions' => array(
				'Box.id' => $boxId,
			),
		));
		if (! $result) {
			return;
		}
		Current::$current['Page'] = $result['Page'][0];

		if (! isset(Current::$current['Room'])) {
			Current::$current['Room'] = $result['Room'];
		}
	}

/**
 * Set Block
 *
 * @param int $blockId Blocks.id
 * @return void
 */
	public static function setBlock($blockId = null) {
		self::$__instance->Block = ClassRegistry::init('Blocks.Block');

		if (isset(self::$__request->data['Block']['id']) && self::$__request->data['Block']['id']) {
			$blockId = self::$__request->data['Block']['id'];
		} elseif (isset($blockId)) {
			//何もしない
		} elseif (isset(self::$__request->params['pass'][0])) {
			$blockId = self::$__request->params['pass'][0];
		} else {
			return;
		}

		$result = self::$__instance->Block->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'Block.id' => $blockId,
			),
		));
		if ($result) {
			Current::$current = Hash::merge(Current::$current, $result);
			return;
		}

		if (isset(Current::$current['Frame']['block_id'])) {
			$result = self::$__instance->Block->find('first', array(
				'recursive' => 0,
				'conditions' => array(
					'Block.id' => Current::$current['Frame']['block_id'],
				),
			));
			if ($result) {
				Current::$current = Hash::merge(Current::$current, $result);
			}
		}
	}

/**
 * Set BlockRolePermissions
 *
 * @return void
 */
	public function setBlockRolePermissions() {
		self::$__instance->BlockRolePermission = ClassRegistry::init('Blocks.BlockRolePermission');

		if (isset(Current::$current['BlockRolePermission'])) {
			return;
		}

		if (isset(Current::$current['RolesRoom']) && isset(Current::$current['Block']['key'])) {
			$result = self::$__instance->BlockRolePermission->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'roles_room_id' => Current::$current['RolesRoom']['id'],
					'block_key' => Current::$current['Block']['key'],
				)
			));
			if ($result) {
				Current::$current['BlockRolePermission'] = Hash::combine($result, '{n}.BlockRolePermission.permission', '{n}.BlockRolePermission');
			}
		}

		$permission = array();
		if (isset(Current::$current['DefaultRolePermission'])) {
			$permission = Hash::merge($permission, Current::$current['DefaultRolePermission']);
		}
		if (isset(Current::$current['RoomRolePermission'])) {
			$permission = Hash::merge($permission, Current::$current['RoomRolePermission']);
		}
		if (isset(Current::$current['BlockRolePermission'])) {
			$permission = Hash::merge($permission, Current::$current['BlockRolePermission']);
		}

		Current::$current['Permission'] = $permission;
	}

}
