<?php
/**
 * NetCommons用TreeBehavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * NetCommons用TreeBehavior
 *
 * CakePHPのTreeビヘイビアが大量データにあるとパフォーマンスが悪いので、
 * NetCommons用にTreeビヘイビアを改良する
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Befavior
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NetCommonsTreeBehavior extends ModelBehavior {

/**
 * 桁数
 *
 * @var array
 */
	const NUMBER_OF_DIGITS = '8';

/**
 * ソートキーのプレフィクス
 *
 * @var array
 */
	const SORT_KEY_PREFIX = '~';

/**
 * ソートキーのプレフィクス
 *
 * @var array
 */
	const SORT_KEY_SEPARATOR = '-';

/**
 * Errors
 *
 * @var array
 */
	public $errors = array();

/**
 * デフォルト値
 *
 * @var array
 */
	protected $_defaults = array(
		'parent' => 'parent_id',
		//'left' => 'lft', 'right' => 'rght',
		'weight' => 'weight',
		'sort_key' => 'sort_key',
		'child_count' => 'child_count',
		'scope' => '1 = 1', 'recursive' => -1,
		//'type' => 'nested',
		//'__parentChange' => false
	);

/**
 * エスケープしたカラム名
 *
 * @var array
 */
	protected $_escapeFields = array(
		'id' => null,
		'parent' => null,
		'sort_key' => null,
		'weight' => null,
		'child_count' => null,
	);

/**
 * Used to preserve state between delete callbacks.
 *
 * @var array
 */
	//protected $_deletedRow = array();

