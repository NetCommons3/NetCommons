<?php
/**
 * NetCommonsCakeTestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AuthComponent', 'Controller/Component');
App::uses('PageLayoutComponent', 'Pages.Controller/Component');
App::uses('GetPageBehavior', 'Pages.Model/Behavior');
App::uses('CurrentLib', 'NetCommons.Lib');
App::uses('Current', 'NetCommons.Utility');
App::uses('SettingMode', 'NetCommons.Lib');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

if (!defined('UPLOADS_ROOT')) {
	define('UPLOADS_ROOT', NetCommonsCurrentLibTestUtility::getUploadDir());
}

/**
 * Fixture test_schema.sqlを読み込むんでテストするためのユーティリティ
 *
 * Security:
 *   salt: >
 *     2a95829d8ad63ca6cb49baaa52e772270dc174a79e090ee0851505c65b21d3ac9d14287e39a2f30fc4606ff1c9b45c7376b02a0b5a5ef0af82cc9f4d344107ec
 *   cipherSeed:
 *     "142354242720272028881904983643200749000"
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class NetCommonsCurrentLibTestUtility {

/**
 * drop tableの構文文字列
 *
 * @var string
 */
	private static $__dropTablesSql = '';

/**
 * ロードしているか否か
 *
 * @var string
 */
	private static $__loadedTables = false;

/**
 * drop tableの構文文字列
 *
 * @var string
 */
	private static $__users = [
		'1' => [
			'id' => '1',
			'username' => 'admin',
			'password' => 'bf52eec7654a236513801b3d19c0ab557c36f3f29c',
			'role_key' => 'system_administrator',
			'handlename' => 'System administrator',
			'modified' => '2019-03-02 00:00:00',
			'UserRoleSetting' => [
				'id' => '1',
				'role_key' => 'system_administrator',
				'origin_role_key' => 'system_administrator',
				'use_private_room' => '1',
			],
		],
		'2' => [
			'id' => '2',
			'username' => 'general_user_1',
			'password' => 'bf52eec7654a236513801b3d19c0ab557c36f3f29c',
			'role_key' => 'common_user',
			'handlename' => 'General user 1',
			'modified' => '2019-03-02 00:00:00',
			'UserRoleSetting' => [
				'id' => '1',
				'role_key' => 'common_user',
				'origin_role_key' => 'common_user',
				'use_private_room' => '1',
			],
		],
		'3' => [
			'id' => '3',
			'username' => 'general_user_2',
			'password' => 'bf52eec7654a236513801b3d19c0ab557c36f3f29c',
			'role_key' => 'common_user',
			'handlename' => 'General user 2',
			'modified' => '2019-03-02 00:00:00',
			'UserRoleSetting' => [
				'id' => '1',
				'role_key' => 'common_user',
				'origin_role_key' => 'common_user',
				'use_private_room' => '1',
			],
		],
		'4' => [
			'id' => '4',
			'username' => 'general_user_3',
			'password' => 'bf52eec7654a236513801b3d19c0ab557c36f3f29c',
			'role_key' => 'common_user',
			'handlename' => 'General user 3',
			'modified' => '2019-03-02 00:00:00',
			'UserRoleSetting' => [
				'id' => '1',
				'role_key' => 'common_user',
				'origin_role_key' => 'common_user',
				'use_private_room' => '1',
			],
		],
		'5' => [
			'id' => '5',
			'username' => 'guest_user_1',
			'password' => 'bf52eec7654a236513801b3d19c0ab557c36f3f29c',
			'role_key' => 'guest_user',
			'handlename' => 'Guest user 1',
			'modified' => '2019-03-02 00:00:00',
			'UserRoleSetting' => [
				'id' => '1',
				'role_key' => 'guest_user',
				'origin_role_key' => 'common_user',
				'use_private_room' => '1',
			],
		],
	];

