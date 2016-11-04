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

App::uses('Container', 'Containers.Model');
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * CurrentFrame Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentFrame {

/**
 * 管理プラグイン以外でFrameチェックからスキップするプラグインリスト
 *
 * @var mixed
 */
	public static $skipFramePlugins = array(
		Current::PLUGIN_PAGES,
		Current::PLUGIN_USERS,
		Current::PLUGIN_WYSIWYG,
	);

/**
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		if (isset(Current::$current['Frame'])) {
			unset(Current::$current['Frame']);
		}
		if (isset(Current::$current['Block'])) {
			unset(Current::$current['Block']);
		}
		if (isset(Current::$current['BlockRolePermission'])) {
			unset(Current::$current['BlockRolePermission']);
		}
		if (isset(Current::$m17n['Frame'])) {
			unset(Current::$m17n['Frame']);
		}
		if (isset(Current::$m17n['Block'])) {
			unset(Current::$m17n['Block']);
		}

		if (!in_array(Current::$request->params['plugin'], self::$skipFramePlugins, true)) {
			$this->setFrame();
			$this->setBlock();
			$this->setM17n();
		}

		(new CurrentPage())->initialize();

		$this->setBlockRolePermissions();
	}

/**
 * Set Frame
 *
 * @param string $frameId フレームID
 * @return void
 */
	public function setFrame($frameId = null) {
		if ($frameId) {
			//何もしない
		} elseif (! Hash::get(Current::$request->params, 'requested') &&
					Hash::get(Current::$request->data, 'Frame.id')) {
			$frameId = Current::$request->data['Frame']['id'];
		} elseif (Hash::get(Current::$request->params, '?.frame_id')) {
			$frameId = Hash::get(Current::$request->params, '?.frame_id');
		} elseif (isset(Current::$request->query['frame_id'])) {
			$frameId = Current::$request->query['frame_id'];
		}

		$this->Frame = ClassRegistry::init('Frames.Frame');
		$this->Box = ClassRegistry::init('Boxes.Box');
		$this->Block = ClassRegistry::init('Blocks.Block');

		if (isset($frameId)) {
			$result = $this->Frame->findById($frameId);
			Current::$current = Hash::merge(Current::$current, $result);
		}

		//ブロック設定の新規の場合の処理
		if (Current::$layout === 'NetCommons.setting' &&
				Hash::get(Current::$request->params, 'action') === 'add') {
			Current::$current['Block'] = $this->Block->create()['Block'];
		}

		$this->setBox();
	}

/**
 * Set PageByBox
 *
 * @return void
 */
	public function setBox() {
		if (isset(Current::$current['Box']['id'])) {
			$boxId = Current::$current['Box']['id'];
		} elseif (isset(Current::$request->data['Frame']) &&
					isset(Current::$request->data['Frame']['box_id'])) {
			$boxId = Current::$request->data['Frame']['box_id'];
		} else {
			return;
		}

		$result = $this->Box->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Box.id' => $boxId,
			),
		));
		if (! $result) {
			return;
		}

		//Box、Room、Space更新
		Current::$current = Hash::merge(Current::$current, $result);

		$this->setBoxPageContainer();
	}

/**
 * Set BoxPageContainer
 *
 * @return void
 */
	public function setBoxPageContainer() {
		if (isset(Current::$current['BoxesPageContainer'])) {
			return;
		}

		if (! isset(Current::$current['Box']['id'])) {
			return;
		}
		if (isset(Current::$current['Page'])) {
			$pageId = Current::$current['Page']['id'];
		} elseif (! Current::$current['Box']['page_id']) {
			$pageId = Current::$current['Box']['page_id'];
		} else {
			return;
		}

		$this->BoxesPageContainer = ClassRegistry::init('Boxes.BoxesPageContainer');

		$result = $this->BoxesPageContainer->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'BoxesPageContainer.box_id' => Current::$current['Box']['id'],
				'BoxesPageContainer.page_id' => $pageId,
				'BoxesPageContainer.container_type' => Current::$current['Box']['container_type'],
			),
		));
		if (! $result) {
			return;
		}

		//BoxesPageContainer、Box、PageContainer、Page更新
		Current::$current = Hash::merge(Current::$current, $result);
	}

