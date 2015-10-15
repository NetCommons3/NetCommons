<?php
/**
 * add timezone record migration
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Class AddTimezeone
 */
class AddTimezeone extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_timezeone';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
		'SiteSetting' => array(
			//日本語
			array(
				'language_id' => '2',
				'key' => 'site_timezone',
				'value' => 'Asia/Tokyo',
				'label' => 'サイトタイムゾーン',
			),
			//英語
			array(
				'language_id' => '1',
				'key' => 'site_timezone',
				'value' => 'UTC',
				'label' => 'Site Timezone',
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
}
