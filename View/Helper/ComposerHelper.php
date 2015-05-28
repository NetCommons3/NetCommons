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
			$filePath = App::pluginPath(Inflector::camelize($plugin)) . 'composer.json';
			$file = new File($filePath);
			$contents = $file->read();
			$file->close();
//var_dump($contents);
			$this->__plugins[$plugin] = json_decode($contents, true);
//var_dump($this->__plugins[$plugin]);
		} catch (Exception $ex) {
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

		$html = '<ul class="list-inline small frame-add-plugin">';
		$html .= $this->Html->tag('li', __d('pages', 'Author(s) : '));
		$tags = array();
		foreach ($authors as $i => $author) {
			$name = '';
			if (isset($author['role']) && strtolower($author['role']) === 'developer') {
				$name .= '<span class="text-danger">*</span>';
			}
			if (isset($author['homepage'])) {
				$name .= $this->Html->link($author['name'], $author['homepage'], array('target' => '_blank'));
			} else {
				$name .= $author['name'];
			}

			if ($i !== count($authors) - 1) {
				$name .= ' , ';
		}
			$html .= $this->Html->tag('li', $name, array('class' => 'list-unstyled'));
		}
		$html .= '</ul>';
		return $html;
	}

}
