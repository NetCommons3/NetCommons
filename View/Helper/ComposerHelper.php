<?php
/**
 * LayoutHelper
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
 * LayoutHelper
 *
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
 * Get the container size for layout
 *
 * @param string $plugin Plugin path
 * @param string $key composer key
 * @return string|array Composer value
 */
	private function __getComposer($plugin) {
		try {
			$filePath = CakePlugin::path(Inflector::camelize($plugin)) . 'composer.json';
			$file = new File($filePath);
			$contents = $file->read();
			$file->close();
//var_dump($contents);
			$this->__plugins[$plugin] = json_decode($contents, true);
//var_dump($this->__plugins[$plugin]);
		} catch (Exception $ex) {
			//var_dump($ex);
		}
	}

/**
 * Get the container size for layout
 *
 * @param string $plugin Plugin path
 * @param string $key composer key
 * @return string|array Composer value
 */
	public function getComposer($plugin, $key = null) {
		if (! isset($this->__plugins[$plugin])) {
			$this->__getComposer($plugin);
		}
		$composer = $this->__plugins[$plugin];
		if (! is_null($key)) {
			return $composer[$key];
		} else {
			return $composer;
		}
	}

/**
 * Get the container size for layout
 *
 * @param string $plugin Plugin path
 * @return string|array Composer value
 */
	public function getAuthors($plugin, $options = array()) {
		$authors = $this->getComposer($plugin, 'authors');
		$options += array('useTag' => true);
		if (! $options['useTag']) {
			return $authors;
		}

		//$html = '<ul class="list-inline small frame-add-plugin">';
		$html = '';
		$html .= $this->Html->tag('li', '<strong class="h4">' . __d('pages', 'Author(s)') . '</strong>', array('class' => 'dropdown-header'));
		//$html .= $this->Html->tag('li', '', array('class' => 'divider'));
		$tags = array();
		foreach ($authors as $i => $author) {
			$name = '';
			if (isset($author['role']) && strtolower($author['role']) === 'developer') {
				$author['name'] = h($author['name']) . ' <span class="text-danger">[' . __d('net_commons', 'Developer') . ']</span>';
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
