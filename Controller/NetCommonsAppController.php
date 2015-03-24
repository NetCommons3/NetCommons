<?php
/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Controller', 'Controller');
App::uses('Utility', 'Inflector');

/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller
 */
class NetCommonsAppController extends Controller {

/**
 * use layout
 *
 * @var string
 */
	public $layout = 'NetCommons.default';

/**
 * use theme
 *
 * @var string
 */
	public $theme = 'default';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'Asset',
		'Auth' => array(
			'loginAction' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			),
			'loginRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			),
			'logoutRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			)
		),
		'RequestHandler',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = [
		'Boxes.Box',
		'SiteSetting',
		'Pages.Page',
		'Frames.Frame',
	];

/**
 * View class name that is used for singleton helper
 *
 * @var string
 */
	public $viewClass = 'NetCommons.SingletonHelper';

/**
 * NetCommons specific data for current request
 *
 * @var array
 */
	public $current = [
		'page' => null,
	];

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		if (Configure::read('NetCommons.installed')) {
			//現在のテーマを取得
			$theme = $this->Asset->getSiteTheme($this);
			if ($theme) {
				$this->theme = $theme;
			}
		}
		if (isset($this->request->query['language'])) {
			Configure::write('Config.language', $this->request->query['language']);
			$this->Session->write('Config.language', $this->request->query['language']);
		} elseif ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		}
		$this->Auth->allow('index', 'view');
		Security::setHash('sha512');

		if ($this->RequestHandler->accepts('json')) {
			$this->renderJson();
		}

		// Find page data from frame
		if ($this->NetCommonsFrame && $this->NetCommonsFrame->data) {
			$box = $this->Box->find('first', [
				'conditions' => [
					'Box.id' => $this->NetCommonsFrame->data['Box']['id'],
				],
			]);
			if (isset($box['Page'][0])) {
				$this->current['page'] = $box['Page'][0];
			}
		}
	}

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		//theme css指定
		$this->set('bootstrapMinCss', $this->Asset->isThemeBootstrapMinCss($this));
	}

/**
 * The beforeRedirect method is invoked when the controller's redirect method is called but before any
 * further action.
 *
 * If this method returns false the controller will not continue on to redirect the request.
 * The $url, $status and $exit variables have same meaning as for the controller's method. You can also
 * return a string which will be interpreted as the URL to redirect to or return associative array with
 * key 'url' and optionally 'status' and 'exit'.
 *
 * @param string|array $url A string or array-based URL pointing to another location within the app,
 *     or an absolute URL
 * @param int $status Optional HTTP status code (eg: 404)
 * @param bool $exit If true, exit() will be called after the redirect
 * @return mixed
 *   false to stop redirection event,
 *   string controllers a new redirection URL or
 *   array with the keys url, status and exit to be used by the redirect method.
 * @throws Exception
 * @link http://book.cakephp.org/2.0/en/controllers.html#request-life-cycle-callbacks
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeRedirect($url, $status = null, $exit = true) {
		if ($url === null && $status >= 400) {
			//Auth->allowによるエラーにメッセージが含まれない
			$error = $this->response->httpCodes($status);
			throw new Exception(__d('net_commons', $error[$status]), $status);
		}
		return parent::beforeRedirect($url, $status, $exit);
	}

/**
 * Keep connection alive
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return void
 **/
	public function ping() {
		$this->set('result', array('message' => 'OK'));
		$this->set('_serialize', array('result'));
	}

/**
 * render json
 *
 * @param array $results results data
 * @param string $name message
 * @param int $status status code
 * @return void
 */
	public function renderJson($results = [], $name = 'OK', $status = 200) {
		$this->viewClass = 'Json';
		$this->layout = false;
		$this->response->statusCode($status);
		if (!$results) {
			$results = $this->viewVars;
		}
		$results = array_merge([
			'name' => $name,
			'code' => $status,
		], $results);
		$results = self::camelizeKeyRecursive($results);
		$this->set(compact('results'));
		$this->set('_serialize', 'results');
	}

/**
 * camelizeKeyRecursive
 *
 * @param array $orig data to camelize
 * @return array camelized data
 */
	public static function camelizeKeyRecursive($orig) {
		$new = [];
		$callback = ['Inflector', 'variable'];

		foreach ($orig as $key => $value) {
			if (is_array($value)) {
				$new[call_user_func($callback, $key)] = self::camelizeKeyRecursive($value);
			} else {
				$new[call_user_func($callback, $key)] = $value;
			}
		}

		return $new;
	}

/**
 * Handle validation error
 *
 * @param array $errors validation errors
 * @return bool true on success, false on error
 */
	public function handleValidationError($errors) {
		if ($errors) {
			$this->validationErrors = $errors;
			if ($this->request->is('ajax')) {
				$results = ['error' => ['validationErrors' => $errors]];
				$this->renderJson($results, __d('net_commons', 'Bad Request'), 400);
			}
			return false;
		}

		return true;
	}

/**
 * Redirect by frame id
 *
 * @return void
 */
	public function redirectByFrameId() {
		if (!$this->request->is('ajax')) {
			$this->redirect('/' . $this->current['page']['permalink']);
		}
	}
}