/**
 * テスト名をdebugに出力
 *
 * @param string $loginTitle ログインタイトル(ログインなし、管理者でログインなどをセットする)
 * @param string $method テストメソッド
 * @return void
 */
	public static function debugLogTestName($loginTitle, $method) {
		$pos = strpos($method, 'with');
		if ($pos !== false) {
			$testName = mb_substr($method, 0, $pos - 1);
			$testSubTitle = mb_substr($method, $pos - 1);
		} else {
			$testName = $method;
			$testSubTitle = '';
		}

		switch ($testName) {
			case 'testGetRequest';
				$testName = 'GETリクエスト';
				break;
			case 'testGetRequestAnnouncementPageWithSettingMode':
				$testName = 'セッティングモードON(パブリックのお知らせページ)';
				break;
			case 'testPostRequest';
				$testName = 'POSTリクエスト';
				break;
			case 'testPostRequestFrameAdd';
				$testName = 'フレーム追加';
				break;
			case 'testPostRequestFrameEdit';
				$testName = 'フレーム編集';
				break;
			case 'testPostRequestFrameDelete';
				$testName = 'フレーム削除';
				break;
		}

		//ログ出力
		CakeLog::debug('');
		CakeLog::debug('');
		CakeLog::debug('[' . $loginTitle . '] ' . $testName . $testSubTitle);
		CakeLog::debug('');
	}

/**
 * テーブルのロード
 *
 * @return void
 */
	public static function loadTables() {
		if (! self::canLoadTables()) {
			return;
		}

		if (! self::$__loadedTables) {
			$db = ConnectionManager::getDataSource('test');
			$schemaFile = self::getSchemaFile();
			$sql = file_get_contents($schemaFile);
			$db->rawQuery($sql);

			self::$__loadedTables = true;
		}
	}

/**
 * テーブルのロードしているか否か
 *
 * @return void
 */
	public static function loadedTables() {
		return self::$__loadedTables;
	}

/**
 * テーブルをロードできるか否か
 *
 * @return bool
 */
	public static function canLoadTables() {
		return (!getenv('NC3_DOCKER_DIR') || getenv('NC3_LOCAL_TEST'));
	}

/**
 * Fixtureのパスを返す
 *
 * @return string
 */
	public static function getFixturePath() {
		$path = CakePlugin::path('NetCommons') . 'Test' . DS . 'Fixture' . DS;
		return $path;
	}

/**
 * スキーマファイルのフルパスを返す
 *
 * @return string
 */
	public static function getSchemaFile() {
		if (get_class(new Current()) === 'CurrentLib') {
			$schemaFile = self::getFixturePath() . 'CurrentLib' . DS . 'test_schema_current_lib.sql';
		} else {
			$schemaFile = self::getFixturePath() . 'CurrentLib' . DS . 'test_schema_current_utility.sql';
		}
		return $schemaFile;
	}

/**
 * tmpディレクトリのパスを返す
 *
 * @return string
 */
	public static function getTmpDir() {
		$path = self::getFixturePath() . 'CurrentLib' . DS . 'tmp' . DS;
		return $path;
	}

/**
 * アップロードディレクトリのパスを返す
 *
 * @return string
 */
	public static function getUploadDir() {
		$path = self::getFixturePath() . 'CurrentLib' . DS . 'TestUploads' . DS;
		return $path;
	}

/**
 * アップロードディレクトリのパスをセットする
 *
 * @return string
 */
	public static function prepareUploadDir() {
		//@var Folder
		$Folder = new Folder();

		if (! self::clearUploadDir()) {
			return false;
		}

		$options = [
			'from' => self::getFixturePath() . 'CurrentLib' . DS . 'Uploads',
			'to' => self::getUploadDir(),
		];
		if (! $Folder->copy($options)) {
			return false;
		}

		return true;
	}

/**
 * アップロードディレクトリのパスをセットする
 *
 * @return string
 */
	public static function clearUploadDir() {
		if (file_exists(self::getUploadDir() . 'files')) {
			//@var Folder
			$Folder = new Folder();
			return $Folder->delete(self::getUploadDir() . 'files');
		}
		return true;
	}

