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
App::uses('CurrentPage', 'NetCommons.Utility');

/**
 * CurrentFrame Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
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
 * 同じデータを取得しないようにキャッシュする
 *
 * @var array
 */
	private static $__memoryCache = [];

/**
 * CurrentPage Instance object
 *
 * @var mixed
 */
	protected static $_instancePage;

/**
 * setup current data
 *
 * @return void
 */
	public function initialize() {
		if (! self::$_instancePage) {
			self::$_instancePage = new CurrentPage();
		}

		$this->clear();

		if (!in_array(Current::$request->params['plugin'], self::$skipFramePlugins, true)) {
			$this->setFrame();
			$this->setBlock();
		}

		self::$_instancePage->initialize();

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
		} elseif (empty(Current::$request->params['requested']) &&
				isset(Current::$request->data['Frame']['id'])) {
			$frameId = Current::$request->data['Frame']['id'];
		} elseif (isset(Current::$request->params['frame_id'])) {
			$frameId = Current::$request->params['frame_id'];
		} elseif (isset(Current::$request->params['?']['frame_id'])) {
			$frameId = Current::$request->params['?']['frame_id'];
		} elseif (isset(Current::$request->query['frame_id'])) {
			$frameId = Current::$request->query['frame_id'];
		}

		$this->Frame = ClassRegistry::init('Frames.Frame');
		$this->Block = ClassRegistry::init('Blocks.Block');

		if (isset($frameId)) {
			//'Frame', 'Box', 'Block', 'Room', 'FramesLanguage', 'Plugin', 'FramePublicLanguage' 更新
			$result = $this->Frame->find('first', array(
				'recursive' => 0,
				'fields' => [
					$this->Frame->alias . '.id',
					$this->Frame->alias . '.room_id',
					$this->Frame->alias . '.box_id',
					$this->Frame->alias . '.plugin_key',
					$this->Frame->alias . '.block_id',
					$this->Frame->alias . '.key',
					$this->Frame->alias . '.header_type',
					$this->Frame->alias . '.weight',
					$this->Frame->alias . '.is_deleted',
					$this->Frame->alias . '.default_action',
					$this->Frame->alias . '.default_setting_action',
					$this->Frame->Box->alias . '.id',
					$this->Frame->Box->alias . '.container_id',
					$this->Frame->Box->alias . '.type',
					$this->Frame->Box->alias . '.space_id',
					$this->Frame->Box->alias . '.room_id',
					$this->Frame->Box->alias . '.page_id',
					$this->Frame->Box->alias . '.container_type',
					$this->Frame->Box->alias . '.weight',
					$this->Frame->Block->alias . '.id',
					$this->Frame->Block->alias . '.room_id',
					$this->Frame->Block->alias . '.plugin_key',
					$this->Frame->Block->alias . '.key',
					$this->Frame->Block->alias . '.public_type',
					$this->Frame->Block->alias . '.publish_start',
					$this->Frame->Block->alias . '.publish_end',
					$this->Frame->Block->alias . '.content_count',
					$this->Frame->Room->alias . '.id',
					$this->Frame->Room->alias . '.space_id',
					$this->Frame->Room->alias . '.page_id_top',
					$this->Frame->Room->alias . '.parent_id',
					$this->Frame->Room->alias . '.active',
					$this->Frame->Room->alias . '.default_role_key',
					$this->Frame->Room->alias . '.need_approval',
					$this->Frame->Room->alias . '.default_participation',
					$this->Frame->Room->alias . '.page_layout_permitted',
					$this->Frame->Room->alias . '.theme',
					'FramesLanguage.language_id',
					'FramesLanguage.frame_id',
					'FramesLanguage.name',
					'Plugin.key',
					'Plugin.type',
					'Plugin.name',
					'Plugin.is_m17n',
					'Plugin.default_action',
					'Plugin.default_setting_action',
					'Plugin.frame_add_action',
					'Plugin.display_topics',
					'Plugin.display_search',
					'FramePublicLanguage.language_id',
					'FramePublicLanguage.frame_id',
					'FramePublicLanguage.is_public',
					'BlocksLanguage.language_id',
					'BlocksLanguage.block_id',
					'BlocksLanguage.name',
				],
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
		$cacheId = 'box_id_' . $boxId;
		if (isset(self::$__memoryCache[$cacheId])) {
			$cache = self::$__memoryCache[$cacheId];
			Current::setCurrent($cache);
		} else {
			$result = $this->Box->find('first', array(
				'recursive' => 0,
				'fields' => [
					$this->Box->alias . '.id',
					$this->Box->alias . '.container_id',
					$this->Box->alias . '.type',
					$this->Box->alias . '.space_id',
					$this->Box->alias . '.room_id',
					$this->Box->alias . '.page_id',
					$this->Box->alias . '.container_type',
					$this->Box->alias . '.weight',
					$this->Box->Room->alias . '.id',
					$this->Box->Room->alias . '.space_id',
					$this->Box->Room->alias . '.page_id_top',
					$this->Box->Room->alias . '.parent_id',
					//$this->Box->Room->alias . '.lft',
					//$this->Box->Room->alias . '.rght',
					$this->Box->Room->alias . '.active',
					//$this->Box->Room->alias . '.in_draft',
					$this->Box->Room->alias . '.default_role_key',
					$this->Box->Room->alias . '.need_approval',
					$this->Box->Room->alias . '.default_participation',
					$this->Box->Room->alias . '.page_layout_permitted',
					$this->Box->Room->alias . '.theme',
					$this->Box->Space->alias . '.id',
					$this->Box->Space->alias . '.parent_id',
					//$this->Box->Space->alias . '.lft',
					//$this->Box->Space->alias . '.rght',
					$this->Box->Space->alias . '.type',
					$this->Box->Space->alias . '.plugin_key',
					$this->Box->Space->alias . '.default_setting_action',
					$this->Box->Space->alias . '.room_disk_size',
					$this->Box->Space->alias . '.room_id_root',
					$this->Box->Space->alias . '.page_id_top',
					$this->Box->Space->alias . '.permalink',
					$this->Box->Space->alias . '.is_m17n',
					$this->Box->Space->alias . '.after_user_save_model',
				],
				'conditions' => array(
					'Box.id' => $boxId,
				),
			));
			self::$__memoryCache[$cacheId] = $result;
			Current::setCurrent($result);
		}

		$this->setBoxPageContainer();
	}

/**
 * Set BoxPageContainer
 *
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
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

		$cacheId = 'box_page_container_' .
						Current::$current['Box']['id'] . '_' .
						$pageId . '_' .
						Current::$current['Box']['container_type'];
		if (isset(self::$__memoryCache[$cacheId])) {
			$cache = self::$__memoryCache[$cacheId];
			Current::setCurrent($cache);
		} else {
			$this->BoxesPageContainer = ClassRegistry::init('Boxes.BoxesPageContainer');

			//BoxesPageContainer、Box、PageContainer、Page更新
			$query = array(
				'recursive' => -1,
				'fields' => [
					$this->BoxesPageContainer->alias . '.id',
					$this->BoxesPageContainer->alias . '.page_container_id',
					$this->BoxesPageContainer->alias . '.page_id',
					$this->BoxesPageContainer->alias . '.container_type',
					$this->BoxesPageContainer->alias . '.box_id',
					$this->BoxesPageContainer->alias . '.is_published',
					$this->BoxesPageContainer->alias . '.weight',
					$this->BoxesPageContainer->PageContainer->alias . '.id',
					$this->BoxesPageContainer->PageContainer->alias . '.page_id',
					$this->BoxesPageContainer->PageContainer->alias . '.container_type',
					$this->BoxesPageContainer->PageContainer->alias . '.is_published',
					$this->BoxesPageContainer->PageContainer->alias . '.is_configured',
					$this->BoxesPageContainer->Page->alias . '.id',
					$this->BoxesPageContainer->Page->alias . '.room_id',
					$this->BoxesPageContainer->Page->alias . '.root_id',
					$this->BoxesPageContainer->Page->alias . '.parent_id',
					//$this->BoxesPageContainer->Page->alias . '.lft',
					//$this->BoxesPageContainer->Page->alias . '.rght',
					$this->BoxesPageContainer->Page->alias . '.permalink',
					$this->BoxesPageContainer->Page->alias . '.slug',
					$this->BoxesPageContainer->Page->alias . '.is_container_fluid',
					$this->BoxesPageContainer->Page->alias . '.theme',
					$this->BoxesPageContainer->Box->alias . '.id',
					$this->BoxesPageContainer->Box->alias . '.container_id',
					$this->BoxesPageContainer->Box->alias . '.type',
					$this->BoxesPageContainer->Box->alias . '.space_id',
					$this->BoxesPageContainer->Box->alias . '.room_id',
					$this->BoxesPageContainer->Box->alias . '.page_id',
					$this->BoxesPageContainer->Box->alias . '.container_type',
					$this->BoxesPageContainer->Box->alias . '.weight',
				],
				'conditions' => array(
					'BoxesPageContainer.box_id' => Current::$current['Box']['id'],
					'BoxesPageContainer.page_id' => $pageId,
					'BoxesPageContainer.container_type' => Current::$current['Box']['container_type'],
				),
				'joins' => [
					[
						'type' => 'INNER',
						'table' => $this->BoxesPageContainer->PageContainer->table,
						'alias' => $this->BoxesPageContainer->PageContainer->alias,
						'conditions' => [
							$this->BoxesPageContainer->PageContainer->alias . '.id' . '=' .
											$this->BoxesPageContainer->alias . '.page_container_id',
						],
					],
					[
						'type' => 'INNER',
						'table' => $this->BoxesPageContainer->Page->table,
						'alias' => $this->BoxesPageContainer->Page->alias,
						'conditions' => [
							$this->BoxesPageContainer->Page->alias . '.id' . '=' .
											$this->BoxesPageContainer->alias . '.page_id',
						],
					],
					[
						'type' => 'INNER',
						'table' => $this->BoxesPageContainer->Box->table,
						'alias' => $this->BoxesPageContainer->Box->alias,
						'conditions' => [
							$this->BoxesPageContainer->Box->alias . '.id' . '=' .
											$this->BoxesPageContainer->alias . '.box_id',
						],
					],
				],
			);
			$result = $this->BoxesPageContainer->find('first', $query);
			self::$__memoryCache[$cacheId] = $result;
			Current::setCurrent($result);
		}
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
			'fields' => [
				$this->Block->alias . '.id',
				$this->Block->alias . '.room_id',
				$this->Block->alias . '.plugin_key',
				$this->Block->alias . '.key',
				$this->Block->alias . '.public_type',
				$this->Block->alias . '.publish_start',
				$this->Block->alias . '.publish_end',
				$this->Block->alias . '.content_count',
				$this->Block->Room->alias . '.id',
				$this->Block->Room->alias . '.space_id',
				$this->Block->Room->alias . '.page_id_top',
				$this->Block->Room->alias . '.parent_id',
				$this->Block->Room->alias . '.active',
				$this->Block->Room->alias . '.default_role_key',
				$this->Block->Room->alias . '.need_approval',
				$this->Block->Room->alias . '.default_participation',
				$this->Block->Room->alias . '.page_layout_permitted',
				$this->Block->Room->alias . '.theme',
				'BlocksLanguage.language_id',
				'BlocksLanguage.block_id',
				'BlocksLanguage.name',
				'Plugin.key',
				'Plugin.type',
				'Plugin.is_m17n',
				'Plugin.name',
				'Plugin.default_action',
				'Plugin.default_setting_action',
				'Plugin.frame_add_action',
				'Plugin.display_topics',
				'Plugin.display_search',
			],
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
		if (isset(Current::$current['DefaultRolePermission'])) {
			$permission = Hash::merge(
				$permission, Current::$current['DefaultRolePermission']
			);
		}
		if (isset(Current::$current['RoomRolePermission'])) {
			$permission = Hash::merge(
				$permission, Current::$current['RoomRolePermission']
			);
		}
		if (isset(Current::$current['BlockRolePermission'])) {
			$permission = Hash::merge(
				$permission, Current::$current['BlockRolePermission']
			);
		}

		if (Current::read('Room.need_approval')) {
			Current::$current['Permission'] = $permission;
			return;
		}

		// お知らせの新規作成時に発生するケース
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
 * @throws InternalErrorException
 * @return void
 */
	private function __setCurrentBlockRolePermission() {
		if (!isset(Current::$current['RolesRoom']) ||
			!isset(Current::$current['Block']['key'])
		) {
			return;
		}

		$results = $this->BlockRolePermission->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'roles_room_id' => Current::$current['RolesRoom']['id'],
				'block_key' => Current::$current['Block']['key'],
			)
		));
		if (!$results) {
			return;
		}
		foreach ($results as $rolePermission) {
			$permission = $rolePermission['BlockRolePermission']['permission'];
			Current::$current['BlockRolePermission'][$permission] = $rolePermission['BlockRolePermission'];
		}

		// content_publishable は BlockRolePermission から無くなったが、あった場合throw Exception しとく
		// アップデート時にMigrationで削除するのでありえない。
		// unsetして継続させた方が良いのか？アップデート時は管理者で操作するので問題なし。
		// アップデート時に、ファイル上書きして、プラグイン管理のアップデートを実行するまでの間あり得る
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
		$roomId = Current::read('Room.id');
		$pluginKey = Current::read('Plugin.key');
		$blockSetting = $this->BlockSetting->find('list', array(
			'recursive' => -1,
			'fields' => array('field_name', 'value'),
			'conditions' => array(
				'room_id' => $roomId,
				'plugin_key' => $pluginKey,
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

		if (empty($blockSetting[BlockSettingBehavior::FIELD_USE_WORKFLOW])) {
			$permission['content_publishable']['value'] = true;
		}

		if (empty($blockSetting[BlockSettingBehavior::FIELD_USE_COMMENT_APPROVAL])) {
			$permission['content_comment_publishable']['value'] = true;
		}

		return $permission;
	}

}
