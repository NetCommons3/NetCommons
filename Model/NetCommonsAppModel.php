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
 * @codeCoverageIgnore
 */
class NetCommonsAppModel extends Model {

/**
 * use useDbConfig
 *
 * @var array
 */
//	public static $__useDbConfig;

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
//		self::$__useDbConfig = $_useDbConfig;

		parent::__construct($id, $table, $ds);
	}

/**
 * Gets the DataSource to which this model is bound.
 *
 * @return DataSource A DataSource object
 */
//	public function getDataSource() {
//CakeLog::debug('NetCommonsAppModel::getDataSource() $this->useDbConfig = ' . $this->useDbConfig);
//CakeLog::debug('NetCommonsAppModel::getDataSource() get_class($this) = ' . get_class($this));
//		if ($this->useDbConfig !== 'test') {
//			$this->useDbConfig = self::$__useDbConfig;
//CakeLog::debug('NetCommonsAppModel::getDataSource() $this->_associations = ' . print_r($this->associations(), true));
////			foreach ($this->_associations as $assoc) {
////				if (!empty($this->{$assoc})) {
////					$models = array_keys($this->{$assoc});
////					foreach ($models as $m) {
////CakeLog::debug('NetCommonsAppModel::getDataSource() $this->$m = ' . print_r(get_class($this->$m), true));
//////						$this->{$m}->useDbConfig = self::$__useDbConfig;
////					}
////				}
////			}
//
////			foreach ($this->_associations as $association) {
////				$this->{$association}->useDbConfig = self::$__useDbConfig;
////CakeLog::debug('NetCommonsAppModel::getDataSource() get_class($this->{$association}) = ' . get_class($this->{$association}));
////			}
//		}
//		if (!$this->_sourceConfigured && $this->useTable !== false) {
//			$this->_sourceConfigured = true;
//			$this->setSource($this->useTable);
//		}
//		return parent::getDataSource();
//	}

/**
 * Sets the DataSource to which this model is bound.
 *
 * @param string $dataSource The name of the DataSource, as defined in app/Config/database.php
 * @return void
 * @throws MissingConnectionException
 */
	public function setDataSource($dataSource = null) {
		if ($this->useDbConfig !== 'test') {
//			self::$__useDbConfig = $dataSource;
			parent::setDataSource(self::$__useDbConfig);
		}
	}

/**
 * transaction begin
 *
 * @return void
 */
	public function begin() {
//CakeLog::debug('NetCommonsAppModel::begin() ' . $this->useDbConfig);
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
	public function rollback() {
		$dataSource = $this->getDataSource();
		$dataSource->rollback();
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
 * Checks that a string contains something other than whitespace
 *
 * Returns true if string contains something other than whitespace
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param string|array $check Value to check
 * @return bool Success
 */
	public static function notBlank($check) {
		//暫定、version 2.7対応。ただし、2.7にバージョンアップした際に削除する
		if (! method_exists('Validation', 'notBlank')) {
			//version 2.7以前
			return Validation::notEmpty($check);
		} elseif (is_array($check)) {
			return Validation::notBlank(array_shift($check));
		} else {
			return Validation::notBlank($check);
		}
	}

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		//暫定、version 2.7対応。ただし、2.7にバージョンアップした際に削除する
		if (method_exists('Validation', 'notBlank')) {
			$repValidate = 'notBlank';
			$setValidate = 'notEmpty';
		} else {
			$repValidate = 'notEmpty';
			$setValidate = 'notBlank';
		}

		foreach (array_keys($this->validate) as $field) {
			if (isset($this->validate[$field]['rule'])) {
				continue;
			}

			foreach ($this->validate[$field] as $rule => $validate) {
				if ($rule === $setValidate) {
					$this->validate[$field][$repValidate] = $validate;
					$this->validate[$field][$repValidate]['rule'] = array($repValidate);
					unset($this->validate[$field][$rule]);
				}
			}
		}
		return parent::beforeValidate($options);
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
