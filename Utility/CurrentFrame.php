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
		$this->clear();

		if (!in_array(Current::$request->params['plugin'], self::$skipFramePlugins, true)) {
			$this->setFrame();
			$this->setBlock();
		}

		(new CurrentPage())->initialize();

		$this->setBlockRolePermissions();
	}

/**
 * setup current data
 *
 * @return void
 */
	public function clear() {
		$models = [
			'Room', 'RoomRolePermission', 'RolesRoom', 'Frame', 'Block', 'BlockRolePermission',
			'RolesRoomsUser', 'Permission'
		];
		foreach ($models as $model) {
			if (isset(Current::$current[$model])) {
				unset(Current::$current[$model]);
			}
		}
	}

/**
 * Set Frame
 *
 * @param string $frameId フレームID
 * @return void
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function setFrame($frameId = null) {
		if ($frameId) {
			//何もしない
		} elseif (! Hash::get(Current::$request->params, 'requested') &&
					Hash::get(Current::$request->data, 'Frame.id')) {
			$frameId = Current::$request->data['Frame']['id'];
		} elseif (Hash::get(Current::$request->params, 'frame_id')) {
			$frameId = Hash::get(Current::$request->params, 'frame_id');
		} elseif (Hash::get(Current::$request->params, '?.frame_id')) {
			$frameId = Hash::get(Current::$request->params, '?.frame_id');
		} elseif (isset(Current::$request->query['frame_id'])) {
			$frameId = Current::$request->query['frame_id'];
		}

		$this->Frame = ClassRegistry::init('Frames.Frame');
		$this->Block = ClassRegistry::init('Blocks.Block');

		if (isset($frameId)) {
			//'Frame', 'Box', 'Block', 'Room', 'FramesLanguage', 'Plugin', 'FramePublicLanguage' 更新
			$result = $this->Frame->find('first', array(
				'recursive' => 0,
				'conditions' => array(
					'Frame.id' => $frameId,
				),
			));
			Current::setCurrent(
				$result, ['Frame', 'Box', 'Block', 'Room', 'FramesLanguage', 'Plugin', 'FramePublicLanguage']
			);
		}

		//ブロック設定の新規の場合の処理
		if (Current::$layout === 'NetCommons.setting' &&
				substr(Current::$request->params['controller'], -7) === '_blocks' &&
				Current::$request->params['action'] === 'add') {
			Current::$current['Block'] = $this->Block->create(['id' => null])['Block'];
		}

		$this->setBox();
	}

/**
 * Set PageByBox
 *
 * @return void
 */
	public function setBox() {
		if (empty($this->Box)) {
			$this->Box = ClassRegistry::init('Boxes.Box');
		}

		if (isset(Current::$current['Box']['id'])) {
			$boxId = Current::$current['Box']['id'];
		} elseif (isset(Current::$request->data['Frame']) &&
					isset(Current::$request->data['Frame']['box_id'])) {
			$boxId = Current::$request->data['Frame']['box_id'];
		} else {
			return;
		}

		//Box、Room、Space更新
		$result = $this->Box->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'Box.id' => $boxId,
			),
		));
		Current::setCurrent($result);

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
		} elseif (Current::$current['Box']['page_id']) {
			$pageId = Current::$current['Box']['page_id'];
		} else {
			return;
		}

		$this->BoxesPageContainer = ClassRegistry::init('Boxes.BoxesPageContainer');

		//BoxesPageContainer、Box、PageContainer、Page更新
		$result = $this->BoxesPageContainer->find('first', array(
			'recursive' => 0,
			'conditions' => array(
				'BoxesPageContainer.box_id' => Current::$current['Box']['id'],
				'BoxesPageContainer.page_id' => $pageId,
				'BoxesPageContainer.container_type' => Current::$current['Box']['container_type'],
			),
		));
		Current::setCurrent($result);
	}

/**
 * Set Block
 *
 * @param int $blockId Blocks.id
 * @return void
 */
	public function setBlock($blockId = null) {
		$this->Block = ClassRegistry::init('Blocks.Block');
		$this->Frame = ClassRegistry::init('Frames.Frame');

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

		//Block、Room、Language, Plugin更新
		Current::setCurrent($result, ['Block', 'Room', 'BlocksLanguage', 'Plugin']);

		//Frameデータがない場合、block_idから配置しているFrameを探し出してセットする
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

		//あり得ない？のでコメントアウト
		//if (! isset(Current::$current['Block']) && isset(Current::$current['Frame']['block_id'])) {
		//	$result = $this->Block->find('first', array(
		//		'recursive' => 0,
		//		'conditions' => array(
		//			'Block.id' => Current::$current['Frame']['block_id'],
		//		),
		//	));
		//	Current::setCurrent($result, true);
		//}
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

		$this->__setCurrentBlockRolePermission();

		$permission = array();
		$permission = Hash::merge(
			$permission, Hash::get(Current::$current, 'DefaultRolePermission', array())
		);
		$permission = Hash::merge(
			$permission, Hash::get(Current::$current, 'RoomRolePermission', array())
		);
		$permission = Hash::merge(
			$permission, Hash::get(Current::$current, 'BlockRolePermission', array())
		);

		if (Current::read('Room.need_approval')) {
			Current::$current['Permission'] = $permission;
			return;
		}

		if (!isset(Current::$current['Block']['key'])) {
			$permission['content_publishable']['value'] = true;
			$permission['content_comment_publishable']['value'] = true;
			Current::$current['Permission'] = $permission;

			return;
		}

		Current::$current['Permission'] = $this->__getPermissionFromBlockSetting($permission);
	}

/**
 * Set current BlockRolePermissions
 *
 * @return void
 */
	private function __setCurrentBlockRolePermission() {
		if (!isset(Current::$current['RolesRoom']) ||
			!isset(Current::$current['Block']['key'])
		) {
			return;
		}

		$result = $this->BlockRolePermission->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'roles_room_id' => Current::$current['RolesRoom']['id'],
				'block_key' => Current::$current['Block']['key'],
			)
		));
		if (!$result) {
			return;
		}

		Current::$current['BlockRolePermission'] = Hash::combine(
			$result, '{n}.BlockRolePermission.permission', '{n}.BlockRolePermission'
		);

		// content_publishable は BlockRolePermission から無くなったが、あった場合throw Exception しとく
		if (isset(Current::$current['BlockRolePermission']['content_publishable'])) {
			throw new InternalErrorException('BlockRolePermission.content_publishable exists');
		}
	}

/**
 * Get permission from BlockSetting
 *
 * @param array $permission permission data
 * @return void
 */
	private function __getPermissionFromBlockSetting($permission) {
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
		if (!$blockSetting) {
			$permission['content_publishable']['value'] = true;
			$permission['content_comment_publishable']['value'] = true;

			return $permission;
		}

		$useWorkflow = Hash::get($blockSetting, [BlockSettingBehavior::FIELD_USE_WORKFLOW]);
		if (!$useWorkflow) {
			$permission['content_publishable']['value'] = true;
		}

		$useApproval = Hash::get($blockSetting, [BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL]);
		if (!$useApproval) {
			$permission['content_comment_publishable']['value'] = true;
		}

		return $permission;
	}

}
