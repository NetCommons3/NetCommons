<?php
/**
 * Add columns pages.container_fluid and frames.is_deleted
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Add columns pages.container_fluid and frames.is_deleted
 *
 * @package NetCommons\NetCommons\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class AddColumnsContainerFluidAndIsDeleted extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_columns_container_fluid_and_is_deleted';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
			'create_field' => array(
				'frames' => array(
					'is_deleted' => array('type' => 'boolean', 'null' => false, 'default' => null, 'after' => 'weight'),
				),
				'pages' => array(
					'is_container_fluid' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'after' => 'to'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'drop_field' => array(
				'frames' => array('is_deleted'),
				'pages' => array('is_container_fluid'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
