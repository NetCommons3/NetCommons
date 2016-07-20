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

// Load all plugins
$plugins = App::objects('plugins');
foreach ($plugins as $plugin) {
	$options = array();

	$pluginPath = ROOT . DS . 'app' . DS . 'Plugin' . DS . $plugin;
	is_readable($pluginPath . DS . 'Config' . DS . 'bootstrap.php') && $options['bootstrap'] = true;
	is_readable($pluginPath . DS . 'Config' . DS . 'routes.php') && $options['routes'] = true;
	if (!CakePlugin::loaded($plugin)) {
		CakePlugin::load($plugin, $options);
	}
}

// Load application configurations
$conf = array();
$files = array('application.yml', 'application.local.yml');
foreach ($files as $file) {
	if (file_exists(APP . 'Config' . DS . $file)) {
		$conf = array_merge($conf, Spyc::YAMLLoad(APP . 'Config' . DS . $file));
		Configure::write($conf);
	}
}

//サイトの設定データセット
if (Configure::read('NetCommons.installed')) {
	//ClassRegistryは本来SiteSettingUtilでセットするべきだが、SiteSettingUtilが古い場合があるため、
	//とりあえず、こっちにも定義しておく
	App::uses('ClassRegistry', 'Utility');
	App::uses('SiteSettingUtil', 'SiteManager.Utility');
	SiteSettingUtil::initialize();
}

App::uses('Router', 'Routing');
Router::parseExtensions();
