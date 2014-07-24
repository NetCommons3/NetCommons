<?php
/**
 *  Initial
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class Initial extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
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
						'is_visible' => true,
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'container_id' => '2',
						'is_visible' => true,
					),
					array(
						'id' => '3',
						'page_id' => '1',
						'container_id' => '3',
						'is_visible' => true,
					),
					array(
						'id' => '4',
						'page_id' => '1',
						'container_id' => '4',
						'is_visible' => true,
					),
					array(
						'id' => '5',
						'page_id' => '1',
						'container_id' => '5',
						'is_visible' => true,
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
						'room_id' => null,
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
						'is_visible' => true,
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'box_id' => '2',
						'is_visible' => true,
					),
					array(
						'id' => '3',
						'page_id' => '1',
						'box_id' => '3',
						'is_visible' => true,
					),
					array(
						'id' => '4',
						'page_id' => '1',
						'box_id' => '4',
						'is_visible' => true,
					),
					array(
						'id' => '5',
						'page_id' => '1',
						'box_id' => '5',
						'is_visible' => true,
					),
				),

				'Frame' => array(
					array(
						'id' => '1',
						'room_id' => '1',
						'box_id' => '1',
						'plugin_id' => '1',
						'block_id' => '1',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
					array(
						'id' => '2',
						'room_id' => '1',
						'box_id' => '2',
						'plugin_id' => '1',
						'block_id' => '2',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
					array(
						'id' => '3',
						'room_id' => '1',
						'box_id' => '3',
						'plugin_id' => '1',
						'block_id' => '3',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
					array(
						'id' => '4',
						'room_id' => '1',
						'box_id' => '4',
						'plugin_id' => '1',
						'block_id' => '4',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
					array(
						'id' => '5',
						'room_id' => '1',
						'box_id' => '5',
						'plugin_id' => '1',
						'block_id' => '5',
						'weight' => '1',
						'is_published' => true,
						'from' => null,
						'to' => null,
					),
				),

				'Block' => array(
					array(
						'id' => '1',
						'room_id' => '1',
					),
					array(
						'id' => '2',
						'room_id' => '1',
					),
					array(
						'id' => '3',
						'room_id' => '1',
					),
					array(
						'id' => '4',
						'room_id' => '1',
					),
					array(
						'id' => '5',
						'room_id' => '1',
					),
				),

				'Language' => array(
					array(
						'id' => '1',
						'code' => 'eng',
						'weight' => '1',
						'is_active' => true,
					),
					array(
						'id' => '2',
						'code' => 'jpn',
						'weight' => '2',
						'is_active' => true,
					),
				),

				'LanguagesPage' => array(
					array(
						'id' => '1',
						'page_id' => '1',
						'language_id' => '1',
						'name' => 'TestPage001',
					),
					array(
						'id' => '2',
						'page_id' => '1',
						'language_id' => '2',
						'name' => 'テストページ001',
					),
				),

				'FramesLanguage' => array(
					array(
						'id' => '1',
						'frame_id' => '1',
						'language_id' => '1',
						'name' => 'Test001',
					),
					array(
						'id' => '2',
						'frame_id' => '1',
						'language_id' => '2',
						'name' => 'テスト001',
					),
					array(
						'id' => '3',
						'frame_id' => '2',
						'language_id' => '1',
						'name' => 'Test002',
					),
					array(
						'id' => '4',
						'frame_id' => '2',
						'language_id' => '2',
						'name' => 'テスト002',
					),
					array(
						'id' => '5',
						'frame_id' => '3',
						'language_id' => '1',
						'name' => 'Test003',
					),
					array(
						'id' => '6',
						'frame_id' => '3',
						'language_id' => '2',
						'name' => 'テスト003',
					),
					array(
						'id' => '7',
						'frame_id' => '4',
						'language_id' => '1',
						'name' => 'Test004',
					),
					array(
						'id' => '8',
						'frame_id' => '4',
						'language_id' => '2',
						'name' => 'テスト004',
					),
					array(
						'id' => '9',
						'frame_id' => '5',
						'language_id' => '1',
						'name' => 'Test005',
					),
					array(
						'id' => '10',
						'frame_id' => '5',
						'language_id' => '2',
						'name' => 'テスト005',
					),
				),

				'BlocksLanguage' => array(
					array(
						'id' => '1',
						'block_id' => '1',
						'language_id' => '1',
						'name' => 'Test001',
					),
					array(
						'id' => '2',
						'block_id' => '1',
						'language_id' => '2',
						'name' => 'テスト001',
					),
					array(
						'id' => '3',
						'block_id' => '2',
						'language_id' => '1',
						'name' => 'Test002',
					),
					array(
						'id' => '4',
						'block_id' => '2',
						'language_id' => '2',
						'name' => 'テスト002',
					),
					array(
						'id' => '5',
						'block_id' => '3',
						'language_id' => '1',
						'name' => 'Test003',
					),
					array(
						'id' => '6',
						'block_id' => '3',
						'language_id' => '2',
						'name' => 'テスト003',
					),
					array(
						'id' => '7',
						'block_id' => '4',
						'language_id' => '1',
						'name' => 'Test004',
					),
					array(
						'id' => '8',
						'block_id' => '4',
						'language_id' => '2',
						'name' => 'テスト004',
					),
					array(
						'id' => '9',
						'block_id' => '5',
						'language_id' => '1',
						'name' => 'Test005',
					),
					array(
						'id' => '10',
						'block_id' => '5',
						'language_id' => '2',
						'name' => 'テスト005',
					),
				),

				'Plugin' => array(
					array(
						'id' => '1',
						'folder' => 'announcements',
					),
				),

				'Part' => array(
					array(
						'id' => '1',
						'type' => '2',
					),
					array(
						'id' => '2',
						'type' => '2',
					),
					array(
						'id' => '3',
						'type' => '2',
					),
					array(
						'id' => '4',
						'type' => '2',
					),
					array(
						'id' => '5',
						'type' => '2',
					),
				),

				'PartsRoomsUser' => array(
					array(
						'id' => '1',
						'room_id' => '1',
						'user_id' => '1',
						'part_id' => '1',
					),
				),

				'RoomPart' => array(
					array(
						'id' => '1',
						'part_id' => '1',
						'weight' => '1',
						'hierarchy' => '2147483647',
						'read_page' => 1,
						'edit_page' => 1,
						'create_page' => 1,
						'publish_page' => 1,
						'read_block' => 1,
						'edit_block' => 1,
						'create_block' => 1,
						'publish_block' => 1,
						'read_content' => 1,
						'edit_content' => 1,
						'create_content' => 1,
						'publish_content' => 1,
					),
					array(
						'id' => '2',
						'part_id' => '2',
						'weight' => '2',
						'hierarchy' => '8000',
						'read_page' => 1,
						'edit_page' => 1,
						'create_page' => 1,
						'publish_page' => 2,
						'read_block' => 1,
						'edit_block' => 1,
						'create_block' => 1,
						'publish_block' => 2,
						'read_content' => 1,
						'edit_content' => 2,
						'create_content' => 1,
						'publish_content' => 2,
					),
					array(
						'id' => '3',
						'part_id' => '3',
						'weight' => '3',
						'hierarchy' => '7000',
						'read_page' => 1,
						'edit_page' => 0,
						'create_page' => 0,
						'publish_page' => 0,
						'read_block' => 1,
						'edit_block' => 0,
						'create_block' => 0,
						'publish_block' => 0,
						'read_content' => 1,
						'edit_content' => 2,
						'create_content' => 1,
						'publish_content' => 2,
					),
					array(
						'id' => '4',
						'part_id' => '4',
						'weight' => '4',
						'hierarchy' => '6000',
						'read_page' => 1,
						'edit_page' => 0,
						'create_page' => 0,
						'publish_page' => 0,
						'read_block' => 1,
						'edit_block' => 0,
						'create_block' => 0,
						'publish_block' => 0,
						'read_content' => 1,
						'edit_content' => 0,
						'create_content' => 1,
						'publish_content' => 2,
					),
					array(
						'id' => '5',
						'part_id' => '5',
						'weight' => '5',
						'hierarchy' => '1000',
						'read_page' => 1,
						'edit_page' => 0,
						'create_page' => 0,
						'publish_page' => 0,
						'read_block' => 1,
						'edit_block' => 0,
						'create_block' => 0,
						'publish_block' => 0,
						'read_content' => 1,
						'edit_content' => 0,
						'create_content' => 0,
						'publish_content' => 0,
					),
				),
				'LanguagesPart' => array(
					array(
					'id' => 1,
					'part_id' => 1,
					'language_id' => 2,
					'name' => 'ルーム管理者',
					'created_user_id' => 1,
					'created' => false,
					'modified_user_id' => 1,
					'modified' => false,
					),
					array(
						'id' => 2,
						'part_id' => 2,
						'language_id' => 2,
						'name' => '編集長',
						'created_user_id' => 1,
						'created' => false,
						'modified_user_id' => 1,
						'modified' => false,
					),
					array(
						'id' => 3,
						'part_id' => 3,
						'language_id' => 2,
						'name' => '編集者',
						'created_user_id' => 1,
						'created' => false,
						'modified_user_id' => 1,
						'modified' => false,
					),
					array(
						'id' => 4,
						'part_id' => 4,
						'language_id' => 2,
						'name' => '一般',
						'created_user_id' => 1,
						'created' => false,
						'modified_user_id' => 1,
						'modified' => false,
					),
					array(
						'id' => 5,
						'part_id' => 5,
						'language_id' => 2,
						'name' => '参観者',
						'created_user_id' => 1,
						'created' => false,
						'modified_user_id' => 1,
						'modified' => false,
					)
				)
			);

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'blocks_languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'boxes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'container_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '1:each site,2:each space,3:each room,4:each page'),
					'space_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'is_visible' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'containers' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '1:header,2:major,3:main,4:minor,5:footer'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'is_visible' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'frames' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'plugin_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'frames_languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'frame_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'group_parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'part_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'can_read_participant' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_add_participant' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_delete_participant' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_read_group' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_create_group' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_edit_group' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_delete_group' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'has_room' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'need_approval' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'groups_languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'groups_parts_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'can_read' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
					'can_edit' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'is_active' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'page_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_roles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_site_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'site_setting_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_user_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'user_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_user_attributes_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'languages_user_select_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'user_select_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'pages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
					'permalink' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'parts_rooms_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'part_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'plugins' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'folder' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '1:for frame,2:for controll panel'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_plugins' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_id' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'plugin_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'permission' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_user_attributes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'role_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_attribute_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'can_read' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'can_edit' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'room_parts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'part_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'hierarchy' => array('type' => 'integer', 'length' => 11, 'null' => true, 'default' => null),
					'read_page' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'edit_page' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'create_page' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'publish_page' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'read_block' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'edit_block' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'create_block' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'publish_block' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'read_content' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'edit_content' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'create_content' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'publish_content' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'top_page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'site_setting_values' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'site_setting_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'site_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'is_each_language' => array('type' => 'boolean', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
					'type' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
				'blocks', 'blocks_languages', 'boxes', 'boxes_pages', 'containers', 'containers_pages', 'frames', 'frames_languages', 'group_parts', 'groups', 'groups_languages', 'groups_parts_users', 'groups_users', 'languages', 'languages_pages', 'languages_parts', 'languages_roles', 'languages_site_settings', 'languages_user_attributes', 'languages_user_attributes_users', 'languages_user_select_attributes', 'pages', 'parts', 'parts_rooms_users', 'plugins', 'roles', 'roles_plugins', 'roles_user_attributes', 'room_parts', 'rooms', 'site_setting_values', 'site_settings', 'spaces',
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 * @access public
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
 * @return boolean Should process continue
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
