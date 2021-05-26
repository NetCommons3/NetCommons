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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class NetCommonsExceptionRenderer extends ExceptionRenderer {

/**
 * エラーのインターバル
 *
 * @var int
 */
	const HTML_INTERVAL = 4000,
		JSON_INTERVAL = 6000;

/**
 * Exceptionが発生した場合、ExceptionRenderer.phpでは、
 * CakeErrorController::startupProcessを呼んでいるため、PermissionComponentが２度処理されてしまう。
 * NC3ではCakeErrorController::startupProcessを呼ぶ必要がないので、
 * オーバライドして、startupProcessを呼ばないようにする。
 *
 * 例）
 * １．アクセス不可の画面にログインなしで呼ぶ。
 * ２．PermissionComponentで設定画面のアクセスチェックが実行され、エラーとなり、ForbiddenExceptionをthrowする。
 * ３．ExcepitonRendererがnewされ、ExceptionRendererの__construct()が呼ばれる。
 * ４．下記で、CakeErrorControllerがnewされ、startupProcess()が実行される。
 * 　　CakeErrorControllerがAppController(NetCommonsAppController)を継承していて、そこで設定されているPermissionComponentが再度呼ばれる。
 * 　　https://github.com/cakephp/cakephp/blob/2.10.15/lib/Cake/Error/ExceptionRenderer.php#L157-L159
 * ５．４は、try cacheされてるので、４のPermissionComponentのExceptionは、無視され、処理が継続され、error400()が実行される。
 *
 * @param Exception $exception The exception to get a controller for.
 * @return Controller
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	protected function _getController($exception) {
		App::uses('AppController', 'Controller');
		App::uses('CakeErrorController', 'Controller');
		if (!$request = Router::getRequest(true)) {
			$request = new CakeRequest();
		}
		$response = new CakeResponse();

		if (method_exists($exception, 'responseHeader')) {
			$response->header($exception->responseHeader());
		}

		if (class_exists('AppController')) {
			try {
				$controller = new CakeErrorController($request, $response);
				//$controller->startupProcess();
				$startup = true;
			} catch (Exception $e) {
				$startup = false;
			}
			// Retry RequestHandler, as another aspect of startupProcess()
			// could have failed. Ignore any exceptions out of startup, as
			// there could be userland input data parsers.
			if ($startup === false &&
				!empty($controller) &&
				$controller->Components->enabled('RequestHandler')
			) {
				try {
					$controller->RequestHandler->startup($controller);
				} catch (Exception $e) {
				}
			}
		}
		if (empty($controller)) {
			$controller = new Controller($request, $response);
			$controller->viewPath = 'Errors';
		}
		return $controller;
	}

/**
 * Convenience method to display a 400 series page.
 *
 * @param Exception $error Exception
 * @return void
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function error400($error) {
		$message = $error->getMessage();
		$this->controller->response->statusCode($error->getCode());

		if ($message === 'Not found file') {
			$this->controller->autoRender = false;
			$this->_shutdown();
			$this->controller->response->send();
			return;

		} elseif ($message === 'Bad ip address') {
			$this->controller->Session->destroy();
			$redirect = null;

		} elseif ($message === 'Under maintenance') {
			$redirect = '/net_commons/site_close/index';
			$this->controller->Session->destroy();

		} elseif ($message === 'The request has been black-holed' ||
				get_class($error) === 'BadRequestException') {
			$redirect = $this->controller->request->referer(true);

		} elseif ($this->_is403And404And408($error)) {
			list($redirect, $redirectUrl) = $this->_get403And404Redirect();
			if (! $this->controller->request->is('ajax') &&
					$this->__loadedAuthComponent()) {
				$this->controller->Auth->redirectUrl($redirectUrl);
			}

		} else {
			$redirect = '/';
			$this->controller->Session->destroy();
		}
		if (isset($redirect)) {
			$redirect = Router::url($redirect);
		}

		$results = array(
			'message' => $this->_get400Message($error),
			'redirect' => $redirect,
		);
		$this->_setError('NetCommons.error400', $error, $results);
	}

/**
 * エラーメッセージ取得
 *
 * @param Exception $error Exception
 * @return string $message
 */
	protected function _get400Message($error) {
		$message = $error->getMessage();
		if (! Configure::read('debug') && $error instanceof CakeException) {
			$message = 'Not Found';
		}

		if ($message === 'Under maintenance') {
			$message = __d(
				'net_commons', 'Under maintenance. Nobody is allowed to login except for administrators.'
			);
		} elseif ($message === 'Forbidden') {
			if ($this->__isLoggedIn()) {
				$message = __d('net_commons', 'Permission denied. Bad account.');
			} else {
				$message = __d('net_commons', 'Permission denied. You must be logged.');
			}
		} else {
			$message = __d('net_commons', $message);
		}

		return nl2br(h($message));
	}

/**
 * 403か404,408のエラーかチェックする
 *
 * @param Exception $error Exception
 * @return bool
 */
	protected function _is403And404And408($error) {
		return $error->getCode() === 403 ||
				$error->getCode() === 404 ||
				$error->getCode() === 408 ||
				get_class($error) === 'MissingControllerException';
	}

/**
 * リダイレクトURLを取得する。
 *
 * @return array array($redirect, $redirectUrl)
 */
	protected function _get403And404Redirect() {
		if ($this->__isLoggedIn()) {
			$referer = Router::parse($this->controller->request->referer(true));
			$here = Router::parse($this->controller->request->here(false));

			if ((isset($referer['action']) && $referer['action'] === 'login') ||
				(isset($here['action']) && $here['action'] === 'login')) {
				//テストでMockに差し替えが必要なための処理であるので、カバレッジレポートから除外する。
				//@codeCoverageIgnoreStart
				if (empty($this->SiteSetting)) {
					$this->SiteSetting = ClassRegistry::init('SiteManager.SiteSetting');
				}
				//@codeCoverageIgnoreEnd
				$redirect = $this->SiteSetting->getDefaultStartPage();
				$redirectUrl = $redirect;
			} else {
				$redirect = '/';
				$redirectUrl = '/';
			}
		} else {
			$redirect = '/auth/login';
			//$this->controller->Session->destroy();

			App::uses('Current', 'NetCommons.Utility');
			if (in_array($this->controller->params['action'], ['index', 'view'], true)) {
				$redirectUrl = $this->controller->request->here(false);
			} elseif (Current::read('Page.permalink')) {
				$redirectUrl = '/' . Current::read('Page.permalink');
			} else {
				$redirectUrl = '/';
			}
		}

		return array($redirect, $redirectUrl);
	}

/**
 * Authコンポーネントがロードされているか否か
 *
 * @return bool
 */
	private function __loadedAuthComponent() {
		return ! empty($this->controller->Auth);
	}

/**
 * ログインしているかいない
 *
 * @return bool
 */
	private function __isLoggedIn() {
		return $this->__loadedAuthComponent() && $this->controller->Auth->user();
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
			$code = 500;
		} else {
			// @see ExceptionRenderer::error500()
			$code = ($error->getCode() > 500 && $error->getCode() < 506) ? $error->getCode() : 500;
		}

		$this->controller->response->statusCode($code);

		$results = array(
			'code' => $code,
			'message' => h($message),
		);
		$this->_setError('NetCommons.error500', $error, $results);
	}