/**
 * TemporaryFileのモックとしてFileを使って戻す
 *
 * @param array $fileInfo アップロードファイル情報
 * @return string
 */
	public static function getTemporaryFileMock($fileInfo) {
		$extension = pathinfo(
			$fileInfo['name'],
			PATHINFO_EXTENSION
		);
		$destFileName = Security::hash(mt_rand() . microtime(), 'md5') . '.' . $extension;

		$TmpFile = new File($fileInfo['tmp_name']);
		$TmpFile->copy(self::getTmpDir() . $destFileName);

		unset($TmpFile);

		$File = new File(self::getTmpDir() . $destFileName);
		$File->temporaryFolder = new Folder(self::getTmpDir());
		$File->originalName = $fileInfo['name'];
		$File->error = $fileInfo['error'];

		return $File;
	}

/**
 * テーブルの削除
 *
 * @return void
 */
	public static function dropTables() {
		if (! self::$__dropTablesSql) {
			$db = ConnectionManager::getDataSource('test');
			$tables = $db->listSources();
			foreach ($tables as $table) {
				self::$__dropTablesSql .= 'DROP TABLE IF EXISTS `' . $table . '`;' . "\n";
			}
		}

		if (self::$__dropTablesSql) {
			$db = ConnectionManager::getDataSource('test');
			//$db->rawQuery(self::$__dropTablesSql);
			self::$__loadedTables = false;
		}
	}

/**
 * ログイン
 *
 * @param string|int $userId ユーザID
 * @return void
 */
	public static function login($userId) {
		$reflectionClass = new ReflectionClass('AuthComponent');
		$property = $reflectionClass->getProperty('_user');
		$property->setAccessible(true);
		$property->setValue(self::$__users[$userId]);
	}

/**
 * ログアウト
 *
 * @return void
 */
	public static function logout() {
		$reflectionClass = new ReflectionClass('AuthComponent');
		$property = $reflectionClass->getProperty('_user');
		$property->setAccessible(true);
		$property->setValue([]);
	}

/**
 * セッティングモードの変更
 *
 * @param bool $setting セッティングモード
 * @return void
 */
	public static function settingMode($setting) {
		if (get_class(new Current()) === 'CurrentLib') {
			$reflectionClass = new ReflectionClass('SettingMode');
			$property = $reflectionClass->getProperty('__isSettingMode');
			$property->setAccessible(true);
			$property->setValue($setting);
		} else {
			$reflectionClass = new ReflectionClass('Current');
			$property = $reflectionClass->getProperty('_isSettingMode');
			$property->setAccessible(true);
			$property->setValue($setting);
		}
	}

/**
 * 旧Currentのリセット
 *
 * @return void
 */
	private static function __resetOldCurrentUtility() {
		Current::$current = [];
		Current::$originalCurrent = [];
		Current::$permission = [];

		$class = new ReflectionClass('Current');
		foreach (['_instance', '_instanceSystem', '_instanceFrame', '_instancePage'] as $prop) {
			$Property = $class->getProperty($prop);
			$Property->setAccessible(true);
			$Property->setValue(null);
		}

		$class = new ReflectionClass('CurrentFrame');
		$Property = $class->getProperty('__memoryCache');
		$Property->setAccessible(true);
		$Property->setValue([]);

		$class = new ReflectionClass('CurrentFrame');
		$Property = $class->getProperty('__roomIds');
		$Property->setAccessible(true);
		$Property->setValue([]);

		$class = new ReflectionClass('CurrentPage');
		$Property = $class->getProperty('__memoryCache');
		$Property->setAccessible(true);
		$Property->setValue([]);

		$class = new ReflectionClass('CurrentSystem');
		$Property = $class->getProperty('__memoryCache');
		$Property->setAccessible(true);
		$Property->setValue(null);

		$class = new ReflectionClass('GetPageBehavior');
		$Property = $class->getProperty('__memoryPageWithFrame');
		$Property->setAccessible(true);
		$Property->setValue([]);
	}

