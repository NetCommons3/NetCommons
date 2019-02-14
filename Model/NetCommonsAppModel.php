<?php
/**
 * NetCommonsApp Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
 * [__construct](#method___construct)<br>
 * [getDataSource](#method_getDataSource)<br>
 * [create](#method_create)<br>
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Takako Miyagawa <nekoget@gmail.com>
 * @package NetCommons\NetCommons\Model
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class NetCommonsAppModel extends Model {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
		'NetCommons.NetCommonsValidationRule',
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * 接続先DB　master slave変更用
 *
 * @var string
 */
	private static $__changeDbConfig;

/**
 * 接続先DB　古いslave保存用
 *
 * @var string
 */
	private static $__oldSlaveDbConfig;

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * ブロックId
 * Behaviorで関連データ削除する際に使用する
 *
 * @var string
 */
	public $blockId = null;

/**
 * ブロックKey
 * Behaviorで関連データ削除する際に使用する
 *
 * @var string
 */
	public $blockKey = null;

/**
 * コンテンツKey
 * Behaviorで関連データ削除する際に使用する
 *
 * @var string
 */
	public $contentKey = null;

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
		if (Hash::get((array)$id, 'testing') && $this->useDbConfig !== 'test') {
			$this->useDbConfig = 'test';
		}

		// Use a static variable, to only use one connection per page-call (otherwise we would get a new handle every time a Model is created)
		static $_useDbConfig;
		if (!isset($_useDbConfig)) {
			$_useDbConfig = $this->__getRandomlySlave();
		}
		$this->useDbConfig = $_useDbConfig;

		//actsAsをマージする
		$this->_mergeVars(['actsAs'], get_class(), false);

		parent::__construct($id, $table, $ds);
	}

/**
 * Find the slaves we have
 *
 * @return string The name of the DataSource, as defined in app/Config/database.php
 */
	private function __getRandomlySlave() {
		if ($this->useDbConfig === 'test') {
			return $this->useDbConfig;
		}

		//Master<->Slaveは全体的に見直しが必要。

		//// Get all available database-configs
		//$sources = ConnectionManager::enumConnectionObjects();
		//
		//// Find the slaves we have
		//$slaves = array();
		//foreach ($sources as $name => $values) {
		//	unset($values);
		//	// Slaves have to be named "slave1", "slave2", etc...
		//	if (preg_match('/^slave[0-9]+$/i', $name) == 1) {
		//		$slaves[] = $name;
		//	}
		//}
		//
		//// Randomly use a slave
		////$dataSource = (count($slaves) !== 0) ? $slaves[rand(0, count($slaves) - 1)] : 'master';

		$dataSource = 'master';
		return $dataSource;
	}

/**
 * Masterの接続先に変更する。
 *
 * @return void
 */
	public function setMasterDataSource() {
		self::$__changeDbConfig = 'master';
	}

/**
 * 以前のSlaveの接続先に戻す。なければ、ランダムに選択
 *
 * @return void
 */
	public function setSlaveDataSource() {
		if (self::$__oldSlaveDbConfig) {
			self::$__changeDbConfig = self::$__oldSlaveDbConfig;
			return;
		}
		self::$__changeDbConfig = $this->__getRandomlySlave();
	}

/**
 * Gets the DataSource to which this model is bound.
 *
 * @return DataSource A DataSource object
 */
	public function getDataSource() {
		// MasterDBに切り替え処理
		$this->__changeDataSource();

		return parent::getDataSource();
	}