/**
 * Set Block
 *
 * ※PHPMのSuppressWarningsは暫定
 *
 * @param int $blockId Blocks.id
 * @return void
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function setBlock($blockId = null) {
		$this->Block = ClassRegistry::init('Blocks.Block');

		if (! Hash::get(Current::$request->params, 'requested') &&
					Hash::get(Current::$request->data, 'Block.id')) {
			$blockId = Current::$request->data['Block']['id'];
		} elseif (isset($blockId)) {
			//何もしない
		} elseif (isset(Current::$request->params['block_id'])) {
			$blockId = Current::$request->params['block_id'];
		} else {
			return;
		}

		$result = $this->Block->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'Block.id' => $blockId,
			),
		));
		if ($result) {
			Current::$current = Hash::merge(Current::$current, $result);
		}

		if (! isset(Current::$current['Frame'])) {
			$frame = $this->Frame->find('first', array(
				'fields' => array('id'),
				'recursive' => -1,
				'conditions' => array(
					'block_id' => $blockId,
					'is_deleted' => false
				),
				'order' => array('id' => 'asc')
			));

			$frameId = Hash::get($frame, 'Frame.id');
			if ($frameId) {
				$this->setFrame($frameId);
			}
		}

		if (! isset(Current::$current['Block']) && isset(Current::$current['Frame']['block_id'])) {
			$result = $this->Block->find('first', array(
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
		$this->BlockRolePermission = ClassRegistry::init('Blocks.BlockRolePermission');
		$this->BlockSetting = ClassRegistry::init('Blocks.BlockSetting');

		if (isset(Current::$current['BlockRolePermission'])) {
			return;
		}

		if (isset(Current::$current['RolesRoom']) && isset(Current::$current['Block']['key'])) {
			$result = $this->BlockRolePermission->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'roles_room_id' => Current::$current['RolesRoom']['id'],
					'block_key' => Current::$current['Block']['key'],
				)
			));
			if ($result) {
				Current::$current['BlockRolePermission'] = Hash::combine(
					$result, '{n}.BlockRolePermission.permission', '{n}.BlockRolePermission'
				);
			}
		}

		$permission = array();
		$permission = Hash::merge(
			$permission, Hash::get(Current::$current, 'DefaultRolePermission', array())
		);
		$permission = Hash::merge(
			$permission, Hash::get(Current::$current, 'RoomRolePermission', array())
		);
		if (isset(Current::$current['BlockRolePermission'])) {
			$permission = Hash::merge($permission, Current::$current['BlockRolePermission']);
		} elseif (! Current::read('Room.need_approval')) {
			$setPermissions = array(
				'content_publishable' => array('value' => true),
				'content_comment_publishable' => array('value' => true),
			);
			if (isset(Current::$current['Block']['key'])) {
				$blockSetting = $this->BlockSetting->find('list', array(
					'recursive' => -1,
					'fields' => array('field_name', 'value'),
					'conditions' => array(
						'block_key' => Current::$current['Block']['key'],
						'field_name' => array(
							BlockSettingBehavior::FIELD_USE_WORKFLOW,
							BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL
						),
					),
				));
				$setPermissions['content_publishable']['value'] = !(bool)Hash::get(
					$blockSetting, BlockSettingBehavior::FIELD_USE_WORKFLOW, '0'
				);
				$setPermissions['content_comment_publishable']['value'] = !(bool)Hash::get(
					$blockSetting, BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL, '0'
				);
			}
			$permission = Hash::merge($permission, $setPermissions);
		}

		Current::$current['Permission'] = $permission;
	}

/**
 * 多言語化のデータ取得
 *
 * @return void
 */
	public function setM17n() {
		if (isset(Current::$current['Frame'])) {
			$this->Frame = ClassRegistry::init('Frames.Frame');
			Current::$m17n['Frame'] = $this->Frame->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'key' => Current::$current['Frame']['key']
				),
			));
		}

		if (isset(Current::$current['Block'])) {
			$this->Block = ClassRegistry::init('Blocks.Block');
			Current::$m17n['Block'] = $this->Block->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'key' => Current::$current['Block']['key']
				),
			));
		}
	}

}
