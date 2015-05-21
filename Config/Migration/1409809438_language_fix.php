<?php
/**
 * language fix migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * language fix migration
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class LanguageFix extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
				'Page' => array(
					array(
						'id' => '1',
						'room_id' => '1',
						'parent_id' => null,
						'lft' => '1',
						'rght' => '2',
						'permalink' => '',
						'slug' => null,
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
				),

				'Container' => array(
					array(
						'id' => '1',
						'type' => '1',
					),
					array(
						'id' => '2',
						'type' => '2',
					),
					array (
						'id' => '3',
						'type' => '3',
					),
					array(
						'id' => '4',
						'type' => '4',
					),
					array(
						'id' => '5',
						'type' => '5',
					),
				),

				'ContainersPage' => array(
					array(
						'id' => '1',
						'page_id' => '1',
						'container_id' => '1',
						'is_published' => true,
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'container_id' => '2',
						'is_published' => true,
					),
					array(
						'id' => '3',
						'page_id' => '1',
						'container_id' => '3',
						'is_published' => true,
					),
					array(
						'id' => '4',
						'page_id' => '1',
						'container_id' => '4',
						'is_published' => true,
					),
					array(
						'id' => '5',
						'page_id' => '1',
						'container_id' => '5',
						'is_published' => true,
					),
				),

				'Box' => array(
					array(
						'id' => '1',
						'container_id' => '1',
						'type' => '1',
						'space_id' => '1',
						'room_id' => null,
						'page_id' => null,
						'weight' => '1',
					),
					array(
						'id' => '2',
						'container_id' => '2',
						'type' => '1',
						'space_id' => '1',
						'room_id' => null,
						'page_id' => null,
						'weight' => '1',
					),
					array(
						'id' => '3',
						'container_id' => '3',
						'type' => '4',
						'space_id' => null,
						'room_id' => 1,
						'page_id' => '1',
						'weight' => '1',
					),
					array(
						'id' => '4',
						'container_id' => '4',
						'type' => '1',
						'space_id' => 1,
						'room_id' => null,
						'page_id' => null,
						'weight' => '1',
					),
					array(
						'id' => '5',
						'container_id' => '5',
						'type' => '1',
						'space_id' => 1,
						'room_id' => null,
						'page_id' => null,
						'weight' => '1',
					),
				),

				'BoxesPage' => array(
					array(
						'id' => '1',
						'page_id' => '1',
						'box_id' => '1',
						'is_published' => true,
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'box_id' => '2',
						'is_published' => true,
					),
					array(
						'id' => '3',
						'page_id' => '1',
						'box_id' => '3',
						'is_published' => true,
					),
					array(
						'id' => '4',
						'page_id' => '1',
						'box_id' => '4',
						'is_published' => true,
					),
					array(
						'id' => '5',
						'page_id' => '1',
						'box_id' => '5',
						'is_published' => true,
					),
				),

				'Frame' => array(
					array(
						'id' => '1',
						'language_id' => '2',
						'room_id' => '1',
						'box_id' => '3',
						'plugin_key' => 'announcements',
						'block_id' => '1',
						'key' => 'frame_1',
						'name' => 'お知らせ',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
					array(
						'id' => '2',
						'language_id' => '2',
						'room_id' => '1',
						'box_id' => '2',
						'plugin_key' => 'menus',
						'block_id' => '2',
						'key' => 'frame_2',
						'name' => 'メニュー',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
				),

				'Language' => array(
					array(
						'id' => '1',
						'code' => 'en',
						'weight' => '1',
						'is_active' => true,
					),
					array(
						'id' => '2',
						'code' => 'ja',
						'weight' => '2',
						'is_active' => true,
					),
					array(
						'id' => '3',
						'code' => 'zh',
						'weight' => '3',
						'is_active' => true,
					),
				),

				'LanguagesPage' => array(
					array(
						'id' => '1',
						'page_id' => '1',
						'language_id' => '1',
						'name' => 'Home',
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'language_id' => '2',
						'name' => 'ホーム',
					),
				),

				'RolesRoom' => array(
					array(
						'id' => '1',
						'room_id' => '1',
						'role_key' => 'room_administrator',
					),
					array(
						'id' => '2',
						'room_id' => '1',
						'role_key' => 'chief_editor',
					),
					array(
						'id' => '3',
						'room_id' => '1',
						'role_key' => 'editor',
					),
					array(
						'id' => '4',
						'room_id' => '1',
						'role_key' => 'general_user',
					),
					array(
						'id' => '5',
						'room_id' => '1',
						'role_key' => 'visitor',
					),
				),

				'RolesRoomsUser' => array(
					array(
						'id' => '1',
						'roles_room_id' => '1',
						'user_id' => '1',
					),
				),

				'RoomRolePermission' => array(
					//ルーム管理者
					array('roles_room_id' => '1', 'permission' => 'block_editable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_comment_creatable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_comment_editable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_comment_publishable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_creatable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_editable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_publishable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'content_readable', 'value' => '1'),
					array('roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1'),
					//編集長
					array('roles_room_id' => '2', 'permission' => 'block_editable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_comment_creatable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_comment_editable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_comment_publishable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_creatable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_editable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_publishable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'content_readable', 'value' => '1'),
					array('roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1'),
					//編集者
					array('roles_room_id' => '3', 'permission' => 'block_editable', 'value' => '0'),
					array('roles_room_id' => '3', 'permission' => 'content_comment_creatable', 'value' => '1'),
					array('roles_room_id' => '3', 'permission' => 'content_comment_editable', 'value' => '1'),
					array('roles_room_id' => '3', 'permission' => 'content_comment_publishable', 'value' => '0'),
					array('roles_room_id' => '3', 'permission' => 'content_creatable', 'value' => '1'),
					array('roles_room_id' => '3', 'permission' => 'content_editable', 'value' => '1'),
					array('roles_room_id' => '3', 'permission' => 'content_publishable', 'value' => '0'),
					array('roles_room_id' => '3', 'permission' => 'content_readable', 'value' => '1'),
					array('roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0'),
					//一般
					array('roles_room_id' => '4', 'permission' => 'block_editable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_comment_creatable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_comment_editable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_comment_publishable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_creatable', 'value' => '1'),
					array('roles_room_id' => '4', 'permission' => 'content_editable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_publishable', 'value' => '0'),
					array('roles_room_id' => '4', 'permission' => 'content_readable', 'value' => '1'),
					array('roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0'),
					//ゲスト
					array('roles_room_id' => '5', 'permission' => 'block_editable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_comment_creatable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_comment_editable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_comment_publishable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_creatable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_editable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_publishable', 'value' => '0'),
					array('roles_room_id' => '5', 'permission' => 'content_readable', 'value' => '1'),
					array('roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0'),
				),

				'RoomRole' => array(
					array(
						'id' => '1',
						'role_key' => 'room_administrator',
						'level' => '2147483647',
						'weight' => '1',
					),
					array(
						'id' => '2',
						'role_key' => 'chief_editor',
						'level' => '8000',
						'weight' => '2',
					),
					array(
						'id' => '3',
						'role_key' => 'editor',
						'level' => '7000',
						'weight' => '3',
					),
					array(
						'id' => '4',
						'role_key' => 'general_user',
						'level' => '6000',
						'weight' => '4',
					),
					array(
						'id' => '5',
						'role_key' => 'visitor',
						'level' => '1000',
						'weight' => '5',
					),
				),

				'DefaultRolePermission' => array(
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'page_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'block_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_readable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_creatable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_publishable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_comment_creatable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_comment_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'content_comment_publishable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'room_administrator',
						'type' => 'room_role',
						'permission' => 'block_permission_editable',
						'value' => 1,
						'fixed' => 1,
					),

					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'page_editable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'block_editable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_readable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_creatable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_publishable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_comment_creatable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_comment_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'content_comment_publishable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'chief_editor',
						'type' => 'room_role',
						'permission' => 'block_permission_editable',
						'value' => 0,
						'fixed' => 1,
					),

					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'page_editable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'block_editable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_readable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_creatable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_editable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_publishable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_comment_creatable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_comment_editable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'content_comment_publishable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'editor',
						'type' => 'room_role',
						'permission' => 'block_permission_editable',
						'value' => 0,
						'fixed' => 1,
					),

					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'page_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'block_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_readable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_creatable',
						'value' => 1,
						'fixed' => 0,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_publishable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_comment_creatable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_comment_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'content_comment_publishable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'general_user',
						'type' => 'room_role',
						'permission' => 'block_permission_editable',
						'value' => 0,
						'fixed' => 1,
					),

					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'page_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'block_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_readable',
						'value' => 1,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_creatable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_publishable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_comment_creatable',
						'value' => 0,
						'fixed' => 0,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_comment_editable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'content_comment_publishable',
						'value' => 0,
						'fixed' => 1,
					),
					array(
						'role_key' => 'visitor',
						'type' => 'room_role',
						'permission' => 'block_permission_editable',
						'value' => 0,
						'fixed' => 1,
					),
				),

				'Role' => array(
					array(
						'id' => 1,
						'language_id' => 2,
						'key' => 'system_administrator',
						'type' => 1,
						'name' => 'システム管理者',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					),
					array(
						'id' => 2,
						'language_id' => 2,
						'key' => 'room_administrator',
						'type' => 2,
						'name' => 'ルーム管理者',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					),
					array(
						'id' => 3,
						'language_id' => 2,
						'key' => 'chief_editor',
						'type' => 2,
						'name' => '編集長',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					),
					array(
						'id' => 4,
						'language_id' => 2,
						'key' => 'editor',
						'type' => 2,
						'name' => '編集者',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					),
					array(
						'id' => 5,
						'language_id' => 2,
						'key' => 'general_user',
						'type' => 2,
						'name' => '一般',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					),
					array(
						'id' => 6,
						'language_id' => 2,
						'key' => 'visitor',
						'type' => 2,
						'name' => '参観者',
						'created_user' => 1,
						'created' => false,
						'modified_user' => 1,
						'modified' => false,
					)
				),

				'Room' => array(
					array(
						'id' => '1',
						'space_id' => '1'
					),
				),
			);

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'block_role_permissions' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'permission' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Permission name
e.g.) create_content,  post_top_article', 'charset' => 'utf8'),
					'value' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the block.', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the block.', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'boxes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'container_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Type of the box.
1:each site, 2:each space, 3:each room, 4:each page'),
					'space_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'boxes_pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'box_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '一般以下のパートが閲覧可能かどうか。

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'containers' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Type of the container.
1:Header, 2:Major, 3:Main, 4:Minor, 5:Footer'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'containers_pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'container_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '一般以下のパートが閲覧可能かどうか。

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'default_role_permissions' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'type' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Role type
e.g.) room_role, announcement_block_role, bbs_block_role
', 'charset' => 'utf8'),
					'permission' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Permission name
e.g.) create_page, edit_other_content, post_top_article', 'charset' => 'utf8'),
					'value' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'fixed' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'frames' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the frame.', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the frame.', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '一般以下のパートが閲覧可能かどうか。

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長'),
					'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame from.'),
					'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame to.'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'groups' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
					'has_room' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Group has room or not.'),
					'need_approval' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_read_by_self' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '自分自身がグループの構成員であるかどうか、自分自身が閲覧し得るか否か。
e.g.) 嫌いな人グループを作った当人は閲覧できても、嫌いなグループに登録されただけの人は閲覧不可など。'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'groups_languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'groups_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'primary'),
					'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
					'is_active' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Visible from user or not.
Only user w/ administrator role can edit this flag whether it\'s true or false.'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'page_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Datetime display page from.'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
					'permalink' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display page from.'),
					'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display page to.'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'plugins' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key to identify plugin.
Must be equivalent to plugin name used in router url.
e.g.) user_manager, auth, pages', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Human friendly name for the plugin.
e.g.) User Manager, Auth, Pages', 'charset' => 'utf8'),
					'namespace' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Unique namespace for package management system.
e.g.) packagist', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '1:for frame,2:for control panel'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'plugins_roles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'plugins_rooms' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the role.', 'charset' => 'utf8'),
					'type' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'Type of the role
1: User role, 2: Room role, 2: Group role'),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the role.
e.g.) Administrator, User Manager, Chief, User
', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_rooms' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_rooms_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_user_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'user_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'can_read' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_edit' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'room_role_permissions' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'Role type
e.g.) roomRole, announcementBlockRole, bbsBlockRole
'),
					'permission' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Permission name
e.g.) createPage, editOtherContent, publishContent', 'charset' => 'utf8'),
					'value' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'room_roles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
					'level' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '下位レベルに与えた権限を上位に与える時に使用。大きいほうが上位。'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'rooms' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'space_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'page_id_top' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'site_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the record.
e.g.) theme_name, site_name', 'charset' => 'utf8'),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Value of the record.
e.g.) default, My Homepage', 'charset' => 'utf8'),
					'label' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Human friendly label for the record.
e.g.) Theme, Site Name', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'spaces' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Type of the space.
1: Whole site, 2: Public space, 3: Private space, 4: Room space'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'user_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'data_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Data type of user_attribute.
1: input text, 2: radio, 3: checkbox, 4: select, 5: textarea, 6: email, 7: mobile email, 8: link, 9: html, 10: file, 11: image file, 12: auto increment, 13: date, 14: created datetime,  15: modified datetime'),
					'plugin_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Plugin type of this record belongs to.
1: All, 2: Users, 3: FlexibleDatabases / FlexibleForms'),
					'label' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Label of the user_attribute.
e.g.) Nickname, Age, Email Address', 'charset' => 'utf8'),
					'required' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_read_self' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_edit_self' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '表示順'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'user_attributes_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key to identify record meaning.
e.g.) nickname, age, ', 'charset' => 'utf8'),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'user_select_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
					'user_attribute_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'user_select_attributes_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_select_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'value' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Value of the record.
e.g.) 0, 1, 5, 10'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'username' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'block_role_permissions', 'blocks', 'boxes', 'boxes_pages', 'containers', 'containers_pages', 'default_role_permissions', 'frames', 'groups', 'groups_languages', 'groups_users', 'languages', 'languages_pages', 'pages', 'plugins', 'plugins_roles', 'plugins_rooms', 'roles', 'roles_rooms', 'roles_rooms_users', 'roles_user_attributes', 'room_role_permissions', 'room_roles', 'rooms', 'site_settings', 'spaces', 'user_attributes', 'user_attributes_users', 'user_select_attributes', 'user_select_attributes_users', 'users'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @return bool Should process continue
 */
	public function updateRecords($model, $records) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}
}
