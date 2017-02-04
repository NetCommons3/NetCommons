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
App::uses('SlugPluginRoute', 'Pages.Routing/Route');
App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsRouter', 'NetCommons.Routing');

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

$plugins = NetCommonsRouter::getGeneralPlugins();
if ($plugins) {
	App::uses('PluginShortRoute', 'Routing/Route');

	$pluginPattern = implode('|', $plugins);
	$options = array(
		'plugin' => $pluginPattern,
		'block_id' => '[0-9]+',
		'key' => '[a-zA-Z0-9_]+', //_は、UnitTestで使用するため
	);
	$shortOptions = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);
	$pluginOptions = array('routeClass' => 'SlugPluginRoute') + $options;

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

	$pageOptions = NetCommonsRouter::getPagePermalinkOptions();
	$spaceOptions = NetCommonsRouter::getSpacePermalinkOptions();
	if ($pageOptions) {
		$pathParams = array_map(function ($value) {
			return ':' . $value;
		}, array_keys($pageOptions));

		NetCommonsRouter::connectBlock(
			'/' . implode('/', $pathParams),
			$params,
			$pageOptions + $pluginOptions
		);

		if ($spaceOptions) {
			NetCommonsRouter::connectBlock(
				'/:spacePermalink/' . implode('/', $pathParams),
				$params,
				$spaceOptions + $pageOptions + $pluginOptions
			);
		}
	}
	if ($spaceOptions) {
		NetCommonsRouter::connectBlock(
			'/:spacePermalink',
			$params,
			$spaceOptions + $pluginOptions
		);
	}

	NetCommonsRouter::connectBlock(
		'/',
		$params,
		$pluginOptions
	);
}

Router::connect('/' . Current::SETTING_MODE_WORD . '/:controller', $indexParams);
Router::connect('/' . Current::SETTING_MODE_WORD . '/:controller/:action/*', $params);
