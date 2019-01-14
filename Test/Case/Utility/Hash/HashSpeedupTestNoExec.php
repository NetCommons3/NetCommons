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
class HashSpeedupTestNoExec extends CakeTestCase {

/**
 * データ
 *
 * @var array
 */
	const MEASUREMENT_NUMBER = 0;

/**
 * 開始時間
 *
 * @var string
 */
	private $__startTime = null;

/**
 * 終了時間
 *
 * @var string
 */
	private $__endTime = null;

/**
 * データ
 *
 * @var array
 */
	private $__data = [];

/**
 * Runs the test case and collects the results in a TestResult object.
 * If no TestResult object is passed a new one will be created.
 * This method is run for each test method in this class
 *
 * @param PHPUnit_Framework_TestResult $result The test result object
 * @return PHPUnit_Framework_TestResult
 * @throws InvalidArgumentException
 */
	public function run(PHPUnit_Framework_TestResult $result = null) {
		if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
			return parent::run($result);
		}
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//大量データ作成
		if (! $this->__data && self::MEASUREMENT_NUMBER > 0) {
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
 * デバッグの開始
 *
 * @return void
 */
	private function __debugStart() {
		$this->__startTime = microtime(true);
	}

/**
 * デバッグの終了
 *
 * @return void
 */
	private function __debugEnd() {
		$this->__endTime = microtime(true);
		//debug($this->_endTime - $this->_startTime);
	}

/**
 * Hash::get()のテスト
 *
 * @return void
 */
	public function testGet() {
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			Hash::get($this->__data, 'AAAAAA.10.child.grandchild.4.key');
			$this->__debugEnd();
		}

		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			Hash::get($this->__data, 'AAAAAA10.child.grandchild.4.key');
			$this->__debugEnd();
		}
	}

/**
 * Hash::expand()のテスト
 *
 * @return void
 */
	public function testExpand() {
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
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

			$this->__debugStart();
			Hash::expand($test);
			$this->__debugEnd();
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
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			Hash::extract($this->__data, $pathKey);
			$this->__debugEnd();
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
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			if ($model) {
				Hash::combine($this->__data[$model], $keyPath, $valuePath, $groupPath);
			} else {
				Hash::combine($this->__data, $keyPath, $valuePath, $groupPath);
			}
			$this->__debugEnd();
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
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			Hash::merge($this->__data, $merge);
			$this->__debugEnd();
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
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			if ($model) {
				Hash::insert($this->__data[$model], $path, $data);
			} else {
				Hash::insert($this->__data, $path, $data);
			}
			$this->__debugEnd();
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
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			if ($model) {
				Hash::remove($this->__data[$model], $path);
			} else {
				Hash::remove($this->__data, $path);
			}
			$this->__debugEnd();
		}
	}

/**
 * Hash::sort()のテスト
 *
 * @return void
 */
	public function testSort() {
		for ($i = 0; $i < self::MEASUREMENT_NUMBER; $i++) {
			$this->__debugStart();
			Hash::sort($this->__data['AAAAAA'], '{n}.child.key', 'desc');
			$this->__debugEnd();
		}
	}

}
