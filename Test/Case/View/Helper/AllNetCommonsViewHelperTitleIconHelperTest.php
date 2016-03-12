<?php
/**
 * All titleIconHelper Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * All TitleIconHelper Test suite
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\NetCommons\Test\Case\TitleIconHelper
 */
class AllNetCommonsViewHelpertitleIconHelperTest extends NetCommonsTestSuite {

/**
 * All TitleIconHelper Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$name = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s tests', $name));
		$suite->addTestDirectoryRecursive(__DIR__ . DS . 'TitleIconHelper');
		return $suite;
	}
}
