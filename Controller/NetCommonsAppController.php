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
//App::uses('Current', 'NetCommons.Utility');
App::uses('NetCommonsUrl', 'NetCommons.Utility');
App::uses('PermissionComponent', 'NetCommons.Controller/Component');
App::uses('SiteSettingUtil', 'SiteManager.Utility');
App::uses('User', 'Users.Model');

App::uses('CurrentLib', 'NetCommons.Lib');

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
		'NetCommons.AccessCtrl',
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
			),
			'passwordHasher' => [
				'className' => 'Simple',
				'hashType' => User::PASSWORD_HASH_TYPE,
			],
		),
		'DebugKit.Toolbar',
		'Flash',
		'MobileDetect.MobileDetect',
		'NetCommons.Asset',
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'index' => null,
				'view' => null,
			),
		),
		'NetCommons.NetCommons',
		'NetCommons.NetCommonsTime',
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
		'M17n.M17n',
		'NetCommons.BackTo',
		'NetCommons.Button',
		'NetCommons.LinkButton',
		'NetCommons.Date',
		'NetCommons.MessageFlash',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * リクエストの許可メソッド
 *
 * @var array
 */
	protected $_allowMethods = [
		'get', 'post', 'put', 'delete'
	];

/**
 * Constructor.
 *
 * @param CakeRequest $request Request object for this controller. Can be null for testing,
 *  but expect that features that use the request parameters will not work.
 * @param CakeResponse $response Response object for this controller.
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

		//Cakeでは、$uses,$component,$helpersが直近の継承しているものしか読み込まれないため、
		//継承している親クラス全てを読み込む
		$parentClass = get_class($this);
		while ($parentClass = get_parent_class($parentClass)) {
			$this->_mergeVars(['uses', 'components', 'helpers'], $parentClass, false);
		}

		if (in_array('Html', $this->helpers, true) &&
				!isset($this->helpers['Html']['className'])) {
			$this->helpers['Html']['className'] = 'NetCommons.SingletonViewBlockHtml';
		}

		//サイトの設定データセット
		if (Configure::read('NetCommons.installed')) {
			SiteSettingUtil::initialize();
		}
	}

/**
 * 事前準備
 *
 * @return void
 */
	private function __prepare() {
		if (Current::read('Block') &&
				! $this->Components->loaded('NetCommons.Permission')) {
			$this->Components->load('NetCommons.Permission');
		}

		//現在のテーマを取得
		$theme = $this->Asset->getSiteTheme($this);
		if ($theme) {
			$this->theme = $theme;
		}

		if ($this->RequestHandler->accepts('json')) {
			$this->viewClass = 'Json';
			$this->layout = false;
		}

		if (in_array($this->params['action'], ['emptyRender', 'throwBadRequest', 'emptyFrame'])) {
			$this->params['pass'] = array();
		}
	}

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if (empty($this->request->params['requested'])) {
			$this->request->allowMethod($this->_allowMethods);
		}

		Security::setHash('sha512');

		//言語のセット
		$this->_setLanguage();

$startTime = microtime(true);
		//カレントデータセット
//		Current::initialize($this);
		$instance = CurrentLib::getInstance();
		$instance->initialize($this);

//$debug = CurrentLib::$current;
//ksort($debug);
//CakeLog::debug(__METHOD__ . '(' . __LINE__ . ') ' . var_export($debug, true));
//$debug = NcPermission::$permission;
//ksort($debug);
//CakeLog::debug(__METHOD__ . '(' . __LINE__ . ') ' . var_export($debug, true));
$endTime = microtime(true);
CakeLog::debug(__METHOD__ . '(' . __LINE__ . ') ' . var_export(($endTime - $startTime), true));

		if (! $this->AccessCtrl->allowAccess()) {
			return;
		}

		$this->Auth->allow('index', 'view', 'emptyRender', 'download', 'throwBadRequest', 'emptyFrame');

		if ($this->Components->loaded('Security')) {
			$this->Components->Security->csrfExpires = '+' .
				SiteSettingUtil::read('Session.ini.[session.gc_maxlifetime]') .
				' second';
		}

		$this->__prepare();

		//モバイルかどうかの判定処理
		if (Configure::read('isMobile') === null) {
			Configure::write('isMobile', $this->MobileDetect->detect('isMobile'));
		}

		if ($this->params['plugin'] !== 'frames' &&
				Current::read('Frame.id') && ! Current::read('FramePublicLanguage.is_public')) {
			return $this->setAction('emptyFrame');
		}
	}

/**
 * Called after the controller action is run and rendered.
 *
 * @return void
 * @link http://book.cakephp.org/2.0/ja/controllers.html#request-life-cycle-callbacks
 */
	public function afterFilter() {
//		//カレントデータセット
//		Current::terminate($this);
		parent::afterFilter();
	}

/**
 * リクエストもしくはSessionから言語をセットする。
 *
 * @return void
 */
	protected function _setLanguage() {
		if (isset($this->request->query['lang']) &&
				! array_key_exists('search', $this->request->query)) {
			Configure::write('Config.language', $this->request->query['lang']);
			$this->Session->write('Config.language', $this->request->query['lang']);

		} elseif ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		}

		//多言語の切り替えボックス
		$languages = $this->Language->getLanguages();
		$this->set('switchLanguages', $languages);

		$this->set('hasSwitchLang', count($languages) > 1);
	}

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		//theme css指定
		$this->set('bootstrapMinCss', $this->Asset->isThemeBootstrapMinCss($this));

		$controller = Inflector::camelize($this->params['controller']);
		$pluginPath = Hash::get(App::path('View', Inflector::camelize($this->params['plugin'])), '0');
		$path = $pluginPath . $controller . DS . 'json' . DS . $this->view . '.ctp';

		if ($this->viewClass === 'Json' &&
				! isset($this->viewVars['_serialize']) && ! file_exists($path)) {
			$this->NetCommons->renderJson();
		}
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
 * camelizeKeyRecursive
 *
 * @param array $orig data to camelize
 * @return array camelized data
 */
	public static function camelizeKeyRecursive($orig) {
		$new = [];
		$callback = ['Inflector', 'variable'];

		foreach ($orig as $key => $value) {
			if ($key === 'validationErrors') {
				$new[$key] = $value;
			} elseif (is_array($value)) {
				$new[call_user_func($callback, $key)] = self::camelizeKeyRecursive($value);
			} else {
				$new[call_user_func($callback, $key)] = $value;
			}
		}

		return $new;
	}

/**
 * throw bad request
 *
 * @param string|null $message メッセージ
 * @return void
 * @throws BadRequestException
 */
	public function throwBadRequest($message = null) {
		if (! $message) {
			$message = __d('net_commons', 'Bad Request');
		}

		if ($this->request->is('ajax')) {
			$this->NetCommons->setFlashNotification(__d('net_commons', 'Bad Request'), array(
				'class' => 'danger',
				'name' => 'Bad Request',
				'message' => $message,
				'interval' => NetCommonsComponent::ALERT_VALIDATE_ERROR_INTERVAL,
				'error' => $message
			), 400);
		} else {
			throw new BadRequestException($message);
		}
	}

/**
 * Empty render
 *
 * @return void
 */
	public function emptyRender() {
		$this->autoRender = false;
	}

/**
 * Empty render
 *
 * @return void
 */
	public function emptyFrame() {
		if (Current::isSettingMode() || $this->layout === 'NetCommons.setting') {
			$this->view = 'Frames.Frames/emptyRender';
		} else {
			$this->autoRender = false;
		}
	}

}
