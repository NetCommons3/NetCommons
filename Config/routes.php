<?php
/**
 * Pages routes configuration
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SlugRoute', 'Pages.Routing/Route');
App::uses('Current', 'NetCommons.Utility');

Router::connect(
       '/invalidate',
       array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'invalidate'),
       array('routeClass' => 'SlugRoute')
);

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
	$params = array(Current::SETTING_MODE_WORD => false);
}
$indexParams = $params + array('action' => 'index');

$plugins = CakePlugin::loaded();
$managerPlugins = Configure::read('ManagerPlugins');
if (! $managerPlugins) {
	$managerPlugins = array();
}
$routingPlugins = [];
foreach ($plugins as $key => $value) {
	if (in_array($value, $managerPlugins, true)) {
		continue;
	}
	$routingPlugins[$key] = Inflector::underscore($value);
}

if ($routingPlugins) {
	App::uses('PluginShortRoute', 'Routing/Route');

	$pluginPattern = implode('|', $routingPlugins);
	$options = array(
		'plugin' => $pluginPattern,
		'block_id' => '[0-9]+',
		'key' => '[a-zA-Z0-9_]+', //_は、UnitTestで使用するため
	);
	$shortOptions = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);

	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin',
		$indexParams,
		$shortOptions
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
		'/' . Current::SETTING_MODE_WORD . '/:plugin/:controller/:action/:block_id/:key/*',
		$params,
		$options
	);
	Router::connect(
		'/' . Current::SETTING_MODE_WORD . '/:plugin/:controller/:action/:block_id/*',
		$params,
		$options
	);

	Router::connect(
		'/:plugin/:controller/:action/:block_id',
		$params,
		$options
	);
	Router::connect(
		'/:plugin/:controller/:action/:block_id/:key',
		$params,
		$options
	);
	Router::connect(
		'/:plugin/:controller/:action/:block_id/:key/*',
		$params,
		$options
	);
	Router::connect(
		'/:plugin/:controller/:action/:block_id/*',
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
