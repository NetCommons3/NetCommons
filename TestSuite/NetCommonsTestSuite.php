<?php
/**
 * NetCommonsTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ConnectionManager', 'Model');

/**
 * NetCommonsTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsTestSuite extends CakeTestSuite {

/**
 * Plugin name
 *
 * @var string
 */
	public static $plugin;

/**
 * Recursively adds all the files in a directory to the test suite.
 *
 * @param string $directory The directory subtree to add tests from.
 * @return void
 */
	public function addTestDirectoryRecursive($directory = '.') {
		$dbObject = ConnectionManager::enumConnectionObjects();
		switch ($dbObject['test']['datasource']) {
			case 'Database/Mysql':
				$driver = 'mysql';
				break;
			//case 'Database/Postgres':
			//	$driver = 'pgsql';
			//	break;
		}
		$db = new PDO(
			sprintf(
				'%s:host=%s;port=%s',
				$driver,
				$dbObject['test']['host'],
				Hash::get($dbObject['test'], 'port', '3306')
			),
			$dbObject['test']['login'],
			$dbObject['test']['password']
		);

		$db->query(
			sprintf(
				'CREATE DATABASE IF NOT EXISTS `%s` /*!40100 DEFAULT CHARACTER SET %s */',
				$dbObject['test']['database'],
				Hash::get($dbObject['test'], 'encoding', 'utf8')
			)
		);

		$Folder = new Folder($directory);
		$files = $Folder->tree(null, true, 'files');

		foreach ($files as $file) {
			if (preg_match('/\/All([\w]+)Test\.php$/', $file)) {
				continue;
			}

			if (substr($file, -8) === 'Test.php') {
				$this->addTestFile($file);
			}
		}
	}

}
