<?php
/**
 * Add translation stuff to blocks
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Add translation stuff to blocks
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @package NetCommons\NetCommons\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class AddTranslationStuffToBlocks extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_translation_stuff_to_blocks';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'blocks' => array(
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'after' => 'name'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'after' => 'name'),
					'translation_engine' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'name'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'blocks' => array('translation_engine', 'is_auto_translated', 'is_first_auto_translation'),
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
