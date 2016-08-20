<?php
/**
 * Exception Renderer
 *
 * Provides Exception rendering features. Which allow exceptions to be rendered
 * as HTML pages.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @since CakePHP(tm) v 2.0
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Sanitize', 'Utility');
App::uses('Router', 'Routing');
App::uses('CakeResponse', 'Network');
App::uses('Controller', 'Controller');
App::uses('Error', 'ExceptionRenderer');

/**
 * Exception Renderer.
 *
 * Captures and handles all unhandled exceptions. Displays helpful framework errors when debug > 1.
 * When debug < 1 a CakeException will render 404 or 500 errors. If an uncaught exception is thrown
 * and it is a type that ExceptionHandler does not know about it will be treated as a 500 error.
 *
 * ### Implementing application specific exception rendering
 *
 * You can implement application specific exception handling in one of a few ways:
 *
 * - Create a AppController::appError();
 * - Create a subclass of YAExceptionRenderer and configure it to be the `Exception.renderer`
 *
 * #### Using AppController::appError();
 *
 * This controller method is called instead of the default exception handling. It receives the
 * thrown exception as its only argument. You should implement your error handling in that method.
 *
 * #### Using a subclass of YAExceptionRenderer
 *
 * Using a subclass of YAExceptionRenderer gives you full control over how Exceptions are rendered, you
 * can configure your class in your core.php, with `Configure::write('Exception.renderer', 'MyClass');`
 * You should place any custom exception renderers in `app/Lib/Error`.
 *
 * @package  NetCommons\NetCommons\Error
 */
class NetCommonsExceptionRenderer extends ExceptionRenderer {

/**
 * Convenience method to display a 400 series page.
 *
 * @param Exception $error Exception
 * @return void
 */
	public function error400($error) {
		$message = $error->getMessage();
		if (! Configure::read('debug') && $error instanceof CakeException) {
			$message = __d('net_commons', 'Not Found');
		}
		$this->controller->response->statusCode($error->getCode());

		if ($message === 'The request has been black-holed') {
			$message = __d('net_commons', 'The request has been black-holed');
			$redirect = $this->controller->request->referer(true);

		} elseif ($message === 'Permission denied' || $error->getCode() === 403) {
			list($redirect, $redirectUrl, $message) = $this->__get403And404Redirect();
			if (! $this->controller->request->is('ajax')) {
				$this->controller->Auth->redirectUrl($redirectUrl);
			}

		} else {
			$redirect = '/';
			$this->controller->Session->destroy();
		}

		$results = array(
			'message' => h($message),
			'redirect' => Router::url($redirect),
			'interval' => '3'
		);
		$this->__setError('NetCommons.error400', $error, $results);
	}

/**
 * リダイレクトURLを取得する。
 *
 * @return array array($redirect, $redirectUrl, $message)
 */
	private function __get403And404Redirect() {
		if ($this->controller->Auth->user()) {
			$message = __d('net_commons', 'Permission denied. Bad account.');
			$referer = Router::parse($this->controller->request->referer(true));
			$here = Router::parse($this->controller->request->here(false));

			if ($referer['action'] === 'login' || $here['action'] === 'login') {
				$SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
				$redirect = $SiteSetting->getDefaultStartPage();
				$redirectUrl = $redirect;
			} else {
				$redirect = '/';
				$redirectUrl = '/';
			}
		} else {
			$message = __d('net_commons', 'Permission denied. You must be logged.');
			$redirect = '/auth/login';
			$this->controller->Session->destroy();

			App::uses('Current', 'NetCommons.Utility');
			if (in_array($this->controller->params['action'], ['index', 'view'], true)) {
				$redirectUrl = $this->controller->request->here(false);
			} elseif (Current::read('Page.permalink')) {
				$redirectUrl = '/' . Current::read('Page.permalink');
			} else {
				$redirectUrl = '/';
			}
		}

		return array($redirect, $redirectUrl, $message);
	}

/**
 * Convenience method to display a 500 page.
 *
 * @param Exception $error Exception
 * @return void
 */
	public function error500($error) {
		$message = $error->getMessage();
		if (! Configure::read('debug')) {
			$message = __d('net_commons', 'An Internal Error Has Occurred.');
		}

		if ($error->getCode() > 500 && $error->getCode() < 506) {
			$code = $error->getCode();
		} else {
			$code = 500;
		}
		$this->controller->response->statusCode($code);

		$results = array(
			'message' => h($message),
		);
		$this->__setError('NetCommons.error500', $error, $results);
	}

/**
 * エラーをコントローラにセット
 *
 * @param string $template viewテンプレート
 * @param Exception $error Exception
 * @param array $results viewにセットする配列
 * @return void
 */
	private function __setError($template, $error, $results) {
		$url = $this->controller->request->here();

		$name = preg_replace('/Exception$/', '', get_class($error));
		if ($name === '') {
			$name = get_class($error);
		}

		$results = Hash::merge(array(
			'code' => $error->getCode(),
			'name' => Inflector::humanize(Inflector::underscore($name)),
			'url' => h($url),
		), $results);

		if ($this->controller->request->is('ajax')) {
			$this->controller->viewClass = 'Json';
			$this->controller->layout = false;
			if (Configure::read('debug')) {
				$results['error'] = ['trace' => explode("\n", $error->getTraceAsString())];
			}
			$this->controller->set(compact('results'));
		} else {
			$this->controller->layout = 'NetCommons.error';
			$results['error'] = $error;
			$this->controller->set($results);
		}
		$this->controller->set('_serialize', 'results');

		$this->_outputMessage($template);
	}

}
