<?php
/**
 * NetCommons bootstrap
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

// 多数ファイルをインクルードしていて、xdebugの制限に引っかかるため
if (ini_get('xdebug.max_nesting_level')) {
	ini_set('xdebug.max_nesting_level', 200);
}

if (! defined('NC3_VERSION')) {
	App::uses('NetCommonsCache', 'NetCommons.Utility');
	$ncCache = new NetCommonsCache('version', false, 'netcommons_core');
	$version = $ncCache->read();
	if ($version) {
		define('NC3_VERSION', trim($version));
	} else {
		define('NC3_VERSION', '3.2.1');
	}
}

// Load application configurations
$conf = array();
$files = array('application.yml', 'application.local.yml', 'application.' . env('HTTP_HOST') . '.yml', 'application.' . env('HTTP_X_FORWARDED_HOST') . '.yml');
foreach ($files as $file) {
	if (file_exists(APP . 'Config' . DS . $file)) {
		$conf = array_replace_recursive($conf, Spyc::YAMLLoad(APP . 'Config' . DS . $file));
	}
}
Configure::write($conf);

// Load all plugins
$plugins = App::objects('plugins');
foreach ($plugins as $plugin) {
	$options = array();

	foreach (App::path('plugins') as $path) {
		if (is_dir($path . $plugin)) {
			$pluginPath = $path . $plugin;
			is_readable($pluginPath . DS . 'Config' . DS . 'bootstrap.php') && $options['bootstrap'] = true;
			is_readable($pluginPath . DS . 'Config' . DS . 'routes.php') && $options['routes'] = true;
			if (!CakePlugin::loaded($plugin)) {
				CakePlugin::load($plugin, $options);
			}
		}
	}
}
if (! Configure::read('Config.language')) {
	Configure::write('Config.language', 'ja');
}

App::uses('Router', 'Routing');
Router::parseExtensions();

//インストールのapplication.ymlがない場合、Noticeになるため
if (! Configure::read('NetCommons.installed')) {
	if (CakePlugin::loaded('Install')) {
		App::uses('InstallUtil', 'Install.Utility');
		$InstallUtil = new InstallUtil();
	}
} else {
	App::uses('CakeSession', 'Model/Datasource');
	CakeSession::start();

	$debug = CakeSession::read('debug');
	if (isset($debug) && is_numeric($debug) && $debug !== false) {
		Configure::write('debug', $debug);
	}
}
