<?php
/**
 * Hashユーティリティの速度改善テスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Hashユーティリティの速度改善テスト
 *
 * コメントアウトを外して、速度調査を行うことができる
 * app/Testに移動したいが、エラーが出るため、NetCommonsプラグインに置く。
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Utility\Hash
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HashSpeedupTest extends CakeTestCase {

/**
 * データ
 *
 * @var array
 */
	private $__data = [];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//大量データ作成
		if (! $this->__data) {
			for ($i = 1; $i <= 10; $i++) {
				$this->__data['AAAAAA'][$i] = [
					'key' => 'aaaaa_key_' . $i,
					'value' => 'aaaaa_value_' . $i,
					'category' => 'aaaaa_value_' . ($i % 10),
					'child' => [
						'key' => 'child_aaaaa_key_' . $i,
						'value' => 'child_aaaaa_value_' . $i,
						'grandchild' => [
							'111111', '222222', '333333', '4444444',
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i . '_1',
							],
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i . '_2',
							],
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i . '_3',
							],
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i . '_4',
							],
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i . '_5',
							],
						],
					]
				];
				$this->__data['AAAAAA' . $i] = [
					'key' => 'aaaaa_key_' . $i,
					'value' => 'aaaaa_value_' . $i,
					'child' => [
						'key' => 'child_aaaaa_key_' . $i,
						'value' => 'child_aaaaa_value_' . $i,
						'grandchild' => [
							'111111', '222222', '333333', '4444444',
							[
								'key' => 'grandchild_aaaaa_key_' . $i,
								'value' => 'grandchild_aaaaa_value_' . $i,
							]
						],
					]
				];
			}
		}
	}

