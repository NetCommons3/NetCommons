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
			Cache::write(
				$this->elementCacheSettings['key'],
				$element,
				$this->elementCacheSettings['config']
			);
		}
		return $element;
	}

}
