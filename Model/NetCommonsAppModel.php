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
 * use useDbConfig
 *
 * @var array
 */
	//private static $__useDbConfig;

/**
 * use useDbConfig
 *
 * @var array
 */
	//private static $__originUseDbConfig;

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
		//self::$__useDbConfig = $_useDbConfig;
		//if (! self::$__originUseDbConfig) {
		//	self::$__originUseDbConfig = $_useDbConfig;
		//}

		parent::__construct($id, $table, $ds);
	}

/**
 * Gets the DataSource to which this model is bound.
 *
 * @return DataSource A DataSource object
 */
	//public function getDataSource() {
	//	CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' $this->useDbConfig 1 = ' . $this->useDbConfig);
	//	CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' self::$__useDbConfig = ' . self::$__useDbConfig);
	//	CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' get_class($this) = ' . get_class($this));
	//	if ($this->useDbConfig !== 'test') {
	//		if ($this->useDbConfig !== self::$__useDbConfig) {
	//			$this->setDataSource(self::$__useDbConfig);
	//			$this->useDbConfig = self::$__useDbConfig;
	//		}
	//
	//		//CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' $this->tableToModel = ' . print_r($this->tableToModel, true));
	//		foreach ($this->tableToModel as $table => $model) {
	//			//CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' $model = ' . print_r($model, true));
	//			//CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' $this->{$model} = ' . print_r($this->{$model}, true));
	//
	//			if (!empty($this->{$model})) {
	//				$this->{$model}->setDataSource(self::$__useDbConfig);
	//				//$this->{$model}->useDbConfig = self::$__useDbConfig;
	//			}
	//		}
	//
	//		//foreach ($this->_associations as $association) {
	//		//	$this->{$association}->useDbConfig = self::$__useDbConfig;
	//		//	//CakeLog::debug('NetCommonsAppModel::getDataSource() get_class($this->{$association}) = ' . get_class($this->{$association}));
	//		//}
	//	}
	//	if (!$this->_sourceConfigured && $this->useTable !== false) {
	//		$this->_sourceConfigured = true;
	//		$this->setSource($this->useTable);
	//	}
	//	CakeLog::debug('NetCommonsAppModel::getDataSource() ' . $this->plugin . ' $this->useDbConfig 2 = ' . $this->useDbConfig);
	//	return parent::getDataSource();
	//}

/**
 * Sets the DataSource to which this model is bound.
 *
 * @param string $dataSource The name of the DataSource, as defined in app/Config/database.php
 * @return void
 * @throws MissingConnectionException
 */
	public function setDataSource($dataSource = null) {
		if ($this->useDbConfig !== 'test') {
			//self::$__useDbConfig = $dataSource;
			parent::setDataSource($dataSource);
			//foreach ($this->tableToModel as $table => $model) {
			//	//CakeLog::debug('NetCommonsAppModel::setDataSource() ' . $this->plugin . ' $model = ' . print_r($model, true));
			//	//CakeLog::debug('NetCommonsAppModel::setDataSource() ' . $this->plugin . ' $this->{$model} = ' . print_r($this->{$model}, true));
			//
			//	if (!empty($this->{$model})) {
			//		//$this->{$model}->setDataSource(self::$__useDbConfig);
			//		$this->{$model}->useDbConfig = self::$__useDbConfig;
			//	}
			//}
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
 *
 * @return array The current Model::data; after merging $data and/or defaults from database
 * @link http://book.cakephp.org/2.0/en/models/saving-your-data.html#model-create-array-data-array
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function create($data = array(), $filterKey = false) {
		if (! Configure::read('NetCommons.installed') || ! class_exists('Current')) {
			return parent::create($data, $filterKey);
		}

		$options = $this->_getDefaultValue($data);
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
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
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
		//CakeLog::debug('NetCommonsAppModel::begin() ' . $this->plugin . ' $this->useDbConfig1 = ' . $this->useDbConfig);
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		//CakeLog::debug('NetCommonsAppModel::begin() ' . $this->plugin . ' $this->useDbConfig2 = ' . $this->useDbConfig);
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
 * @param mixed $ex Exception
 * @return void
 * @throws Exception
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

/**
 * 全カラムのデフォルト値をセットした配列を返す。
 *
 * @param array $data デフォルトを上書きするカラム配列
 * @return array デフォルト値をセットした配列
 */
	protected function _getDefaultValue($data) {
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

		foreach ($this->schema() as $fieldName => $fieldDetail) {
			if ($fieldName !== $this->primaryKey) {
				if (($fieldDetail['null'] === false) && ($fieldDetail['default'] === null)) {
					// not nullカラムのdefault指定がなかったら空文字にしておく。 @see https://github.com/NetCommons3/NetCommons3/issues/7
					$options[$fieldName] = '';
				} else {
					$options[$fieldName] = $fieldDetail['default'];
				}
			}

			foreach ($currents as $key => $current) {
				if ($this->hasField($key) && $fieldName === $key && !isset($data[$fieldName])) {
					$options[$fieldName] = $current;
				}
			}
		}
		return $options;
	}

}