/**
 * エラーをコントローラにセット
 *
 * @param string $template viewテンプレート
 * @param Exception $error Exception
 * @param array $results viewにセットする配列
 * @return void
 */
	protected function _setError($template, $error, $results) {
		$url = $this->controller->request->here();

		$errorCode = $error->getCode();
		$exceptionName = get_class($error);

		$results = array_merge(array(
			'code' => $errorCode,
			'name' => $this->_getName($errorCode, $exceptionName),
			'url' => h($url),
			'class' => 'danger',
		), $results);

		if ($this->controller->request->is('ajax')) {
			$this->controller->viewClass = 'Json';
			$this->controller->layout = false;
			if (Configure::read('debug')) {
				$results['error'] = ['trace' => explode("\n", $error->getTraceAsString())];
			}
			$results['interval'] = self::JSON_INTERVAL;
		} else {
			$this->controller->layout = 'NetCommons.error';
			$this->controller->autoLayout = true;
			$results['error'] = $error;
			$results['interval'] = self::HTML_INTERVAL;
		}

		$this->controller->set($results);
		$this->controller->set(
			'_serialize',
			['message', 'code', 'name', 'url', 'class', 'interval', 'error', 'redirect']
		);

		$this->_outputMessage($template);
	}

/**
 * エラー名取得
 *
 * @param int $errorCode エラーコード
 * @param string $exceptionName Exceptionクラス名
 * @return string
 */
	protected function _getName($errorCode, $exceptionName) {
		if (! Configure::read('debug')) {
			if ($errorCode === 401) {
				$name = 'Unauthorixed';
			} elseif ($errorCode === 403) {
				$name = 'Forbidden';
			} elseif ($errorCode === 404) {
				$name = 'Not Found';
			} elseif ($errorCode >= 400 && $errorCode < 418) {
				$name = 'Bad Request';
			} else {
				//500番台
				$name = 'Internal Server Error';
			}
		} else {
			$name = preg_replace('/Exception$/', '', $exceptionName);
			if ($name === '') {
				$name = $exceptionName;
			}
			$name = Inflector::humanize(Inflector::underscore($name));
		}

		return $name;
	}

}
