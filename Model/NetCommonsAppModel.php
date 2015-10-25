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
 * CakePHPのModelクラスを継承してます。<br>
 * ドキュメントルートのapp.Mode.AppModelはこのクラスを継承しているので、<br>
 * 全モデルの基底クラスになります。<br>
 * Overrideしているメソッドもあり、CakePHPの通常動作と異なるものがありますので注意して下さい。
 *
 * #### CakePHPのModel処理をOverrideしているメソッドです。
 * [__construct](#__construct)<br>
 * [setDataSource](#setdatasource)<br>
 * [create](#create)<br>
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
 * Constructor. DataSourceの選択
 *
 * 接続先DBをランダムに選択します。
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
 * Sets the DataSource to which this model is bound.<br>
 * データの書き込み時はMaterDBに対して行うため、接続先DBを変更しているが、<br>
 * Test実行時は唯一のDBに対して行うようにOverrideしています。
 *
 * @param string $dataSource The name of the DataSource, as defined in app/Config/database.php
 * @return void
 */
	public function setDataSource($dataSource = null) {
		$oldConfig = $this->useDbConfig;
		if ($dataSource) {
			//MasterDBに切り替え処理
			$this->__setMasterDataSource();
		}

		$db = ConnectionManager::getDataSource($this->useDbConfig);
		if (!empty($oldConfig) && isset($db->config['prefix'])) {
			$oldDb = ConnectionManager::getDataSource($oldConfig);

			if (!isset($this->tablePrefix) || (!isset($oldDb->config['prefix']) || $this->tablePrefix === $oldDb->config['prefix'])) {
				$this->tablePrefix = $db->config['prefix'];
			}
		} elseif (isset($db->config['prefix'])) {
			$this->tablePrefix = $db->config['prefix'];
		}

		$schema = $db->getSchemaName();

		$defaultProperties = get_class_vars(get_class($this));
		if (isset($defaultProperties['schemaName'])) {
			$schema = $defaultProperties['schemaName'];
		}
		$this->schemaName = $schema;
	}

/**
 * MasterDBに切り替える処理
 *
 * @return void
 */
	private function __setMasterDataSource() {
		if (! Configure::read('NetCommons.installed')) {
			$this->useDbConfig = 'master';
			return;
		}
		if (Configure::read('useDbConfig') === 'master' && $this->useDbConfig !== 'test') {
			if ($this->useDbConfig !== 'master') {
				$this->useDbConfig = 'master';
			}

			$associations = Hash::merge(
				array_keys($this->hasOne),
				array_keys($this->hasMany),
				array_keys($this->belongsTo),
				array_keys($this->hasAndBelongsToMany)
			);

			foreach ($associations as $btModelName) {
				$this->{$btModelName}->useDbConfig = $this->useDbConfig;
			}
		}
	}

/**
 * NetCommonsで使用する共通の値がセットされた結果を返します。<br>
 * CakePHPのSchemaは、not null指定されたカラムのdefaultがnullになっているため、<br>
 * ''(長さ0の文字列)に書き換えています。<br>
 * https://github.com/NetCommons3/NetCommons3/issues/7
 *
 * #### セットされるデータ
 * ```
 * 'room_id' => Current::read('Room.id'),
 * 'language_id' => Current::read('Language.id'),
 * 'block_id' => Current::read('Block.id'),
 * 'block_key' => Current::read('Block.key'),
 * 'frame_id' => Current::read('Frame.id'),
 * 'frame_key' => Current::read('Frame.key'),
 * 'plugin_key' => Inflector::underscore($this->plugin),
 * ```
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
		if ($data !== null && $data !== false) {
			$options = $this->_getDefaultValue($data);
			$data = Hash::merge($options, $data);
		}

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
		Configure::write('useDbConfig', 'master');
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
 * @return void
 */
	public function loadModels(array $models = []) {
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class, true);
			//if ($this->$model->useDbConfig !== 'test') {
			//	$this->$model->setDataSource($source);
			//}
		}
	}

/**
 * 全カラムのデフォルト値をセットした配列を返す。
 *
 * @param array $data デフォルトを上書きするカラム配列
 * @return array デフォルト値をセットした配列
 */
	protected function _getDefaultValue($data) {
		$options = array();

		$currents = array();
		if (class_exists('Current')) {
			$currents = array(
				'room_id' => Current::read('Room.id'),
				'language_id' => Current::read('Language.id'),
				'block_id' => Current::read('Block.id'),
				'block_key' => Current::read('Block.key'),
				'frame_id' => Current::read('Frame.id'),
				'frame_key' => Current::read('Frame.key'),
				'plugin_key' => Inflector::underscore($this->plugin),
			);
		}

		foreach ($this->schema() as $fieldName => $fieldDetail) {
			if ($fieldName !== $this->primaryKey) {
				if (($fieldDetail['null'] === false) && ($fieldDetail['default'] === null)) {
					// not nullカラムのdefault指定がなかったら空文字にしておく。 @see https://github.com/NetCommons3/NetCommons3/issues/7
					$options[$fieldName] = '';
				} else {
					$options[$fieldName] = $fieldDetail['default'];
				}
			}
			// Currentの値をセット
			if (isset($currents[$fieldName])) {
				$options[$fieldName] = $currents[$fieldName];
			}
		}
		return $options;
	}
}