/**
 * MasterDBに切り替える処理
 *
 * @return void
 */
	private function __changeDataSource() {
		if (!empty(self::$__changeDbConfig) &&
				self::$__changeDbConfig !== $this->useDbConfig && $this->useDbConfig !== 'test') {
			self::$__oldSlaveDbConfig = $this->useDbConfig;
			$this->useDbConfig = self::$__changeDbConfig;
			$this->_sourceConfigured = false;
			//self::$__changeDbConfig = null;

			$associations = Hash::merge(
				array_keys($this->hasOne),
				array_keys($this->hasMany),
				array_keys($this->belongsTo),
				array_keys($this->hasAndBelongsToMany)
			);
			foreach ($associations as $btModelName) {
				$this->{$btModelName}->useDbConfig = $this->useDbConfig;
				if ($this->{$btModelName}->useTable !== false) {
					$this->{$btModelName}->setSource($this->{$btModelName}->useTable);
				}
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
		if ($data !== null && $data !== false && $this->useTable !== false) {
			if (empty($data[$this->alias])) {
				$data = $this->_setAliasData($data);
			}

			$options = $this->_getDefaultValue();
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
		$newRecord = $this->create($data, $filterKey);
		$associations = Hash::merge(
			array_keys($this->hasOne),
			array_keys($this->belongsTo)
		);
		foreach ($associations as $model) {
			if ($model === 'TrackableCreator' || $model === 'TrackableUpdater') {
				continue;
			}

			if (isset($data[$model])) {
				$options = $data[$model];
			} else {
				$options = array();
			}
			$newRecord = Hash::merge($newRecord, $this->$model->create($options, $filterKey));
		}

		return $newRecord;
	}

/**
 * transaction begin
 *
 * @return void
 */
	public function begin() {
		$this->setMasterDataSource();
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
			//if ($this->useDbConfig !== 'test') {
			//	CakeLog::error($ex);
			//}
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
			$this->$model = ClassRegistry::init([
				'class' => $class,
				'testing' => ($this->useDbConfig === 'test')
			], true);
			if (is_object($this->$model)) {
				if ($this->$model->useDbConfig === 'test' && $this->useDbConfig !== 'test') {
					$this->setDataSource($this->$model->useDbConfig);
				}
			}
			//if ($this->$model->useDbConfig !== 'test') {
			//	$this->$model->setDataSource($source);
			//}
		}
	}

/**
 * 全カラムのデフォルト値をセットした配列を返す。
 *
 * @return array デフォルト値をセットした配列
 */
	protected function _getDefaultValue() {
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
					// not nullカラムのdefault指定がなかったら空文字にしておく。
					// @see https://github.com/NetCommons3/NetCommons3/issues/7
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

		$options = $this->_setAliasData($options);
		return $options;
	}

/**
 * cakephpの登録処理をオーバーライド
 *
 * cakephpのsave時にcreated,modifiedの項目にセットする時間が、date_default_timezone_setに影響してしまうため、
 * 登録直前にUTCに変更し、登録後にdate_default_timezone_setを元に戻すため、オーバライドする
 *
 * @param array $data Data to save.
 * @param array $options can have following keys:
 *
 *   - validate: Set to true/false to enable or disable validation.
 *   - fieldList: An array of fields you want to allow for saving.
 *   - callbacks: Set to false to disable callbacks. Using 'before' or 'after'
 *      will enable only those callbacks.
 *   - `counterCache`: Boolean to control updating of counter caches (if any)
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws PDOException
 * @link https://book.cakephp.org/2.0/en/models/saving-your-data.html
 */
	protected function _doSave($data = null, $options = array()) {
		$nowDefaultTz = date_default_timezone_get();

		date_default_timezone_set('UTC');
		$result = parent::_doSave($data, $options);
		date_default_timezone_set($nowDefaultTz);

		return $result;
	}

/**
 * Findの結果をキャッシュする際、afterFindは実行させたいので、CakeのModelを継承して、カスタマイズする。
 *
 * @param string $type Type of find operation (all / first / count / neighbors / list / threaded)
 * @param array $query Option fields (conditions / fields / joins / limit / offset / order / page / group / callbacks)
 * @return array
 * @see Model::_readDataSource()
 */
	protected function _readDataSource($type, $query) {
		if (! $this->Behaviors->enabled('NetCommons.NetCommonsCache') ||
				! isset($query['cacheKey'])) {
			//キャッシュを使用しない場合、親のメソッドを呼ぶ
			return parent::_readDataSource($type, $query);
		} else {
			//キャッシュを使用する場合、キャッシュの有無を確かめ、
			//キャッシュがあれば、キャッシュの内容を使用し、無ければ、DBから取得する。
			//その後の処理は、親と同じ処理。
			$results = $this->cacheRead($type, $query['cacheKey']);
			if (! $results) {
				$results = $this->getDataSource()->read($this, $query);
				$this->cacheWrite($results, $type, $query['cacheKey']);
			}
			$this->resetAssociations();

			if ($query['callbacks'] === true || $query['callbacks'] === 'after') {
				$results = $this->_filterResults($results);
			}

			$this->findQueryType = null;

			if ($this->findMethods[$type] === true) {
				return $this->{'_find' . ucfirst($type)}('after', $query, $results);
			}
		}
	}

}
