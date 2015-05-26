<?php
/**
 * Add default action
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Add default action
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @package NetCommons\NetCommons\Config\Migration
 */
class AddDefaultAction extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_default_action';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'plugins' => array(
					'default_action' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Default action for content rendering', 'charset' => 'utf8', 'after' => 'type'),
					'default_setting_action' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Default action for frame settings', 'charset' => 'utf8', 'after' => 'default_action'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'plugins' => array('default_action', 'default_setting_action'),
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