/**
 * TreeBehaviorのセットアップ
 *
 * @param Model $model 使用するModel
 * @param array $config 設定値
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$settings = $config + $this->_defaults;

		$this->_escapeFields[$model->alias]['id'] = $model->escapeField($model->primaryKey);
		if (isset($settings['parent'])) {
			$this->_escapeFields[$model->alias]['parent'] = $model->escapeField($settings['parent']);
		}
		if (isset($settings['weight'])) {
			$this->_escapeFields[$model->alias]['weight'] = $model->escapeField($settings['weight']);
		}
		if (isset($settings['sort_key'])) {
			$this->_escapeFields[$model->alias]['sort_key'] = $model->escapeField($settings['sort_key']);
		}
		if (isset($settings['child_count'])) {
			$this->_escapeFields[$model->alias]['child_count'] =
										$model->escapeField($settings['child_count']);
		}

		$this->settings[$model->alias] = $settings;
	}

/**
 * 保存する前に呼び出されるメソッド
 *
 * parentフィールドが$model->dataに含まれている場合にのみ、
 * tree用に$model->dataのweight,child_count,sort_keyをセットし、
 * また、親、子をのweight,child_count,sort_keyを更新する。
 *
 * #### CakePHPのTreeBehaviorと異なる点
 * lft,rghtが$model->dataにセットしてあったものをそのまま
 *
 * @param Model $model 呼び出し元のModel
 * @param array $options Model::save()から渡されるオプション
 * @return bool
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$weightField = $settings['weight'];
		$sortKeyField = $settings['sort_key'];
		$childCountField = $settings['child_count'];
		$parentField = $settings['parent'];

		$parentIsSet = array_key_exists($parentField, $model->data[$model->alias]);
		if (! $parentIsSet) {
			return true;
		}
		$parentId = $model->data[$model->alias][$parentField];

		if (! $model->id) {
			$created = true;
		} else {
			$target = $this->_getById($model, $model->id);
			$created = !(bool)$target;
		}

		if ($created) {
			//新規データの場合
			//・親データ取得
			if ($model->data[$model->alias][$parentField]) {
				$parentNode = $this->_getById($model, $parentId);
				if (! $parentNode) {
					return false;
				}
				$parentSortKey = $parentNode[$model->alias]['sort_key'];
			} else {
				$parentSortKey = null;
			}

			//・対象のレコードのweight,sort_keyをセットする
			$weight = $this->_getMaxWeight($model, $parentId) + 1;
			$model->data[$model->alias][$weightField] = $weight;

			$sortKey = $this->_convertWeightToSortKey($weight, $parentSortKey, true);
			$model->data[$model->alias][$sortKeyField] = $sortKey;

			//・移動先の親のchild_countを増やす
			$this->_updateParentCount($model, $sortKey, 1);
		} else {
			//既存データの場合
			$this->_addToWhitelist($model, [$parentField, $weightField, $sortKeyField, $childCountField]);
			if ($model->data[$model->alias][$parentField] !== $target[$model->alias][$parentField]) {
				//親IDが異なる場合、移動するので、各weightやsort_keyの振り直し
				$targetChildCount = $target[$model->alias][$childCountField] + 1;
				$childIds = $this->_getChildIds($model, $target);

				//・移動先のIDが自分の子供（入れ子になる）の場合、falseを返す。
				if (in_array($parentId, $childIds, true)) {
					return false;
				}

				//・既存の親のchild_countを減らす
				$this->_updateParentCount(
					$model,
					$target[$model->alias][$sortKeyField], -1 * $targetChildCount
				);

				//・番号を詰める処理を実行
				$from = $target[$model->alias][$settings['weight']] + 1;
				$to = null;
				$order = $escapeFields['weight'] . ' asc';
				$incrementNumber = -1;
				$this->_incrementWeight(
					$model, $target[$model->alias][$settings['parent']], $order, $from, $to, $incrementNumber
				);

				//・移動先の親データ取得
				if ($model->data[$model->alias][$parentField]) {
					$parentNode = $this->_getById($model, $parentId);
					if (! $parentNode) {
						return false;
					}
					$parentSortKey = $parentNode[$model->alias]['sort_key'];
				} else {
					$parentSortKey = null;
				}

				//・対象のレコードのweight,sort_keyをセットする
				$weight = $this->_getMaxWeight($model, $parentId) + 1;
				$model->data[$model->alias][$weightField] = $weight;

				$sortKey = $this->_convertWeightToSortKey($weight, $parentSortKey, true);
				$model->data[$model->alias][$sortKeyField] = $sortKey;

				//・対象の子たちのsort_keyを更新する
				$this->_replaceChildSortKey(
					$model,
					$target[$model->alias][$settings['sort_key']],
					$sortKey,
					[$escapeFields['id'] => $childIds]
				);

				//・移動先の親のchild_countを増やす
				$this->_updateParentCount(
					$model, $sortKey, $targetChildCount,
					[$escapeFields['id'] . ' !=' => $target[$model->alias][$model->primaryKey]]
				);
			}
		}

		return true;
	}

/**
 * Stores the record about to be deleted.
 *
 * This is used to delete child nodes in the afterDelete.
 *
 * @param Model $model Model using this behavior.
 * @param bool $cascade If true records that depend on this record will also be deleted
 * @return bool
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeDelete(Model $model, $cascade = true) {
		$this->_deletedRow = $this->_getById($model, $model->id);
		return true;
	}

/**
 * After delete method.
 *
 * Will delete the current node and all children using the deleteAll method and sync the table
 *
 * @param Model $model Model using this behavior
 * @return bool true to continue, false to abort the delete
 * @throws InternalErrorException
 */
	public function afterDelete(Model $model) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$target = $this->_deletedRow;
		$this->_deletedRow[$model->alias] = null;

		//対象の子たちを削除する
		if ($target[$model->alias][$settings['child_count']] > 0) {
			$conditions = [
				$settings['scope'],
				$escapeFields['sort_key'] . ' LIKE' =>
						$target[$model->alias][$settings['sort_key']] . self::SORT_KEY_SEPARATOR . '%'
			];

			$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
			if (! $model->deleteAll($conditions, false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->resetAssociations();
		}

		//親のchild_countを減らす
		$this->_updateParentCount(
			$model,
			$target[$model->alias][$settings['sort_key']],
			-1 * ($target[$model->alias][$settings['child_count']] + 1)
		);

		//番号を詰める処理を実行
		$from = $target[$model->alias][$settings['weight']] + 1;
		$to = null;
		$order = $escapeFields['weight'] . ' asc';
		$incrementNumber = -1;
		$this->_incrementWeight(
			$model, $target[$model->alias][$settings['parent']], $order, $from, $to, $incrementNumber
		);

		return true;
	}

/**
 * 指定した親IDの最大weightを取得する
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string $parentId 親ID
 * @return int
 */
	protected function _getMaxWeight(Model $model, $parentId) {
		$escapeFields = $this->_escapeFields[$model->alias];

		$result = $model->find('first', array(
			'recursive' => -1,
			'fields' => 'MAX(' . $escapeFields['weight'] . ')',
			'conditions' => [
				$escapeFields['parent'] => $parentId,
			],
		));
		if (! $result) {
			$maxValue = 0;
		} else {
			$maxValue = array_shift($result[0]);
		}

		return $maxValue;
	}

/**
 * weightからsort_keyに変換する
 *
 * @param int $weight 順序
 * @param string|bool $sortKey ソートキー
 * @param bool $setKeyIsParent 第二引数の$sortKeyが親を指定しているか否か
 * @return string
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	protected function _convertWeightToSortKey($weight, $sortKey = false, $setKeyIsParent = false) {
		if ($sortKey) {
			if ($setKeyIsParent) {
				$parentKey = $sortKey . self::SORT_KEY_SEPARATOR;
			} else {
				$parentKey = substr($sortKey, 0, -1 * self::NUMBER_OF_DIGITS);
			}
		} else {
			$parentKey = self::SORT_KEY_PREFIX;
		}

		return $parentKey . sprintf('%0' . self::NUMBER_OF_DIGITS . 'd', (int)$weight);
	}

/**
 * 指定した親のchild_countをカウントUp(Down)する
 *
 * @param Model $model 呼び出し元のModel
 * @param string $sortKey ソートキー
 * @param int $number カウントUP値
 * @param array $addConditions 取得する追加条件
 * @return bool
 * @throws InternalErrorException
 */
	protected function _updateParentCount(Model $model, $sortKey, $number, $addConditions = []) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$sortKeys = explode(self::SORT_KEY_SEPARATOR, $sortKey);
		array_pop($sortKeys);
		if (! $sortKeys) {
			return true;
		}
		$conditions = [
			$settings['scope'],
			$escapeFields['sort_key'] => [],
		] + $addConditions;

		$sort = '';
		foreach ($sortKeys as $key) {
			if (! $sort) {
				$sort = $key;
			} else {
				$sort .= self::SORT_KEY_SEPARATOR . $key;
			}
			$conditions[$escapeFields['sort_key']][] = $sort;
		}

		$update = [
			$escapeFields['child_count'] => $escapeFields['child_count'] . ' + (' . $number . ')'
		];
		$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
		if (! $model->updateAll($update, $conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->resetAssociations();

		return true;
	}

/**
 * 指定したsort_keyを持つ子たちを新しいsort_keyに変更する
 *
 * @param Model $model 呼び出し元のModel
 * @param string $sortKey ソートキー
 * @param string $updateSortKey 更新するソートキー
 * @param array $conditions 条件配列
 * @return bool
 * @throws InternalErrorException
 */
	protected function _replaceChildSortKey(Model $model, $sortKey, $updateSortKey, $conditions) {
		$escapeFields = $this->_escapeFields[$model->alias];

		$update = [
			$escapeFields['sort_key'] => sprintf(
				"REPLACE(" . $escapeFields['sort_key'] . ", '%s', '%s')",
				$sortKey,
				$updateSortKey
			),
		];

		$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
		if (! $model->updateAll($update, $conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->resetAssociations();

		return true;
	}

/**
 * 指定した親IDの最大weightを取得する
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string $parentId 親ID
 * @param string $order SQLのorder by
 * @param int $from SQLのBETWEENのFrom
 * @param int|null $to SQLのBETWEENのTo。nullの場合、$from以降全て
 * @param int $number インクリメントする値
 * @return int
 * @throws InternalErrorException
 */
	protected function _incrementWeight(Model $model, $parentId, $order, $from, $to, $number) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$fields = [
			$escapeFields['id'],
			$escapeFields['parent'],
			$escapeFields['weight'],
			$escapeFields['sort_key'],
			$escapeFields['child_count']
		];
		if (is_null($to)) {
			$conditions = [
				$escapeFields['parent'] => $parentId,
				$escapeFields['weight'] . ' >=' => $from
			];
		} else {
			$conditions = [
				$escapeFields['parent'] => $parentId,
				sprintf($escapeFields['weight'] . ' BETWEEN %s AND %s', (int)$from, (int)$to)
			];
		}

		$incrementRows = $model->find('all', array(
			'recursive' => -1,
			'fields' => $fields,
			'conditions' => $conditions,
			'order' => $order,
		));

		foreach ($incrementRows as $incrementRow) {
			$updateWeight = $incrementRow[$model->alias][$settings['weight']] + $number;
			$updateSortKey = $this->_convertWeightToSortKey(
				$updateWeight,
				$incrementRow[$model->alias][$settings['sort_key']],
				false
			);

			if ($incrementRow[$model->alias][$settings['child_count']] > 0) {
				//詰めるデータの子たちのsort_keyを更新する
				$conditions = [
					$escapeFields['sort_key'] . ' LIKE' =>
									$incrementRow[$model->alias][$settings['sort_key']] . self::SORT_KEY_SEPARATOR . '%'
				];
				$this->_replaceChildSortKey(
					$model,
					$incrementRow[$model->alias][$settings['sort_key']],
					$updateSortKey,
					$conditions
				);
			}

			//番号を詰める
			$update = [
				$escapeFields['weight'] => $updateWeight,
				$escapeFields['sort_key'] => "'" . $updateSortKey . "'",
			];
			$conditions = [
				$escapeFields['id'] => $incrementRow[$model->alias][$model->primaryKey]
			];
			$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
			if (! $model->updateAll($update, $conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->resetAssociations();
		}

		return true;
	}

/**
 * データを取得するメソッド
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string $id 取得するID
 * @return array|bool
 */
	protected function _getById(Model $model, $id) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$fields = [
			$escapeFields['id'],
			$escapeFields['parent'],
			$escapeFields['weight'],
			$escapeFields['sort_key'],
			$escapeFields['child_count']
		];

		return $model->find('first', array(
			'recursive' => $settings['recursive'],
			'fields' => $fields,
			'conditions' => [$escapeFields['id'] => $id],
			'order' => false,
		));
	}

/**
 * データを取得するメソッド
 *
 * @param Model $model 呼び出し元のModel
 * @param array $target 対象のデータ
 * @return array
 */
	protected function _getChildIds(Model $model, $target) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		$childIds = [];
		if ($target[$model->alias][$settings['child_count']] > 0) {
			$children = $model->find('all', array(
				'recursive' => -1,
				'fields' => [$model->primaryKey],
				'conditions' => [
					$escapeFields['sort_key'] . ' LIKE' =>
							$target[$model->alias][$settings['sort_key']] . self::SORT_KEY_SEPARATOR . '%'
				],
			));
			foreach ($children as $child) {
				if (! in_array($child[$model->alias][$model->primaryKey], $childIds, true)) {
					$childIds[] = $child[$model->alias][$model->primaryKey];
				}
			}
		}

		return $childIds;
	}

/**
 * 連想配列の場合、$argからデフォルトのfind()オプションを作成するメソッド
 *
 * @param array $arg Array
 * @return array Options array
 */
	protected function _getOptions($arg) {
		return count(array_filter(array_keys($arg), 'is_string')) > 0 ?
			$arg :
			array();
	}

/**
 * 子ノードの数を取得するメソッド
 *
 * children メソッドと同様に、 childCount には列の主キー (id) の値を 渡します。
 * これにより主キーが指定されたノードの子の数が返されます。オプションの 第二引数では、
 * 直下の子ノードのみの数を返すか否かを定義できます。
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string|bool $id 検索するためのレコードのID
 * @param bool $direct 直下のノードのみを返すために true を設定します
 * @return int 指定されたノードの子の数
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::childCount
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function childCount(Model $model, $id = null, $direct = false) {
		if (is_array($id)) {
			extract(array_merge(['id' => null], $id));
		}
		if ($id === null && $model->id) {
			$id = $model->id;
		} elseif (! $id) {
			$id = null;
		}

		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		if ($direct) {
			return $model->find('count', [
				'recursive' => -1,
				'conditions' => [
					$settings['scope'],
					$escapeFields['parent'] => $id
				]
			]);
		}

		if ($id === null) {
			return $model->find('count', [
				'recursive' => -1,
				'conditions' => $settings['scope'],
			]);
		} elseif ($model->id === $id &&
				isset($model->data[$model->alias][$settings['child_count']])) {
			return $model->data[$model->alias][$settings['child_count']];
		} else {
			$data = $model->find('first', [
				'recursive' => -1,
				'fields' => [$model->primaryKey, $settings['child_count']],
				'conditions' => [
					$settings['scope'],
					$model->primaryKey => $id
				]
			]);
			if (! $data) {
				return 0;
			} else {
				return $data[$model->alias][$settings['child_count']];
			}
		}
	}

/**
 * 列の主キー(id)の値を用いて、そのアイテムの子を返すメソッド
 *
 * メソッドは列の主キー(id)の値を用いて、そのアイテムの子を返します。 デフォルトの順番はツリーに出現した順です。
 * 第二引数はオプションのパラメータで、 直下の子ノードのみを返すか否かを定義します。
 *
 * #### CakePHPのTreeBehaviorと異なる点
 * $limit, $pageについては、CakePHPのTreeBehaviorでは、取得するデータ全体に対するものであるが、
 * 本メソッドでは、子に対するものとする。
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string $id 検索するためのレコードのID
 * @param bool $direct 直下のノードのみを返すために true を設定します
 * @param string|array $fields 戻り値に含まれるフィールド名の文字列またはフィールドの配列
 * @param string $order ORDER BY の SQL 文字列
 * @param int $limit SQL の LIMIT 構文
 * @param int $page ページつけられた結果にアクセスするための引数
 * @param int $recursive 再帰的に関連付けられたモデルの深さのレベル数
 * @return array アイテムの子のデータ
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::children
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function children(Model $model, $id = null, $direct = false, $fields = null,
								$order = null, $limit = null, $page = 1, $recursive = null) {
		$options = array();
		if (is_array($id)) {
			$options = $this->_getOptions($id);
			extract(array_merge(array('id' => null), $id));
		}

		if ($id === null && $model->id) {
			$id = $model->id;
		} elseif (!$id) {
			$id = null;
		}

		$parentId = $id;

		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		if (is_null($recursive)) {
			$recursive = $settings['recursive'];
		}

		if (! $order) {
			$order = [
				$escapeFields['sort_key'] . ' asc',
			];
		}

		if ($direct) {
			$conditions = [
				$settings['scope'],
				$escapeFields['parent'] => $parentId
			];
			return $model->find(
				'all',
				compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive')
			);
		}

		if (! $parentId) {
			$conditions = $settings['scope'];
		} else {
			$current = $model->find('first', [
				'recursive' => -1,
				'fields' => [$settings['sort_key']],
				'conditions' => [
					$model->primaryKey => $parentId
				],
			]);
			$conditions = [
				$settings['scope'],
				$escapeFields['sort_key'] . ' LIKE' =>
						$current[$model->alias][$settings['sort_key']] . self::SORT_KEY_SEPARATOR . '%'
			];
		}
		$options = array_merge(
			compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive'),
			$options
		);

		return $model->find('all', $options);
	}

/**
 * spacer オプションで指定された ネストしたプレフィックスをつけて find(『list』) と似たデータを返すメソッド
 *
 * 独自のfind()呼び出しを使用する場合、generateTreeList()を直接使用するのと同じ結果を生成するために、
 * "sort_key asc"でソートする必要があることに注意してください。
 *
 * オプション($options):
 *
 * - 'keyPath': キーの文字列パス。例： 「{n}.Post.id」
 * - 'valuePath': 値の文字列パス。例： 「{n}.Post.title」
 * - 'spacer': 繰り返しの文字または文字列
 *
 * @param Model $model 呼び出し元のModel
 * @param array $results find(『all』) の実行結果
 * @param array $options 設定するオプション配列
 * @return array
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	public function formatTreeList(Model $model, $results, $options = array()) {
		if (empty($results)) {
			return array();
		}
		$defaults = array(
			'keyPath' => null,
			'valuePath' => null,
			'spacer' => '_'
		);
		$options += $defaults;

		$settings = $this->settings[$model->alias];

		if (!$options['keyPath']) {
			$options['keyPath'] = '{n}.' . $model->alias . '.' . $model->primaryKey;
		}
		list(, $keyModel, $keyField) = explode('.', $options['keyPath']);

		if (!$options['valuePath']) {
			$options['valuePath'] = '{n}.' . $model->alias . '.' . $model->displayField;
		}
		list(, $valueModel, $valueField) = explode('.', $options['valuePath']);

		$resultsList = [];
		$level = 0;
		$levelStack = [];
		foreach ($results as $i => $row) {
			if (isset($row[$keyModel]) && isset($row[$keyModel][$keyField])) {
				$key = $row[$keyModel][$keyField];
			} else {
				$key = $row[$model->alias][$model->primaryKey];
			}
			if (isset($row[$valueModel]) && isset($row[$valueModel][$valueField])) {
				$value = $row[$valueModel][$valueField];
			} else {
				$value = $row[$model->alias][$model->displayField];
			}

			$resultsList[$key] = str_repeat($options['spacer'], $level) . $value;

			if (isset($results[$i + 1])) {
				$next = $results[$i + 1];
				$parentField = $settings['parent'];
				if ($row[$model->alias][$model->primaryKey] === $next[$model->alias][$parentField]) {
					$levelStack[$row[$model->alias][$model->primaryKey]] = $level;
					$level++;
				} elseif (isset($levelStack[$next[$model->alias][$parentField]])) {
					$level = $levelStack[$next[$model->alias][$parentField]] + 1;
				} else {
					$levelStack[$row[$model->alias][$model->primaryKey]] = $level;
					$level = 0;
				}
			}
		}

		return $resultsList;
	}

/**
 * spacerオプションで指定したプレフィックスでインデントを付け構造が分かるようにした find(『list』) に似たデータを返すメソッド
 *
 * #### CakePHPのTreeBehaviorと異なる点
 *
 * $keyPathと$valuePathは、複雑なものには対応しない。必ず、{n}.Post.idのような構成にすること。
 *
 * @param Model $model 呼び出し元のModel
 * @param string|array $conditions find()と同様の検索条件オプションに使用
 * @param string $keyPath キーとして使用するフィールドのパス。例: 「{n}.Post.id」
 * @param string $valuePath ラベルに使用するフィールドのパス。例: 「{n}.Post.title」
 * @param string $spacer 各々の値の前に付ける深さを示すための文字列
 * @param int $recursive 関連付けられたレコードを取得する際の深さのレベル数
 * @return array
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::generateTreeList
 */
	public function generateTreeList(Model $model, $conditions = null, $keyPath = null,
											$valuePath = null, $spacer = '_', $recursive = null) {
		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		if (is_null($recursive)) {
			$recursive = $settings['recursive'];
		}

		$fields = null;
		if (!$keyPath && !$valuePath && $model->hasField($model->displayField)) {
			$fields = [
				$model->primaryKey, $model->displayField, $settings['parent'],
			];
		} else {
			$fields = [
				substr($keyPath, 3), substr($valuePath, 3), $model->primaryKey, $settings['parent'],
			];
		}

		$conditions = (array)$conditions;
		if ($settings['scope']) {
			$conditions[] = $settings['scope'];
		}

		$order = [
			$escapeFields['sort_key'] . ' asc',
		];

		$results = $model->find('all', compact('conditions', 'fields', 'order', 'recursive'));

		return $this->formatTreeList($model, $results, compact('keyPath', 'valuePath', 'spacer'));
	}

/**
 * 特定のノードのレベルを取得するメソッド
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string|null $id ID
 * @return int|bool
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::getLevel
 */
	public function getLevel(Model $model, $id = null) {
		if ($id === null) {
			$id = $model->id;
		}

		$settings = $this->settings[$model->alias];

		$node = $model->find('first', array(
			'recursive' => -1,
			'conditions' => [$model->primaryKey => $id],
			'fields' => [$settings['sort_key']],
			'order' => false,
		));

		if (empty($node)) {
			return false;
		}

		return substr_count($node[$model->alias][$settings['sort_key']], self::SORT_KEY_SEPARATOR);
	}

/**
 * 親ノードを返すメソッド
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string $id 読み取るレコードのID
 * @param string|array $fields 取得するフィールド
 * @param int $recursive 関連付けられたレコードを取得する際の深さのレベル数
 * @return array|bool
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::getParentNode
 */
	public function getParentNode(Model $model, $id = null, $fields = null, $recursive = null) {
		$options = array();
		if (is_array($id)) {
			$options = $this->_getOptions($id);
			extract(array_merge(array('id' => null), $id));
		}

		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		if (is_null($recursive)) {
			$recursive = $settings['recursive'];
		}

		$parent = $model->find('first', array(
			'recursive' => -1,
			'fields' => $escapeFields['parent'],
			'conditions' => [$escapeFields['id'] => $id],
			'order' => false,
		));

		if ($parent) {
			$parentId = $parent[$model->alias][$settings['parent']];
			if (! $parentId) {
				return [];
			} else {
				$options = array_merge(array(
					'recursive' => $recursive,
					'fields' => $fields,
					'conditions' => array($escapeFields['id'] => $parentId),
					'order' => false,
				), $options);

				return $model->find('first', $options);
			}
		}

		return false;
	}

/**
 * トップのノードからたどって階層化されたデータのパス (path) を返すメソッド
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string|null $id 読み取るレコードのID
 * @param string|array|null $fields フィールド名
 * @param int|null $recursive 関連付けられたレコードを取得する際の深さのレベル数
 * @return array
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::getPath
 */
	public function getPath(Model $model, $id = null, $fields = null, $recursive = null) {
		$options = array();
		if (is_array($id)) {
			$options = $this->_getOptions($id);
			extract(array_merge(array('id' => null), $id));
		}

		if (!empty($options)) {
			$fields = null;
			if (!empty($options['fields'])) {
				$fields = $options['fields'];
			}
			if (!empty($options['recursive'])) {
				$recursive = $options['recursive'];
			}
		}

		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		if (is_null($recursive)) {
			$recursive = $settings['recursive'];
		}

		$result = $model->find('first', array(
			'recursive' => $recursive,
			'fields' => [$escapeFields['sort_key']],
			'conditions' => [$escapeFields['id'] => $id],
			'order' => false,
		));
		if ($result) {
			$sortKeys = explode(self::SORT_KEY_SEPARATOR, $result[$model->alias][$settings['sort_key']]);
		} else {
			return [];
		}

		$conditions = [
			$settings['scope'],
			$escapeFields['sort_key'] => [],
		];
		$sort = '';
		foreach ($sortKeys as $sortKey) {
			if (! $sort) {
				$sort = $sortKey;
			} else {
				$sort .= self::SORT_KEY_SEPARATOR . $sortKey;
			}
			$conditions[$escapeFields['sort_key']][] = $sort;
		}

		$order = [
			$escapeFields['sort_key'] . ' asc',
		];

		$options = array_merge([
			'recursive' => $recursive,
			'fields' => $fields,
			'conditions' => $conditions,
			'order' => $order,
		], $options);

		return $model->find('all', $options);
	}

/**
 * ツリーの中で一つのノードを位置を下げるためのメソッド
 *
 * ノードが最後の子であるか、または後続ノードのない最上位ノードである場合、このメソッドはfalseを返します
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最後の位置に移動する場合はtrue
 * @return bool true on success, false on failure
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::moveDown
 */
	public function moveDown(Model $model, $id = null, $number = 1) {
		return $this->_move($model, 'down', $id, $number);
	}

/**
 * ツリーの中で一つのノードを位置を上げるためのメソッド
 *
 * ノードが最初の子である場合、または前のノードを持たない最上位ノードの場合、このメソッドはfalseを返します
 *
 * @param Model $model 呼び出し元のModel
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最初の位置に移動する場合はtrue
 * @return bool true on success, false on failure
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::moveUp
 */
	public function moveUp(Model $model, $id = null, $number = 1) {
		return $this->_move($model, 'up', $id, $number);
	}

/**
 * ツリーの中で一つのノードを位置を下げるためのメソッド
 *
 * ノードが最後の子であるか、または後続ノードのない最上位ノードである場合、このメソッドはfalseを返します
 *
 * @param Model $model 呼び出し元のModel
 * @param string $type 移動種別("up" or "down")
 * @param int|string|null $id 移動するレコードのID
 * @param int|bool $number ノードを移動する場所の数、または最後の位置に移動するための条件
 * @return bool true on success, false on failure
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	protected function _move(Model $model, $type, $id, $number) {
		if (is_array($id)) {
			extract(array_merge(array('id' => null), $id));
		}
		if (!$number) {
			return false;
		}
		if (empty($id)) {
			$id = $model->id;
		}

		$settings = $this->settings[$model->alias];
		$escapeFields = $this->_escapeFields[$model->alias];

		//対象のデータ取得
		$target = $this->_getById($model, $id);
		if (!$target) {
			return false;
		}

		//downの場合は最大値を取得、trueの場合、最上部(最下部)へ移動する
		if ($type === 'down' || $number === true) {
			$maxValue = $this->_getMaxWeight($model, $target[$model->alias][$settings['parent']]);
		}
		if ($number === true) {
			$number = $maxValue;
		}

		//対象データの子たちのID取得
		$childIds = $this->_getChildIds($model, $target);

		//移動することによって、番号を詰める
		// downもしくはupで番号を詰めるための設定値が異なるため、その設定を行う。
		if ($type === 'down') {
			$from = $target[$model->alias][$settings['weight']] + 1;
			$to = $target[$model->alias][$settings['weight']] + $number;
			$order = $escapeFields['weight'] . ' asc';
			$incrementNumber = -1;
		} else {
			$from = $target[$model->alias][$settings['weight']] - $number;
			$to = $target[$model->alias][$settings['weight']] - 1;
			$order = $escapeFields['weight'] . ' desc';
			$incrementNumber = 1;
		}
		// 番号を詰める処理を実行
		$this->_incrementWeight(
			$model, $target[$model->alias][$settings['parent']], $order, $from, $to, $incrementNumber
		);

		if ($type === 'down') {
			if ($maxValue < $target[$model->alias][$settings['weight']] + $number) {
				//CakeTreeだとExceptionにしていたが、エラーとしない
				$updateWeight = $maxValue;
			} else {
				$updateWeight = $target[$model->alias][$settings['weight']] + $number;
			}
		} else {
			if (1 > $target[$model->alias][$settings['weight']] - $number) {
				//CakeTreeだとExceptionにしていたが、エラーとしない
				$updateWeight = 1;
			} else {
				$updateWeight = $target[$model->alias][$settings['weight']] - $number;
			}
		}
		$updateSortKey = $this->_convertWeightToSortKey(
			$updateWeight,
			$target[$model->alias][$settings['sort_key']],
			false
		);

		//移動対象の子たちのsort_keyを更新する
		if ($target[$model->alias][$settings['child_count']] > 0) {
			//移動対象の子たちのsort_keyを更新する
			$conditions = [
				$escapeFields['id'] => $childIds
			];
			$this->_replaceChildSortKey(
				$model,
				$target[$model->alias][$settings['sort_key']],
				$updateSortKey,
				$conditions
			);
		}

		//移動対象のデータを更新する
		$update = [
			$escapeFields['weight'] => $updateWeight,
			$escapeFields['sort_key'] => "'" . $updateSortKey . "'",
		];
		$conditions = [
			$escapeFields['id'] => $target[$model->alias][$model->primaryKey]
		];
		$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
		if (! $model->updateAll($update, $conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		$model->resetAssociations();

		return true;
	}

/**
 * ツリーから現在のノードを削除し、すべての子を1レベル上に戻すメソッド
 *
 * NCでは、当メソッドを使う場面がないため、未対応。
 * 必要になる場面が出てきた際に、対応する
 *
 * @param Model $model Model using this behavior
 * @param int|string|null $id The ID of the record to remove
 * @param bool $delete whether to delete the node after reparenting children (if any)
 * @return bool true on success, false on failure
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::removeFromTree
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function removeFromTree(Model $model, $id = null, $delete = false) {
		return true;
	}

/**
 * 破損したツリーを復元する
 *
 * @param Model $model 呼び出し元のModel
 * @param string $mode parentのみ
 * @param null $missingParentAction 使用しない
 * @return bool true on success, false on failure
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::recover
 */
	public function recover(Model $model, $mode = 'parent', $missingParentAction = null) {
		$settings = $this->settings[$model->alias];

		if (! $model->hasField($settings['parent']) &&
				! $model->hasField($settings['weight']) &&
				! $model->hasField($settings['sort_key']) &&
				! $model->hasField($settings['child_count'])) {
			return true;
		}

		$trees = $model->find('all', [
			'recursive' => -1,
			'fields' => [$model->primaryKey, $settings['parent'], $settings['weight']],
			'order' => [
				$settings['parent'] => 'asc',
				$settings['weight'] => 'asc',
				$model->primaryKey => 'asc',
			],
		]);

		$maxWeights = $model->find('all', [
			'recursive' => -1,
			'fields' => [$settings['parent'], 'Max(' . $settings['weight'] . ')'],
			'group' => [
				$settings['parent'],
			],
		]);

		$weights = [];
		foreach ($maxWeights as $weight) {
			$parentId = (string)$weight[$model->alias][$settings['parent']];

			if (isset($weight[0]['Max(weight)'])) {
				$weights[$parentId] = (int)$weight[0]['Max(weight)'];
			} else {
				$weights[$parentId] = 0;
			}
		}

		$recovers = [];
		foreach ($trees as $tree) {
			$parentId = $tree[$model->alias][$settings['parent']];
			$primaryId = $tree[$model->alias][$model->primaryKey];

			if ($tree[$model->alias][$settings['weight']]) {
				$weight = $tree[$model->alias][$settings['weight']];
			} else {
				$weights[$parentId]++;
				$weight = $weights[$parentId];
			}

			if (! $parentId) {
				$sortKey = $this->_convertWeightToSortKey($weight, false, false);
			} else {
				if (! isset($recovers[$parentId])) {
					continue;
				}
				$sortKey = $this->_convertWeightToSortKey($weight, $recovers[$parentId]['sort_key'], true);
			}
			$recovers[$primaryId] = [
				'parent_id' => $parentId,
				'weight' => $weight,
				'sort_key' => $sortKey,
				'child_count' => 0,
			];

			$this->__countUpForRecover($recovers, $parentId);

			$weights[$parentId] = $weight;
		}

		$this->__updateRecovers($model, $recovers);

		return true;
	}

/**
 * Reorder method.
 *
 * Reorders the nodes (and child nodes) of the tree according to the field and direction specified in the parameters.
 * This method does not change the parent of any node.
 *
 * Requires a valid tree, by default it verifies the tree before beginning.
 *
 * Options:
 *
 * - 'id' id of record to use as top node for reordering
 * - 'field' Which field to use in reordering defaults to displayField
 * - 'order' Direction to order either DESC or ASC (defaults to ASC)
 * - 'verify' Whether or not to verify the tree before reorder. defaults to true.
 *
 * @param Model $model Model using this behavior
 * @param array $options array of options to use in reordering.
 * @return bool true on success, false on failure
 * @link https://book.cakephp.org/2.0/en/core-libraries/behaviors/tree.html#TreeBehavior::reorder
 */
	public function reorder(Model $model, $options = array()) {
		return true;
	}

/**
 * Check if the current tree is valid.
 *
 * Returns true if the tree is valid otherwise an array of (type, incorrect left/right index, message)
 *
 * @param Model $model Model using this behavior
 * @return mixed true if the tree is valid or empty, otherwise an array of (error type [index, node], [incorrect left/right index,node id], message)
 * @link https://book.cakephp.org/2.0/ja/core-libraries/behaviors/tree.html#TreeBehavior::verify
 */
	public function verify(Model $model) {
		return true;
	}

/**
 * CakeのTreeビヘイビアからNC用のTreeビヘイビアのデータ構成にマイグレーションする
 *
 * @param Model $model Model using this behavior
 * @param array $cakeFileds CakeTreeのため
 * @return bool
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function migration(Model $model, $cakeFileds = ['left' => 'lft', 'right' => 'rght']) {
		$settings = $this->settings[$model->alias];

		if (! $model->hasField($settings['parent']) &&
				! $model->hasField($cakeFileds['left']) &&
				! $model->hasField($cakeFileds['right']) &&
				! $model->hasField($settings['weight']) &&
				! $model->hasField($settings['sort_key']) &&
				! $model->hasField($settings['child_count'])) {
			return true;
		}

		$cakeTrees = $model->find('all', [
			'recursive' => -1,
			'fields' => [$model->primaryKey, $settings['parent']],
			'order' => [
				$cakeFileds['left'] => 'asc'
			],
		]);

		$migratios = [];
		$weights = [];
		foreach ($cakeTrees as $cake) {
			$parentId = $cake[$model->alias][$settings['parent']];
			$primaryId = $cake[$model->alias][$model->primaryKey];

			if (isset($weights[$parentId])) {
				$weight = $weights[$parentId];
			} else {
				$weight = 0;
			}
			$weight++;

			if (! $parentId) {
				$sortKey = $this->_convertWeightToSortKey($weight, false, false);
			} else {
				if (! isset($migratios[$parentId])) {
					continue;
				}
				$sortKey = $this->_convertWeightToSortKey($weight, $migratios[$parentId]['sort_key'], true);
			}
			$migratios[$primaryId] = [
				'parent_id' => $parentId,
				'weight' => $weight,
				'sort_key' => $sortKey,
				'child_count' => 0,
			];

			$this->__countUpForRecover($migratios, $parentId);

			$weights[$parentId] = $weight;
		}

		$this->__updateRecovers($model, $migratios);

		return true;
	}

/**
 * 子供の件数のUP
 *
 * @param array &$recovers データ配列
 * @param int $parentId 親ID
 * @return void
 */
	private function __countUpForRecover(&$recovers, $parentId) {
		if (! $parentId) {
			return;
		}
		if (isset($recovers[$parentId])) {
			$recovers[$parentId]['child_count']++;
		}
		$this->__countUpForRecover($recovers, $recovers[$parentId]['parent_id']);
	}

/**
 * CakeのTreeビヘイビアからNC用のTreeビヘイビアのデータ構成にマイグレーションする
 *
 * @param Model $model Model using this behavior
 * @param array $recovers リカバリーデータ
 * @return bool
 * @throws InternalErrorException
 */
	private function __updateRecovers(Model $model, $recovers) {
		$escapeFields = $this->_escapeFields[$model->alias];

		$model->unbindModel(['belongsTo' => array_keys($model->belongsTo)]);
		foreach ($recovers as $primaryId => $recover) {
			$update = [
				$escapeFields['weight'] => $recover['weight'],
				$escapeFields['sort_key'] => '\'' . $recover['sort_key'] . '\'',
				$escapeFields['child_count'] => $recover['child_count'],
			];
			$conditions = [
				$escapeFields['id'] => $primaryId
			];
			if (! $model->updateAll($update, $conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
		$model->resetAssociations();

		return true;
	}

}
