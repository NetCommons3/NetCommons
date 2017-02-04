<?php
/**
 * NetCommonsPluginShortRoute
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PluginShortRoute', 'Routing/Route');
App::uses('Router', 'Routing');

/**
 * Automatically slugs routes based on named parameters
 *
 */
class NetCommonsRouter {

/**
 * Request params
 *
 * @var mixed
 */
	public static $params;

/**
 * parse
 *
 * @param string $url The URL to attempt to parse.
 * @return mixed Boolean false on failure, otherwise an array or parameters
 */
	public static function parse($url = null) {
		if (! $url) {
			$url = Router::url();
		}
		if ($url === '/') {
			self::$params = array(
				'url' => $url,
				'pagePermalink' => null,
				'spacePermalink' => null,
			);

			return self::$params;
		}

		$PageModel = ClassRegistry::init('Pages.Page');
		$dataSource = ConnectionManager::getDataSource($PageModel->useDbConfig);
		$tables = $dataSource->listSources();
		if (! in_array($PageModel->tablePrefix . $PageModel->useTable, $tables)) {
			return false;
		}

		$urls = explode('/', $url);
		array_shift($urls);
		if (Current::isSettingMode()) {
			array_shift($urls);
		}

		//スペースのチェック
		if (count($urls) > 0) {
			$Space = ClassRegistry::init('Rooms.Space');
			$count = $Space->find('count', array(
				'conditions' => array('permalink' => $urls[0]),
				'recursive' => -1
			));
			if ($count > 0) {
				$params['spacePermalink'] = $urls[0];
				unset($urls[0]);
			}
			$urls = array_values($urls);
		}

		//ページのチェック
		$conditions = array(
			'Page.permalink' => array()
		);
		$path = '';
		foreach ($urls as $i => $pass) {
			$path .= '/' . $pass;
			$conditions['Page.permalink'][] = substr($path, 1);
		}
		$count = $PageModel->find('count', array(
			'fields' => ['Page.permalink'],
			'conditions' => $conditions,
			'recursive' => -1,
			'order' => ['Page.lft' => 'asc']
		));

		$params['pagePermalink'] = array();
		for ($i = 0; $i < $count; $i++) {
			$params['pagePermalink'][] = $urls[$i];
			unset($urls[$i]);
		}
		$urls = array_values($urls);

		$params['url'] = '/' . implode('/', $urls);

		self::$params = $params;
		return self::$params;
	}

/**
 * NetCommons3用にRouter::connectを一括で登録する
 *
 * @param string $route A string describing the template of the route
 * @param array $defaults An array describing the default route parameters. These parameters will be used by default
 *   and can supply routing parameters that are not dynamic. See above.
 * @param array $options An array matching the named elements in the route to regular expressions which that
 *   element should match. Also contains additional parameters such as which routed parameters should be
 *   shifted into the passed arguments, supplying patterns for routing parameters and supplying the name of a
 *   custom routing class.
 * @see routes
 * @see parse().
 * @return array Array of routes
 * @see Router::conncet()
 */
	public static function connectBlock($route, $defaults = array(), $options = array()) {
		if ($route === '/') {
			$route = '';
		}

		Router::connect(
			'/' . Current::SETTING_MODE_WORD . $route . '/:plugin/:controller/:action/:block_id/:key',
			$defaults,
			$options
		);
		Router::connect(
			'/' . Current::SETTING_MODE_WORD . $route . '/:plugin/:controller/:action/:block_id/:key/*',
			$defaults,
			$options
		);
		Router::connect(
			'/' . Current::SETTING_MODE_WORD . $route . '/:plugin/:controller/:action/:block_id/*',
			$defaults,
			$options
		);

		Router::connect(
			$route . '/:plugin/:controller/:action/:block_id',
			$defaults,
			$options
		);
		Router::connect(
			$route . '/:plugin/:controller/:action/:block_id/:key',
			$defaults,
			$options
		);
		Router::connect(
			$route . '/:plugin/:controller/:action/:block_id/:key/*',
			$defaults,
			$options
		);
		Router::connect(
			$route . '/:plugin/:controller/:action/:block_id/*',
			$defaults,
			$options
		);

		Router::connect(
			'/' . Current::SETTING_MODE_WORD . $route . '/:plugin/:controller/:action/*',
			$defaults,
			$options
		);
	}

/**
 * 一般プラグインの取得
 *
 * @return array
 */
	public static function getGeneralPlugins() {
		$plugins = CakePlugin::loaded();
		if (! $plugins) {
			return false;
		}

		$managerPlugins = Configure::read('ManagerPlugins');
		if (! $managerPlugins) {
			$managerPlugins = array();
		}

		foreach ($plugins as $key => $value) {
			if (in_array($value, $managerPlugins, true)) {
				continue;
			}
			$plugins[$key] = Inflector::underscore($value);
		}

		return $plugins;
	}

/**
 * pagePermalink用のOptions取得
 *
 * @return array
 */
	public static function getPagePermalinkOptions() {
		if (! self::$params) {
			$parser = self::parse();
		} else {
			$parser = self::$params;
		}

		$pageOptions = [];
		if (Hash::get($parser, 'pagePermalink')) {
			$pageOptionsKey = array_map(function ($index) {
				return 'pagePermalink' . $index;
			}, array_keys(Hash::get($parser, 'pagePermalink')));

			$pageOptions = array_combine($pageOptionsKey, Hash::get($parser, 'pagePermalink'));
		}

		return $pageOptions;
	}

/**
 * spacePermalink用のOptions取得
 *
 * @return array
 */
	public static function getSpacePermalinkOptions() {
		if (! self::$params) {
			$parser = self::parse();
		} else {
			$parser = self::$params;
		}

		$spaceOptions = [];
		if (Hash::get($parser, 'spacePermalink')) {
			$spaceOptions = array(
				'spacePermalink' => Hash::get($parser, 'spacePermalink')
			);
		}

		return $spaceOptions;
	}

}
