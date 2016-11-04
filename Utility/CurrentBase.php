<?php
/**
 * Current Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Current Utility
 *
 * NetCommonsの機能として必要な情報を保持します。<br>
 * [NetCommonsAppController::beforeFilter](./NetCommonsAppController.html#method_beforeFilter)
 * で初期処理が呼び出され、値が設定されます。<br>
 * 値を取得する時は、[readメソッド](#method_read)を使用します。<br>
 * 権限を取得する時は、[permissionメソッド](#method_permission)を使用します。<br>
 *
 * #### 保持データ
 * ```
 * Array(
 * 	[User] => Array(
 * 		[id] => 1
 * 		[username] => admin
 * 		[key] => 640f981d6104fd21463d674f18477348
 * 		[avatar] =>
 * 		[avatar_file_id] =>
 * 		[is_avatar_public] =>
 * 		[handlename] => admin
 * 		[is_handlename_public] =>
 * 		[is_name_public] =>
 * 		[email] =>
 * 		[is_email_public] =>
 *
 * 		・・・
 *
 * 		[Role] => Array(
 * 			[id] => 1
 * 			[language_id] => 2
 * 			[key] => system_administrator
 * 			[type] => 1
 * 			[name] => システム管理者
 * 			[is_system] => 1
 * 		)
 * 	)
 *
 * 	[Language] => Array(
 * 		[id] => 2
 * 		[code] => ja
 * 		[weight] => 2
 * 		[is_active] => 1
 * 	)
 *
 * 	[PluginsRole] => Array(
 * 		[13] => Array(
 * 			[id] => 13
 * 			[role_key] => system_administrator
 * 			[plugin_key] => rooms
 * 		)
 *
 * 		[20] => Array(
 * 			[id] => 20
 * 			[role_key] => system_administrator
 * 			[plugin_key] => user_manager
 * 		)
 *
 * 	)
 *
 * 	[Page] => Array(
 * 		[id] => 1
 * 		[room_id] => 1
 * 		[parent_id] =>
 * 		[lft] => 1
 * 		[rght] => 2
 * 		[permalink] =>
 * 		[slug] =>
 * 		[is_published] => 1
 * 		[from] =>
 * 		[to] =>
 * 		[is_container_fluid] =>
 * 	)
 *
 * 	[Room] => Array(
 * 		[id] => 1
 * 		[space_id] => 2
 * 		[page_id_top] => 1
 * 		[root_id] =>
 * 		[parent_id] =>
 * 		[lft] => 1
 * 		[rght] => 2
 * 		[active] => 1
 * 		[default_role_key] => visitor
 * 		[need_approval] => 1
 * 		[default_participation] => 1
 * 		[page_layout_permitted] => 1
 * 	)
 *
 * 	[ParentPage] => Array(
 * 		・・・
 * 	)
 *
 * 	[RolesRoomsUser] => Array(
 * 		・・・
 * 	)
 *
 * 	[RolesRoom] => Array(
 * 		・・・
 * 	)
 *
 * ・・・
 *
 * 	[Permission] => Array(
 * 		[page_editable] => Array(
 * 			[id] => 9
 * 			[role_key] => room_administrator
 * 			[type] => room_role
 * 			[permission] => page_editable
 * 			[value] => 1
 * 			[fixed] => 1
 * 			[roles_room_id] => 1
 * 		)
 *
 * 		[block_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_readable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_creatable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_publishable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_creatable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[content_comment_publishable] => Array(
 * 			・・・
 * 		)
 *
 * 		[block_permission_editable] => Array(
 * 			・・・
 * 		)
 *
 * 		[html_not_limited] => Array(
 * 			・・・
 * 		)
 *
 * 	)
 *
 * 	[Plugin] => Array(
 * 		[id] => 5
 * 		[language_id] => 2
 * 		[key] => announcements
 * 		[name] => お知らせ
 * 		[namespace] => netcommons/announcements
 * 		[weight] =>
 * 		[type] => 1
 * 		[default_action] => announcements/view
 * 		[default_setting_action] => announcement_blocks/index
 * 	)
 *
 * 	[Frame] => Array(
 * 		[id] => 1
 * 		[language_id] => 2
 * 		[room_id] => 1
 * 		[box_id] => 3
 * 		[plugin_key] => announcements
 * 		[block_id] => 1
 * 		[key] => frame_1
 * 		[name] => お知らせ
 * 		[header_type] => default
 * 		[translation_engine] =>
 * 		[is_first_auto_translation] =>
 * 		[is_auto_translated] =>
 * 		[weight] => 1
 * 		[is_deleted] =>
 * 	)
 *
 * 	[Box] => Array(
 * 		[id] => 3
 * 		[container_id] => 3
 * 		[type] => 4
 * 		[space_id] =>
 * 		[room_id] => 1
 * 		[page_id] => 1
 * 		[weight] => 1
 * 	)
 *
 * 	[Block] => Array(
 * 		[id] => 1
 * 		[language_id] => 2
 * 		[room_id] => 1
 * 		[plugin_key] => announcements
 * 		[key] => block_1
 * 		[name] => NetCommons 3! セッティングモードで編集しよう.
 * 		[public_type] => 1
 * 		[from] =>
 * 		[to] =>
 * 		[translation_engine] =>
 * 		[is_auto_translated] =>
 * 		[is_first_auto_translation] =>
 * 	)
 * )
 * ```
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentBase {

/**
 * Current data
 *
 * @var array
 */
	public static $current = array();

