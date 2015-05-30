<?php
/**
 * YACakeTestCase file
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/2.0/en/development/testing.html CakePHP(tm) Tests
 * @since         CakePHP(tm) v 1.2.0.4667
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

CakeLog::drop('stdout');
CakeLog::drop('stderr');
App::uses('CakePlugin', 'Core');

/**
 * YACakeTestCase class
 *
 * @package NetCommons\TestSuite
 */
class YACakeTestCase extends CakeTestCase {

/**
 * Load TestPlugin
 *
 * @param string $plugin Plugin name
 * @param string $testPlugin Test plugin name
 * @return void
 */
	public static function loadTestPlugin($plugin, $testPlugin) {
		$pluginPath = CakePlugin::path(Inflector::camelize($plugin));
		if (empty($pluginPath) || ! file_exists($pluginPath)) {
			$this->markTestAsSkipped(sprintf('Could not find %s in plugin paths', $pluginPath));
		}

		App::build(array(
			'Plugin' => array($pluginPath . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS)
		));
		CakePlugin::load($testPlugin);
	}
}
