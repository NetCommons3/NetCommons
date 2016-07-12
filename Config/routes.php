<?php
/**
 * Pages routes configuration
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('SlugRoute', 'Pages.Routing/Route');
App::uses('Current', 'NetCommons.Utility');

Router::connect(
	'/' . Current::SETTING_MODE_WORD . '/',
	array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'),
	array('routeClass' => 'SlugRoute')
);
Router::connect(
	'/' . Current::SETTING_MODE_WORD . '/*',
	array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'),
	array('routeClass' => 'SlugRoute')
);
Router::connect(
	'/*',
	array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'),
	array('routeClass' => 'SlugRoute')
);

$params = array();
if (! Current::isSettingMode()) {
	//$params = array(Current::SETTING_MODE_WORD => false);
}
$indexParams = $params + array('action' => 'index');
if ($plugins = CakePlugin::loaded()) {
	App::uses('PluginShortRoute', 'Routing/Route');
	foreach ($plugins as $key => $value) {
		$plugins[$key] = Inflector::underscore($value);
	}
	$pluginPattern = implode('|', $plugins);
	$options = array(
		'plugin' => $pluginPattern,
		'block_id' => '[0-9]+',
		'key' => '[a-z0-9]+',
	);
	$shortParams = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);

	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin',
		$indexParams,
		$shortParams
	);
	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin/:controller',
		$indexParams,
		$options
	);
	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin/:controller/:action/:block_id/:key',
		$params,
		$options
	);
	Router::connect(
		'/:plugin/:controller/:action/:block_id/:key',
		$params,
		$options
	);
	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin/:controller/:action/*',
		$params,
		$options
	);
}

Router::connect('/' . Current::SETTING_MODE_WORD . '/:controller', $indexParams);
Router::connect('/' . Current::SETTING_MODE_WORD . '/:controller/:action/*', $params);
