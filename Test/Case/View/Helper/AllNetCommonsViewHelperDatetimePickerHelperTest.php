<?php
/**
 * All DatetimePickerHelper Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * All DatetimePickerHelper Test suite
 *
 * @author Ryuji AMANO <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\DatetimePickerHelper
 */
class AllNetCommonsViewHelperDatetimePickerHelperTest extends NetCommonsTestSuite {

/**
 * All DatetimePickerHelper Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$name = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s tests', $name));
		$suite->addTestDirectoryRecursive(__DIR__ . DS . 'DatetimePickerHelper');
		return $suite;
	}

}
