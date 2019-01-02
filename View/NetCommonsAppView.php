<?php
/**
 * Application level View
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('View', 'View');

/**
 * Application View
 *
 * @package       Cake.View
 */
class NetCommonsAppView extends View {

/**
 * Renders and returns output for given view filename with its
 * array of data. Handles parent/extended views.
 *
 * @param string $viewFile Filename of the view
 * @param array $data Data to include in rendered view. If empty the current View::$viewVars will be used.
 * @return string Rendered output
 * @triggers View.beforeRenderFile $this, array($viewFile)
 * @triggers View.afterRenderFile $this, array($viewFile, $content)
 * @throws CakeException when a block is left open.
 */
	protected function _render($viewFile, $data = array()) {
		if (empty($data)) {
			$data = $this->viewVars;
		}
		$this->_current = $viewFile;
		$initialBlocks = count($this->Blocks->unclosed());

		//$eventManager = $this->getEventManager();
		//$beforeEvent = new CakeEvent('View.beforeRenderFile', $this, array($viewFile));
		//
		//$eventManager->dispatch($beforeEvent);
		$content = $this->_evaluate($viewFile, $data);

		//$afterEvent = new CakeEvent('View.afterRenderFile', $this, array($viewFile, $content));
		//
		//$afterEvent->modParams = 1;
		//$eventManager->dispatch($afterEvent);
		//$content = $afterEvent->data[1];

		if (isset($this->_parents[$viewFile])) {
			$this->_stack[] = $this->fetch('content');
			$this->assign('content', $content);

			$content = $this->_render($this->_parents[$viewFile]);
			$this->assign('content', array_pop($this->_stack));
		}

		$remainingBlocks = count($this->Blocks->unclosed());

		if ($initialBlocks !== $remainingBlocks) {
			throw new CakeException(__d(
				'cake_dev',
				'The "%s" block was left open. Blocks are not allowed to cross files.',
				$this->Blocks->active()
			));
		}

		return $content;
	}

/**
 * Renders an element and fires the before and afterRender callbacks for it
 * and writes to the cache if a cache is used
 *
 * @param string $file Element file path
 * @param array $data Data to render
 * @param array $options Element options
 * @return string
 * @triggers View.beforeRender $this, array($file)
 * @triggers View.afterRender $this, array($file, $element)
 */
	protected function _renderElement($file, $data, $options) {
		$current = $this->_current;
		$restore = $this->_currentType;
		$this->_currentType = static::TYPE_ELEMENT;

		//if ($options['callbacks']) {
		//	$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array($file)));
		//}

		$element = $this->_render($file, array_merge($this->viewVars, $data));

		//if ($options['callbacks']) {
		//	$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array($file, $element)));
		//}

		$this->_currentType = $restore;
		$this->_current = $current;

		if (isset($options['cache'])) {
			Cache::write($this->elementCacheSettings['key'], $element, $this->elementCacheSettings['config']);
		}
		return $element;
	}

/**
 * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
 *
 * This realizes the concept of Elements, (or "partial layouts") and the $params array is used to send
 * data to be used in the element. Elements can be cached improving performance by using the `cache` option.
 *
 * @param string $name Name of template file in the/app/View/Elements/ folder,
 *   or `MyPlugin.template` to use the template element from MyPlugin. If the element
 *   is not found in the plugin, the normal view path cascade will be searched.
 * @param array $data Array of data to be made available to the rendered view (i.e. the Element)
 * @param array $options Array of options. Possible keys are:
 * - `cache` - Can either be `true`, to enable caching using the config in View::$elementCache. Or an array
 *   If an array, the following keys can be used:
 *   - `config` - Used to store the cached element in a custom cache configuration.
 *   - `key` - Used to define the key used in the Cache::write(). It will be prefixed with `element_`
 * - `plugin` - (deprecated!) Load an element from a specific plugin. This option is deprecated, and
 *              will be removed in CakePHP 3.0. Use `Plugin.element_name` instead.
 * - `callbacks` - Set to true to fire beforeRender and afterRender helper callbacks for this element.
 *   Defaults to false.
 * - `ignoreMissing` - Used to allow missing elements. Set to true to not trigger notices.
 * @return string Rendered Element
 */
	public function element($name, $data = array(), $options = array()) {
		$file = $plugin = null;

		//if (isset($options['plugin'])) {
		//	$name = Inflector::camelize($options['plugin']) . '.' . $name;
		//}

		//if (!isset($options['callbacks'])) {
		//	$options['callbacks'] = false;
		//}

		if (isset($options['cache'])) {
			$contents = $this->_elementCache($name, $data, $options);
			if ($contents !== false) {
				return $contents;
			}
		}

		$file = $this->_getElementFilename($name);
		if ($file) {
			$contents = $this->_renderElement($file, $data, $options);
			return $contents;
		}

		if (empty($options['ignoreMissing'])) {
			list ($plugin, $name) = pluginSplit($name, true);
			$name = str_replace('/', DS, $name);
			$file = $plugin . 'Elements' . DS . $name . $this->ext;
			trigger_error(__d('cake_dev', 'Element Not Found: %s', $file), E_USER_NOTICE);
		}
	}

/**
 * Renders view for given view file and layout.
 *
 * Render triggers helper callbacks, which are fired before and after the view are rendered,
 * as well as before and after the layout. The helper callbacks are called:
 *
 * - `beforeRender`
 * - `afterRender`
 * - `beforeLayout`
 * - `afterLayout`
 *
 * If View::$autoRender is false and no `$layout` is provided, the view will be returned bare.
 *
 * View and layout names can point to plugin views/layouts. Using the `Plugin.view` syntax
 * a plugin view/layout can be used instead of the app ones. If the chosen plugin is not found
 * the view will be located along the regular view path cascade.
 *
 * @param false|string $view Name of view file to use.
 * @param string $layout Layout to use.
 * @return string|null Rendered content or null if content already rendered and returned earlier.
 * @triggers View.beforeRender $this, array($viewFileName)
 * @triggers View.afterRender $this, array($viewFileName)
 * @throws CakeException If there is an error in the view.
 */
	public function render($view = null, $layout = null) {
		if ($this->hasRendered) {
			return null;
		}

		if ($view !== false && $viewFileName = $this->_getViewFileName($view)) {
			$this->_currentType = static::TYPE_VIEW;
			//$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array($viewFileName)));
			$this->Blocks->set('content', $this->_render($viewFileName));
			//$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array($viewFileName)));
		}

		if ($layout === null) {
			$layout = $this->layout;
		}
		if ($layout && $this->autoLayout) {
			$this->Blocks->set('content', $this->renderLayout('', $layout));
		}
		$this->hasRendered = true;
		return $this->Blocks->get('content');
	}

/**
 * Renders a layout. Returns output from _render(). Returns false on error.
 * Several variables are created for use in layout.
 *
 * - `title_for_layout` - A backwards compatible place holder, you should set this value if you want more control.
 * - `content_for_layout` - contains rendered view file
 * - `scripts_for_layout` - Contains content added with addScript() as well as any content in
 *   the 'meta', 'css', and 'script' blocks. They are appended in that order.
 *
 * Deprecated features:
 *
 * - `$scripts_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the block features instead. `meta`, `css` and `script` will be populated
 *   by the matching methods on HtmlHelper.
 * - `$title_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the `title` block instead.
 * - `$content_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the `content` block instead.
 *
 * @param string $content Content to render in a view, wrapped by the surrounding layout.
 * @param string $layout Layout name
 * @return mixed Rendered output, or false on error
 * @triggers View.beforeLayout $this, array($layoutFileName)
 * @triggers View.afterLayout $this, array($layoutFileName)
 * @throws CakeException if there is an error in the view.
 */
	public function renderLayout($content, $layout = null) {
		$layoutFileName = $this->_getLayoutFileName($layout);
		if (empty($layoutFileName)) {
			return $this->Blocks->get('content');
		}

		if (empty($content)) {
			$content = $this->Blocks->get('content');
		} else {
			$this->Blocks->set('content', $content);
		}
		//$this->getEventManager()->dispatch(new CakeEvent('View.beforeLayout', $this, array($layoutFileName)));

		$scripts = implode("\n\t", $this->_scripts);
		$scripts .= $this->Blocks->get('meta') . $this->Blocks->get('css') . $this->Blocks->get('script');

		$this->viewVars = array_merge($this->viewVars, array(
			'content_for_layout' => $content,
			'scripts_for_layout' => $scripts,
		));

		$title = $this->Blocks->get('title');
		if ($title === '') {
			if (isset($this->viewVars['title_for_layout'])) {
				$title = $this->viewVars['title_for_layout'];
			} else {
				$title = Inflector::humanize($this->viewPath);
			}
		}
		$this->viewVars['title_for_layout'] = $title;
		$this->Blocks->set('title', $title);

		$this->_currentType = static::TYPE_LAYOUT;
		$this->Blocks->set('content', $this->_render($layoutFileName));

		//$this->getEventManager()->dispatch(new CakeEvent('View.afterLayout', $this, array($layoutFileName)));
		return $this->Blocks->get('content');
	}

}
