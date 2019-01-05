<?php
/**
 * NetCommons用キャッシュ Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');
App::uses('NetCommonsCache', 'NetCommons.Utility');

/**
 * NetCommons用キャッシュ Utility
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Model\Befavior
 */
class NetCommonsCacheBehavior extends ModelBehavior {

/**
 * キャッシュのデータ保持用
 *
 * @var array
 */
	private $__cache = [];

/**
 * ビヘイビアの設定処理
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $config $modelの設定値
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		if (! isset($this->__cache[$model->alias])) {
			$cacheName = $model->useDbConfig . '_' . $model->tablePrefix . $model->table;
			$isTest = ($model->useDbConfig === 'test');
			$this->__cache[$model->alias] = new NetCommonsCache($cacheName, $isTest);
		}
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function afterSave(Model $model, $created, $options = array()) {
		$this->cacheClear($model);
		return true;
	}

/**
 * キャッシュ変数からの読み込み
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param string $mainKey メインキー
 * @param string $subKey サブキー
 * @return array
 */
	public function cacheRead(Model $model, $mainKey, $subKey) {
		return $this->__cache[$model->alias]->read($mainKey, $subKey);
	}

/**
 * キャッシュの書き込み
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $result 結果
 * @param string $mainKey メインキー
 * @param string $subKey サブキー
 * @return void
 */
	public function cacheWrite(Model $model, $result, $mainKey, $subKey) {
		$this->__cache[$model->alias]->write($result, $mainKey, $subKey);
	}

/**
 * キャッシュからの読み込み
 * もし、キャッシュに無ければ、findで取得し、キャッシュに登録する。
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param string $type find()の取得種別
 * @param array $queryOptions find()のクエリオプション
 * @return array|false
 */
	public function cacheFindQuery(Model $model, $type, $queryOptions) {
		$cacheKey = md5(json_encode($queryOptions));
		$result = $this->cacheRead($model, $type, $cacheKey);
		if (! $result) {
			//キャッシュの書き込み
			$result = $model->find($type, $queryOptions);
			$this->cacheWrite($model, $result, $type, $cacheKey);
		}
		return $result;
	}

/**
 * キャッシュのクリア
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @return void
 */
	public function cacheClear(Model $model) {
		$this->__cache[$model->alias]->clear();
	}

}
