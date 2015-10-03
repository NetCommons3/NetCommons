<?php
/**
 * NetCommonsTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * NetCommonsTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsTestSuite extends CakeTestSuite {

/**
 * Recursively adds all the files in a directory to the test suite.
 *
 * @param string $directory The directory subtree to add tests from.
 * @return void
 */
	public function addTestDirectoryRecursive($directory = '.') {
		$Folder = new Folder($directory);
		$files = $Folder->tree(null, true, 'files');

		foreach ($files as $file) {
			if (substr($file, -8) === 'Test.php') {
				$this->addTestFile($file);
			}
		}
	}

}