/**
 * Hash::get()のテスト
 *
 * @return void
 */
	public function testGet() {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);
			Hash::get($this->__data, 'AAAAAA.10.child.grandchild.4.key');
			$etime = microtime(true);
			debug($etime - $stime);
		}

		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);
			Hash::get($this->__data, 'AAAAAA10.child.grandchild.4.key');
			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::expand()のテスト
 *
 * @return void
 */
	public function testExpand() {
		for ($i = 0; $i < 5; $i++) {
			$test = [
				'0.key' => 'aaaaa_key_10',
				'0.value' => 'aaaaa_value_10',
				'0.child.key' => 'child_aaaaa_key_10',
				'0.child.value' => 'child_aaaaa_value_10',
				'0.child.grandchild.key' => 'grandchild_aaaaa_key_10',
				'0.child.grandchild.value' => 'grandchild_aaaaa_value_10',
				'1.key' => 'aaaaa_key_500',
				'1.value' => 'aaaaa_value_500',
				'1.child.key' => 'child_aaaaa_key_500',
				'1.child.value' => 'child_aaaaa_value_500',
				'1.child.grandchild.key' => 'grandchild_aaaaa_key_500',
				'1.child.grandchild.value' => 'grandchild_aaaaa_value_500',
			];

			$stime = microtime(true);
			Hash::expand($test);
			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::extract()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProviderForExtract() {
		return [
			0 => [
				'pathKey' => 'AAAAAA.10.child.grandchild.{n}.key',
			],
			1 => [
				'pathKey' => 'AAAAAA.{n}.child.grandchild.{n}.key',
				'expected' => null,
			],
			2 => [
				'pathKey' => 'AAAAAA.10.child.grandchild.{n}[key=grandchild_aaaaa_key_10]',
			],
			3 => [
				'pathKey' => 'AAAAAA.{n}.child.grandchild.{n}[key=grandchild_aaaaa_key_10]',
			],
		];
	}

/**
 * Hash::extract()のテスト
 *
 * @param string $pathKey HashのパスKey
 * @return void
 * @dataProvider dataProviderForExtract
 */
	public function testExtract($pathKey) {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);
			Hash::extract($this->__data, $pathKey);
			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::combine()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProviderForCombine() {
		return [
			0 => [
				'model' => null,
				'keyPath' => 'AAAAAA.10.child.grandchild.{n}.value',
				'valuePath' => 'AAAAAA.10.child.grandchild.{n}[key]',
				'groupPath' => null,
			],
			1 => [
				'model' => null,
				'keyPath' => 'AAAAAA.{n}.key',
				'valuePath' => 'AAAAAA.{n}',
				'groupPath' => null,
			],
			2 => [
				'model' => 'AAAAAA',
				'keyPath' => '{n}.key',
				'valuePath' => '{n}',
				'groupPath' => null,
			],
			3 => [
				'model' => 'AAAAAA',
				'keyPath' => '{n}.key',
				'valuePath' => null,
				'groupPath' => null,
			],
			4 => [
				'model' => 'AAAAAA',
				'keyPath' => '{n}.key',
				'valuePath' => '{n}',
				'groupPath' => '{n}.category',
			],
			5 => [
				'model' => null,
				'keyPath' => '{s}.{n}.key',
				'valuePath' => '{s}.{n}',
				'groupPath' => null,
			],
			6 => [
				'model' => 'AAAAAA',
				'keyPath' => '{n}.key',
				'valuePath' => '{n}.value',
				'groupPath' => null,
			],
		];
	}

/**
 * Hash::combine()のテスト
 *
 * @param string $model モデル名
 * @param string $keyPath combineのkeyで使用するpathKey
 * @param string $valuePath combineのvalueで使用するpathKey
 * @param string $groupPath combineの結果をgroup化するためのpathKey
 * @return void
 * @dataProvider dataProviderForCombine
 */
	public function testCombine($model, $keyPath, $valuePath, $groupPath) {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);

			if ($model) {
				Hash::combine($this->__data[$model], $keyPath, $valuePath, $groupPath);
			} else {
				Hash::combine($this->__data, $keyPath, $valuePath, $groupPath);
			}

			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::merge()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProviderForMerge() {
		return [
			0 => [
				'merge' => [
					'AAAAAA' => [
						10000 => [
							'key' => 'aaaaa_key_' . 10000,
							'value' => 'aaaaa_value_' . 10000,
							'category' => 'aaaaa_value_' . (10000 % 10),
							'child' => [
								'key' => 'child_aaaaa_key_' . 10000,
								'value' => 'child_aaaaa_value_' . 10000,
								'grandchild' => [
									'111111', '222222', '333333', '4444444',
									[
										'key' => 'grandchild_aaaaa_key_' . 10000,
										'value' => 'grandchild_aaaaa_value_' . 10000 . '_1',
									],
									[
										'key' => 'grandchild_aaaaa_key_' . 10000,
										'value' => 'grandchild_aaaaa_value_' . 10000 . '_2',
									],
									[
										'key' => 'grandchild_aaaaa_key_' . 10000,
										'value' => 'grandchild_aaaaa_value_' . 10000 . '_3',
									],
									[
										'key' => 'grandchild_aaaaa_key_' . 10000,
										'value' => 'grandchild_aaaaa_value_' . 10000 . '_4',
									],
									[
										'key' => 'grandchild_aaaaa_key_' . 10000,
										'value' => 'grandchild_aaaaa_value_' . 10000 . '_5',
									],
								],
							]
						]
					]
				],
			],
			1 => [
				'merge' => [
					'AAAAAA' => [
						100 => [
							'value' => 'aaaaa_value_' . 10000,
							'child' => [
								'value' => 'child_aaaaa_value_' . 10000,
							]
						]
					]
				],
			],
		];
	}

/**
 * Hash::merge()のテスト
 *
 * @param array $merge マージする配列
 * @return void
 * @dataProvider dataProviderForMerge
 */
	public function testMerge($merge) {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);
			Hash::merge($this->__data, $merge);
			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::insert()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProviderForInsert() {
		return [
			0 => [
				'model' => null,
				'path' => 'AAAAAA10.key2',
				'data' => 'add_insert',
			],
			1 => [
				'model' => null,
				'path' => 'AAAAAA.10.key2',
				'data' => 'add_insert',
			],
			2 => [
				'model' => null,
				'path' => 'AAAAAA.10.child.key2',
				'data' => 'add_insert',
			],
			3 => [
				'model' => null,
				'path' => 'AAAAAA.10.child.key',
				'data' => 'add_insert',
			],
			4 => [
				'model' => null,
				'path' => 'BBBBBB.10.child.key',
				'data' => 'add_insert',
			],
			5 => [
				'model' => 'AAAAAA',
				'path' => '{n}.child.key',
				'data' => 'add_insert',
			],
			6 => [
				'model' => null,
				'path' => 'AAAAAA.{n}.child.key',
				'data' => 'add_insert',
			],
		];
	}

/**
 * Hash::insert()のテスト
 *
 * @param string $model モデル名
 * @param array $path パス
 * @param mixed $data insertするデータ
 * @return void
 * @dataProvider dataProviderForInsert
 */
	public function testInsert($model, $path, $data) {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);

			if ($model) {
				Hash::insert($this->__data[$model], $path, $data);
			} else {
				Hash::insert($this->__data, $path, $data);
			}

			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::remove()テストのDataProvider
 *
 * @return array データ
 */
	public function dataProviderForRemove() {
		return [
			0 => [
				'model' => null,
				'path' => 'AAAAAA10.key',
			],
			1 => [
				'model' => null,
				'path' => 'AAAAAA.10.key',
			],
			2 => [
				'model' => null,
				'path' => 'AAAAAA.10.child.key2',
			],
			3 => [
				'model' => null,
				'path' => 'AAAAAA.10.child.key',
			],
			4 => [
				'model' => null,
				'path' => 'AAAAAA.10.child2.key',
			],
			5 => [
				'model' => null,
				'path' => 'BBBBBB.10.child.key',
			],
			6 => [
				'model' => 'AAAAAA',
				'path' => '{n}.child.key',
			],
			7 => [
				'model' => 'AAAAAA',
				'path' => '{n}.child',
			],
			8 => [
				'model' => null,
				'path' => 'AAAAAA.{n}.child.key',
			],
			9 => [
				'model' => null,
				'path' => 'AAAAAA.{n}.{s}',
			],
		];
	}

/**
 * Hash::remove()のテスト
 *
 * @param string $model モデル名
 * @param array $path パス
 * @return void
 * @dataProvider dataProviderForRemove
 */
	public function testRemove($model, $path) {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);

			if ($model) {
				Hash::remove($this->__data[$model], $path);
			} else {
				Hash::remove($this->__data, $path);
			}

			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

/**
 * Hash::sort()のテスト
 *
 * @return void
 */
	public function testSort() {
		for ($i = 0; $i < 5; $i++) {
			$stime = microtime(true);
			Hash::sort($this->__data['AAAAAA'], '{n}.child.key', 'desc');
			$etime = microtime(true);
			debug($etime - $stime);
		}
	}

}
