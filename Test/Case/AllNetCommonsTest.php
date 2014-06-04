<?php
class AllNetCommonsTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case');
		return $suite;
	}
}