/**
 * Permission data
 *
 * @var array
 */
	public static $permission = array();

/**
 * 指定された$keyの値を返します。
 *
 * 現在のBlockKeyを取得したい場合
 * ```
 * Cuurent::read('Block.key')
 * ```
 *
 * @param string|null $key Hashクラスのpath
 * @param mixed $default デフォルト値
 * @return array|null Current data.
 */
	public static function read($key = null, $default = null) {
		if (! isset(self::$current)) {
			return self::$current;
		}

		if (! isset($key)) {
			return self::$current;
		}
		return Hash::get(self::$current, $key, $default);
	}

/**
 * 指定された$keyの値をセットします
 *
 * 現在のBlockKeyをセットしたい場合
 * ```
 * Cuurent::write('Block.key', 'block_key)
 * ```
 *
 * @param string|null $key Hashクラスのpath、nullの場合、Hash::mergeする
 * @param mixted $value セットする値
 * @return void
 */
	public static function write($key, $value) {
		if (! isset(self::$current)) {
			self::$current = array();
		}
		if (! isset($key)) {
			self::$current = Hash::merge(self::$current, $value);
		} else {
			self::$current = Hash::insert(self::$current, $key, $value);
		}
	}

/**
 * 指定された$keyの値を削除します。
 *
 * 現在のBlockKeyを削除したい場合
 * ```
 * Cuurent::remove('Block.key')
 * ```
 *
 * @param string|null $key Hashクラスのpath
 * @return array|null Current data.
 */
	public static function remove($key = null) {
		if (! isset(self::$current) || ! isset($key)) {
			self::$current = array();
		}

		self::$current = Hash::remove(self::$current, $key);
	}

/**
 * 指定された$key(権限名文字列)の値を返します。
 *
 * ```
 * Current::permission('content_publishable')
 * ```
 *
 * @param string $key Hashクラスのpath
 * @param int|null $roomId ルームID
 * @return bool permission value
 */
	public static function permission($key, $roomId = null) {
		if (! isset(self::$current)) {
			return false;
		}
		if (! $roomId) {
			$roomId = Hash::get(self::$current, 'Room.id');
		}

		$path = 'Permission.' . $key . '.value';
		if (Hash::get(self::$permission, $roomId . '.' . $path) !== null) {
			return Hash::get(self::$permission, $roomId . '.' . $path);
		}

		if ($roomId == self::read('Room.id')) {
			$result = (bool)self::read($path);
		} else {
			$RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');
			$RoomRolePermission->bindModel(array(
				'belongsTo' => array(
					'RolesRoomsUser' => array(
						'className' => 'Rooms.RolesRoomsUser',
						//'fields' => array('id', 'name'),
						'foreignKey' => false,
						'type' => 'LEFT',
						'conditions' => array(
							'RolesRoom.id' . ' = ' . 'RolesRoomsUser.roles_room_id',
						),
					),
				)
			), true);

			$query = array(
				'recursive' => 0,
				'conditions' => array(
					'RolesRoomsUser.user_id' => self::read('User.id'),
					'RolesRoomsUser.room_id' => $roomId,
					$RoomRolePermission->alias . '.permission' => $key,
				),
			);
			$roomRolePermission = $RoomRolePermission->find('first', $query);
			$result = (bool)Hash::get($roomRolePermission, 'RoomRolePermission.value');
		}

		self::$permission = Hash::insert(self::$permission, $roomId . '.' . $path, $result);
		return $result;
	}

}
