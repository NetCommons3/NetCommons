<?php
/**
 * All Controller/Component Test suite
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * All Controller/Component Test suite
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\NetCommons\Test\Case\Controller\Component
 */
class AllNetCommonsControllerComponentTest extends NetCommonsTestSuite {

/**
 * All Controller/Component Test suite
 *
 * @return NetCommonsTestSuite
 * @codeCoverageIgnore
 */
	public static function suite() {
		$name = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s tests', $name));
		$suite->addTestDirectoryRecursive(__DIR__ . DS . 'Controller' . DS . 'Component');
		return $suite;
	}

}
