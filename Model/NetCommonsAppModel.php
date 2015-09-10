<?php
/**
 * NetCommonsApp Model
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Takako Miyagawa <nekoget@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Model', 'Model');

/**
 * NetCommonsApp Model
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Takako Miyagawa <nekoget@gmail.com>
 * @package NetCommons\NetCommons\Model
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class NetCommonsAppModel extends Model {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		// If a datasource is set via params, use it and return
		if ((is_array($id) && isset($id['ds'])) || $ds) {
			parent::__construct($id, $table, $ds);
			return;
		}

		// Use a static variable, to only use one connection per page-call (otherwise we would get a new handle every time a Model is created)
		static $_useDbConfig;
		if (!isset($_useDbConfig)) {
			// Get all available database-configs
			$sources = ConnectionManager::enumConnectionObjects();

			// Find the slaves we have
			$slaves = array();
			foreach ($sources as $name => $values) {
				unset($values);
				// Slaves have to be named "slave1", "slave2", etc...
				if (preg_match('/^slave[0-9]+$/i', $name) == 1) {
					$slaves[] = $name;
				}
			}

			// Randomly use a slave
			$_useDbConfig = $slaves[rand(0, count($slaves) - 1)];
		}
		$this->useDbConfig = $_useDbConfig;

		parent::__construct($id, $table, $ds);
	}

/**
 * Sets the DataSource to which this model is bound.
 *
 * @param string $dataSource The name of the DataSource, as defined in app/Config/database.php
 * @return void
 * @throws MissingConnectionException
 */
	public function setDataSource($dataSource = null) {
		if ($this->useDbConfig !== 'test') {
			parent::setDataSource($dataSource);
		}
	}

/**
 * Initializes the model for writing a new record, loading the default values
 * for those fields that are not defined in $data, and clearing previous validation errors.
 * Especially helpful for saving data in loops.
 *
 * @param bool|array $data Optional data array to assign to the model after it is created. If null or false,
 *   schema data defaults are not merged.
 * @param bool $filterKey If true, overwrites any primary key input with an empty value
 * @return array The current Model::data; after merging $data and/or defaults from database
 * @link http://book.cakephp.org/2.0/en/models/saving-your-data.html#model-create-array-data-array
 */
	public function create($data = array(), $filterKey = false) {
		$options = array();

		$currents = array(
			'room_id' => Current::read('Room.id'),
			'language_id' => Current::read('Language.id'),
			'block_id' => Current::read('Block.id'),
			'block_key' => Current::read('Block.key'),
			'frame_id' => Current::read('Frame.id'),
			'frame_key' => Current::read('Frame.key'),
			'plugin_key' => Inflector::underscore($this->plugin),
		);

		foreach ($this->_schema as $fieldName => $fieldDetail) {
			if ($fieldName !== $this->primaryKey) {
				$options[$fieldName] = $fieldDetail['default'];
			}

			foreach ($currents as $key => $current) {
				if ($this->hasField($key) && $fieldName === $key &&  ! isset($data[$fieldName])) {
					$options[$fieldName] = $current;
				}
			}
		}

		$data = Hash::merge($options, $data);

		return parent::create($data, $filterKey);
	}

/**
 * Initializes the model for writing a new record, loading the default values
 * for those fields that are not defined in $data, and clearing previous validation errors.
 * Especially helpful for saving data in loops.
 *
 * @param bool|array $data Optional data array to assign to the model after it is created. If null or false,
 *   schema data defaults are not merged.
 * @param bool $filterKey If true, overwrites any primary key input with an empty value
 *
 * @return array The current Model::data; after merging $data and/or defaults from database
 * @link http://book.cakephp.org/2.0/en/models/saving-your-data.html#model-create-array-data-array
 */
	public function createAll($data = array(), $filterKey = false) {
		$newRecord = $data;

		if (isset($data[$this->alias])) {
			$options = $data[$this->alias];
		} else {
			$options = array();
		}
		$newRecord = Hash::merge($newRecord, $this->create($options));

		foreach ($this->_associations as $type) {
			if (! in_array($type, array('belongsTo', 'hasOne'), true)) {
				continue;
			}

			$models = array_keys($this->$type);
			foreach ($models as $model) {
				if ($model === 'TrackableCreator' || $model === 'TrackableUpdater') {
					continue;
				}

				if (isset($data[$model])) {
					$options = $data[$model];
				} else {
					$options = array();
				}
				$newRecord = Hash::merge($newRecord, $this->$model->create($options));
			}
		}

		return $newRecord;
	}

/**
 * transaction begin
 *
 * @return void
 */
	public function begin() {
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();
	}

/**
 * transaction commit
 *
 * @return void
 */
	public function commit() {
		$dataSource = $this->getDataSource();
		$dataSource->commit();
	}

/**
 * transaction rollback
 *
 * @return void
 */
	public function rollback($ex = null) {
		$dataSource = $this->getDataSource();
		$dataSource->rollback();
		if ($ex) {
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * Load models
 *
 * @param array $models models to load
 * @param string $source data source
 * @return void
 */
	public function loadModels(array $models = [], $source = 'master') {
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
			if ($this->$model->useDbConfig !== 'test') {
				$this->$model->setDataSource($source);
			}
		}
	}

/**
 * Check field1 matches field2
 *
 * @param array $field1 field1 parameters
 * @param string $field2 field2 key
 * @return bool
 */
	public function equalToField($field1, $field2) {
		$keys = array_keys($field1);
		return $this->data[$this->name][$field2] === $this->data[$this->name][array_pop($keys)];
	}

}
