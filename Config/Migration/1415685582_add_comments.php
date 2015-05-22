<?php
/**
 * add comments migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * add comments migration
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Config\Migration
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class AddComments extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
		),
		'down' => array(
			'drop_table' => array(
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
