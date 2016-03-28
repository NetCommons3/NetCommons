<?php
/**
 * Composer helper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');
App::uses('File', 'Utility');
App::uses('CakePlugin', 'Core');

/**
 * Composer helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\View\Helper
 */
class ComposerHelper extends AppHelper {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Html'
	);

/**
 * Plugin composer data
 *
 * @var array
 */
	private $__plugins;

/**
 * Get the composer.json
 *
 * @param string $plugin Plugin path
 * @return string|array Composer value
 */
	private function __getComposer($plugin) {
		$filePath = CakePlugin::path(Inflector::camelize($plugin)) . 'composer.json';
		if (file_exists($filePath)) {
			$file = new File($filePath);
			$contents = $file->read();
			$file->close();
			$this->__plugins[$plugin] = json_decode($contents, true);
		} else {
			$this->__plugins[$plugin] = array();
		}
	}

/**
 * composer.jsonからデータ取得
 *
 * @param string $plugin プラグインkey
 * @param string $key Composerのkey
 * @param mixed $default デフォルト値
 * @return string|array Composerの値
 */
	public function getComposer($plugin, $key = null, $default = null) {
		if (! isset($this->__plugins[$plugin])) {
			$this->__getComposer($plugin);
		}
		$composer = $this->__plugins[$plugin];
		if (! is_null($key)) {
			return Hash::get($composer, $key, $default);
		} else {
			return $composer;
		}
	}

/**
 * Get the container size for layout
 *
 * @param string $plugin Plugin path
 * @param array $options Option data
 * @return string|array Composer value
 */
	public function getAuthors($plugin, $options = array()) {
		$authors = $this->getComposer($plugin, 'authors', array());
		$options += array('useTag' => true);
		if (! $options['useTag']) {
			return $authors;
		}

		//$html = '<ul class="list-inline small frame-add-plugin">';
		$html = '';
		$html .= $this->Html->tag('li', '<strong class="h4">' . __d('plugin_manager', 'Author(s)') . '</strong>', array('class' => 'dropdown-header'));
		//$html .= $this->Html->tag('li', '', array('class' => 'divider'));
		foreach ($authors as $author) {
			$name = '';
			if (isset($author['role']) && strtolower($author['role']) === 'developer') {
				$author['name'] = h($author['name']) .
						' <span class="small"><span class="text-danger">' .
							__d('plugin_manager', '[Developer]') .
						'</span></span>';
			}
			if (isset($author['homepage'])) {
				$name .= $this->Html->link($author['name'], $author['homepage'], array('target' => '_blank', 'escapeTitle' => false));
			} else {
				$name .= h($author['name']);
			}
			$html .= $this->Html->tag('li', $name);
		}
		$html .= '</ul>';
		return $html;
	}

/**
 * Get the container size for layout
 *
 * @param string $plugin Plugin path
 * @return string|array Composer value
 */
	public function getDescription($plugin) {
		$description = $this->getComposer($plugin, 'description');
		return h(__d($plugin, $description));
	}

}
