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
App::uses('Current', 'NetCommons.Utility');

/**
 * NetCommonsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller
 */
class NetCommonsAppController extends Controller {

/**
 * alert
 *
 * @var string
 */
	const ALERT_SUCCESS_INTERVAL = 1500,
		ALERT_VALIDATE_ERROR_INTERVAL = 4000;

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
		'DebugKit.Toolbar',
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'index' => null,
				'view' => null,
			),
		),
		'RequestHandler',
		'Session',
		'Workflow.Workflow',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = [
		'M17n.Language',
		'NetCommons.SiteSetting',
	];

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Html' => array(
			'className' => 'NetCommons.SingletonViewBlockHtml'
		),
		'NetCommons.BackHtml',
		'NetCommons.Button',
		'NetCommons.Date',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * 後で削除
 *
 * NetCommons specific data for current request
 *
 * @var array
 */
	//public $current = [
	//	'Page' => null,
	//];

/**
 * Constructor.
 *
 * @param CakeRequest $request Request object for this controller. Can be null for testing,
 *  but expect that features that use the request parameters will not work.
 * @param CakeResponse $response Response object for this controller.
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

		if (in_array('Html', $this->helpers, true) &&
				!isset($this->helpers['Html']['className'])) {
			$this->helpers['Html']['className'] = 'NetCommons.SingletonViewBlockHtml';
		}
	}

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		Security::setHash('sha512');
		if (! Configure::read('NetCommons.installed') && $this->params['plugin'] === 'install') {
			return;
		}

		//言語の取得
		if (isset($this->request->query['language'])) {
			Configure::write('Config.language', $this->request->query['language']);
			$this->Session->write('Config.language', $this->request->query['language']);
		} elseif ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		}

		//カレントデータセット
		Current::initialize($this->request);

		//現在のテーマを取得(後で、見直しが必要)
		if (empty($this->request->params['requested'])) {
			$theme = $this->Asset->getSiteTheme($this);
			if ($theme) {
				$this->theme = $theme;
			}
		}

		//後で削除
		//if (isset($this->request->query['language'])) {
		//	Configure::write('Config.language', $this->request->query['language']);
		//	$this->Session->write('Config.language', $this->request->query['language']);
		//} elseif ($this->Session->check('Config.language')) {
		//	Configure::write('Config.language', $this->Session->read('Config.language'));
		//}
		////set language_id
		//$language = $this->Language->findByCode(Configure::read('Config.language'));
		Configure::write('Config.languageId', Current::read('Language.id')); //後で削除
		$this->set('languageId', Current::read('Language.id')); //後で削除

		$this->Auth->allow('index', 'view');

		if ($this->RequestHandler->accepts('json')) {
			$this->renderJson();
		}

		$this->set('userId', $this->Auth->user('id'));

		//後で削除
		//$results = $this->camelizeKeyRecursive(['current' => $this->current]);
		//$this->set(['current' => $this->current]);
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
		if (! $errors) {
			return true;
		}

		$this->validationErrors = $errors;

		$message = __d('net_commons', 'Failed on validation errors. Please check the input data.');
		CakeLog::info('[ValidationErrors] ' . $this->request->here());
		if (Configure::read('debug')) {
			CakeLog::info(print_r($errors, true));
			//CakeLog::info(print_r($this->request->data, true));
		}

		$this->setFlashNotification($message, array(
			'class' => 'danger',
			'interval' => self::ALERT_VALIDATE_ERROR_INTERVAL,
			'error' => ['validationErrors' => $errors]
		), 400);
		return false;
	}

/**
 * 後で削除
 * Redirect by frame id
 *
 * @return void
 */
	//public function redirectByFrameId() {
	//	if (! $this->request->is('ajax')) {
	//		$this->redirect('/' . Current::read('Page.permalink'));
	//	}
	//}

/**
 * throw bad request
 *
 * @param string $message Error message
 * @return void
 * @throws BadRequestException
 */
	public function throwBadRequest($message = null) {
		if (! isset($message)) {
			$message = __d('net_commons', 'Bad Request');
		}

		if ($this->request->is('ajax')) {
			$this->setFlashNotification(__d('net_commons', 'Bad Request'), array(
				'class' => 'danger',
				'interval' => self::ALERT_VALIDATE_ERROR_INTERVAL,
				'error' => $message
			), 400);
		} else {
			throw new BadRequestException($message);
		}
	}

/**
 * Used to set a session variable that can be used to output messages in the view.
 *
 * @param string $message message
 * @param array $params Parameters to be sent to layout as view variables
 * @param int $status status code
 * @return void
 */
	public function setFlashNotification($message, $params = array(), $status = 200) {
		if (is_string($params)) {
			$params = array('class' => $params);
		}

		if (isset($params['element'])) {
			$element = $params['element'];
			unset($params['element']);
		} else {
			$element = 'common_alert';
		}

		$params = Hash::merge(array(
			'class' => 'danger',
			'interval' => null,
			'plugin' => 'NetCommons',
		), $params);

		if ($params['interval'] === null && $params['class'] !== 'danger') {
			$params['interval'] = self::ALERT_SUCCESS_INTERVAL;
		}

		if ($this->request->is('ajax')) {
			$this->renderJson($params, $message, $status);
		} else {
			$this->Session->setFlash($message, $element, $params);
		}
	}

}