/**
 * Currentライブラリのリセット
 *
 * @return void
 */
	public static function resetCurrentLib() {
		if (get_class(new Current()) === 'CurrentLib') {
			Current::resetInstance();
		} else {
			self::__resetOldCurrentUtility();
		}

		$class = new ReflectionClass('PageLayoutComponent');
		$Property = $class->getProperty('_page');
		$Property->setAccessible(true);
		$Property->setValue(null);
	}

/**
 * コントローラのGETテスト
 *
 * @param ControllerTestCase $test コントローラテストクラス
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @param string|false $outputDebugTitle 出力するdebugのタイトル
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public static function testControllerGetRequest(
			ControllerTestCase $test, $url, $expects, $exception, $outputDebugTitle = false) {
		if ($expects === false) {
			$test->setExpectedException($exception);
		}

		if ($outputDebugTitle) {
			$key = md5(json_encode($url) . json_encode($expects) . json_encode($exception));
			CakeLog::debug("=========================================");
		}

		$test->testAction($url, ['method' => 'GET', 'return' => 'view']);

		if ($outputDebugTitle) {
			CakeLog::debug('##### ' . var_export($key, true));
			CakeLog::debug(__METHOD__ . '(' . __LINE__ . ')  beforeFilter - afterFilter = Total');
			CakeLog::debug(var_export(($test->controller->endTime - $test->controller->startTime), true));
			CakeLog::debug("--------");
			CakeLog::debug("");
			CakeLog::debug("");
			CakeLog::debug("");
			CakeLog::debug("");
		}

		//debug($test->contents);
		//debug($test->view);
		//debug($test->headers);

		if ($expects !== false) {
			self::__assertController($test, $expects);
			//self::dropTables();
		}
	}

/**
 * コントローラのPOSTテスト
 *
 * Mockにせずに登録処理を実行するが、saveした結果まではチェックしない。
 *
 * @param ControllerTestCase $test コントローラテストクラス
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @return void
 */
	public static function testControllerPostRequest(
			ControllerTestCase $test, $url, $post, $expects, $exception) {
		if ($expects === false) {
			$test->setExpectedException($exception);
		}

		$test->testAction(
			$url,
			['method' => 'POST', 'return' => 'view', 'data' => $post]
		);
		//debug($test->contents);
		//debug($test->view);
		//debug($test->headers);
		//debug($test->controller->validationErrors);

		if ($expects !== false) {
			self::__assertController($test, $expects);
			self::dropTables();
		}
	}

/**
 * コントローラのPOSTテスト
 *
 * Mockにせずに登録処理を実行するが、saveした結果まではチェックしない。
 *
 * @param ControllerTestCase $test コントローラテストクラス
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 * @return void
 */
	public static function testJsonControllerPostRequest(
			ControllerTestCase $test, $url, $post, $expects, $exception) {
		if ($expects === false) {
			$test->setExpectedException($exception);
		}

		$test->testAction(
			$url,
			['method' => 'POST', 'return' => 'view', 'type' => 'json', 'data' => $post]
		);
		//debug($test->contents);
		//debug($test->view);
		//debug($test->headers);
		//debug($test->controller->validationErrors);

		if ($expects !== false) {
			$contents = json_decode($test->contents, true);
			foreach ($expects as $key => $value) {
				$test->assertEquals($value, Hash::get($contents, $key));
			}
			self::dropTables();
		}
	}

/**
 * コントローラの検証
 *
 * @param ControllerTestCase $test コントローラテストクラス
 * @param array|false $expects 期待値リスト
 * @return void
 */
	private static function __assertController(ControllerTestCase $test, $expects) {
		$test->contents = str_replace("\n", '', $test->contents);
		$test->contents = str_replace("\t", '', $test->contents);

		foreach ($expects as $assert => $expect) {
			if (strpos($assert, 'headers') !== false) {
				list(, $key) = explode('.', $assert);
				$test->assertRegExp($expect, $test->headers[$key]);
			} elseif ($assert === 'validationErrors') {
				$test->assertEquals($expect, $test->controller->validationErrors);
			} else {
				foreach ($expect as $ex) {
					$test->$assert($ex, $test->contents);
				}
			}
		}
	}

}
